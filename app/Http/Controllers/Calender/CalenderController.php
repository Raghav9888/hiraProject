<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class CalenderController extends Controller
{
    public function showCalendar(): View
    {
        $user = Auth::user();

        return view('practitioner.calendar', [
            'user' => $user,
        ]);
    }

    public function getGoogleCalendarEvents()
    {
        $user = Auth::user();
        $googleAccount = GoogleAccount::where('user_id', $user->id)->first();

        if (!$googleAccount || !$googleAccount->refresh_token) {
            return response()->json(['error' => 'Google account not connected'], 401);
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
        $client->setAccessToken($googleAccount->access_token);

        // Refresh token if expired
        if ($client->isAccessTokenExpired()) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);

            if (isset($newToken['error'])) {
                return response()->json([
                    'error' => 'Reauthentication required',
                    'redirect_url' => route('redirect_to_google')
                ]);
            }

            $googleAccount->update([
                'access_token' => $newToken['access_token'],
                'refresh_token' => $newToken['refresh_token'] ?? $googleAccount->refresh_token,
                'expires_at' => now()->addSeconds($newToken['expires_in'] ?? 3600),
            ]);

            $client->setAccessToken($newToken);
        }

        try {
            $service = new Google_Service_Calendar($client);
            $events = $service->events->listEvents('primary');
            $userEvents = [];

            foreach ($events->getItems() as $event) {
                // **Check if it's a meeting**
                $isMeeting = false;

                //  Check if attendees exist (Meetings usually have attendees)
                if (!empty($event->getAttendees())) {
                    $isMeeting = true;
                }

                // Check if the event has a Google Meet link
                if (!empty($event->getHangoutLink())) {
                    $isMeeting = true;
                }

                //  Check if the title contains "Meeting"
                if (stripos($event->getSummary(), 'Meeting') !== false) {
                    $isMeeting = true;
                }

                //  Check if the description contains "Category: Meetings"
                $description = $event->getDescription() ?? '';
                if (stripos($description, 'Category: Meetings') !== false) {
                    $isMeeting = true;
                }

                // **Assign category based on detection**
                $category = $isMeeting ? 'Meetings' : ($event->getExtendedProperties()->private['category'] ?? 'default');

                // **Store event details**
                $userEvents[] = [
                    'id' => $event->getId(),
                    'title' => $event->getSummary(),
                    'description' => $description,
                    'start' => $event->getStart() ? ($event->getStart()->getDateTime() ?? $event->getStart()->getDate()) : null,
                    'end' => $event->getEnd() ? ($event->getEnd()->getDateTime() ?? $event->getEnd()->getDate()) : null,
                    'category' => $category,
                    'attendees' => $event->getAttendees() ?? [],
                    'meet_link' => $event->getHangoutLink() ?? null,
                ];
            }
            return response()->json($userEvents);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function upComingAppointments()
    {
        $user = Auth::user();
        $googleAccount = GoogleAccount::where('user_id', $user->id)->first();

        if (!$googleAccount || $googleAccount->access_token == null) {
            return;
        }

        // Get the response and extract JSON data
        $response = $this->getGoogleCalendarEvents();

        // Convert JSON response to array
        $events = json_decode($response->getContent(), true);

        // If decoding fails or error occurs, return an empty array
        if (!is_array($events)) {
            return ['events' => []];
        }

        $now = new \DateTime();
        $filterEvents = array_filter($events, function ($event) use ($now) {
            if (empty($event['start']) || empty($event['end'])) {
                return false;
            }

            $eventStart = new \DateTime($event['start']);
            return $eventStart >= $now;
        });

        return [
            'events' => array_values($filterEvents),
        ];
    }




}
