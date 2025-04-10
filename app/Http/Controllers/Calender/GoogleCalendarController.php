<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Carbon\Carbon;
use Google\Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google\Client;
use Google\Service\Calendar;
use Symfony\Component\HttpFoundation\Response;

class GoogleCalendarController extends Controller
{
    private function getClient()
    {
        $user = Auth::user();
        $googleAccount = GoogleAccount::where('user_id', $user->id)->first();

        if (!$googleAccount || !$googleAccount->refresh_token) {
            abort(403, "Google Calendar is not connected. Please reconnect your account.");
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google/calendar/credential.json'));
        $client->setAccessToken($googleAccount->access_token);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);
            $newToken = $client->getAccessToken();

            $googleAccount->update([
                'access_token' => $newToken['access_token'],
                'expires_at' => isset($newToken['expires_in']) && $newToken['expires_in']
                    ? now()->addSeconds($newToken['expires_in'])
                    : null,
            ]);

        }

        return $client;
    }

    public function createEvent(Request $request)
    {

        // Validate request data
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start_time',
            'date' => 'required|date',
        ]);


        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'date' => $request->date,
        ];

        try {
            $this->createGoogleEvent($data);
            return back()->with('success', 'Event added to Google Calendar!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add event: ' . $e->getMessage());
        }
    }

    public function createGoogleEvent($data)
    {
        try {
            $googleAccount = GoogleAccount::where('user_id', $data['user_id'])->firstOrFail();
            $accessToken = json_decode($googleAccount->access_token, true);

            // Initialize Google Client
            $client = new Google_Client();
            $client->setAuthConfig(storage_path('app/google/calendar/credential.json'));
            $client->setAccessToken($accessToken);

            // Refresh token if expired
            if ($client->isAccessTokenExpired()) {
                if (!empty($googleAccount->refresh_token)) {
                    $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);
                    $newAccessToken = $client->getAccessToken();
                    $googleAccount->access_token = json_encode($newAccessToken);
                    $googleAccount->save();
                } else {
                    throw new \Exception('Google Token Expired. Please reauthorize.');
                }
            }

            // Initialize Google Calendar service
            $calendarService = new Google_Service_Calendar($client);

            // Create Event
            $event = new Google_Service_Calendar_Event([
                'summary'     => $data['title'],
                'description' => $data['description'],
                'start'       => [
                    'dateTime' => Carbon::parse($data['start'])->toIso8601String(),
                    'timeZone' =>  $data['timezone']?? 'America/Vancouver',
                ],
                'end'         => [
                    'dateTime' => Carbon::parse($data['end'])->toIso8601String(),
                    'timeZone' => $data['timezone'] ?? 'America/Vancouver',
                ],
                'extendedProperties' => [
                    'private' => [
                        'category' => $data['category'],
                    ]
                ],
            ]);

            // Insert event into Google Calendar
            $calendarService->events->insert('primary', $event);

            return response('Event added to Google Calendar!', 200);

        } catch (\Exception $e) {
            \Log::error('Google Calendar API Error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }


    public function updateEvent(Request $request)
    {
        // Validate request data
        $request->validate([
            'event_id' => 'required|string',
            'title' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);

        try {

            $event = $service->events->get('primary', $request->event_id);

            // ✅ Update event details
            $event->setSummary($request->title);
            $event->setDescription($request->description);

            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime(date('c', strtotime($request->start)));
            $start->setTimeZone('America/Vancouver');
            $event->setStart($start);

            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime(date('c', strtotime($request->end)));
            $end->setTimeZone('America/Vancouver');
            $event->setEnd($end);

            $updatedEvent = $service->events->update('primary', $request->event_id, $event);

            return response()->json([
                'message' => 'Event updated successfully in Google Calendar!',
                'updated_event' => $updatedEvent
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update event: ' . $e->getMessage()
            ], 500);
        }
    }



    public function deleteEvent(Request $request)
    {
        if (!$request->event_id) {
            return back()->with('error', 'Event ID is required');
        }

        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);

        try {
            $service->events->delete('primary', $request->event_id);
            return back()->with('success', 'Event deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete event: ' . $e->getMessage());
        }
    }

    public function getBookedSlots(Request $request, $userId)
    {
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User ID is required.',
            ], 400);
        }

        try {
            $bookedSlots = $this->fetchGoogleCalendarEvents($userId);

            return response()->json([
                'status' => 'success',
                'bookedDates' => $bookedSlots,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error fetching booked slots: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch booked slots. Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Fetch Google Calendar events, excluding HiraCollective bookings.
     *
     * @throws Exception
     * @throws \Google\Service\Exception
     */
    private function fetchGoogleCalendarEvents($userId)
    {

        $googleAccount = GoogleAccount::where('user_id', $userId)->first();

        if (!$googleAccount) {
            throw new \Exception('No Google account linked for this user.');
        }

        $accessToken = $googleAccount->access_token;

        // If access_token is a JSON object (e.g., contains access_token, expires_in, etc.)
        if (is_string($accessToken) && str_starts_with(trim($accessToken), '{')) {
            $accessToken = json_decode($accessToken, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON token: ' . json_last_error_msg());
            }
        }

        $client = new \Google_Client();

        $credentialsPath = storage_path('app/google/calendar/credential.json');
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Google credentials file is missing.');
        }

        $client->setAuthConfig($credentialsPath);
        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            if (!empty($googleAccount->refresh_token)) {
                $newAccessToken = $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);

                if (isset($newAccessToken['error'])) {
                    throw new Exception('Failed to refresh access token: ' . $newAccessToken['error_description']);
                }

                $googleAccount->access_token = json_encode($newAccessToken);
                $googleAccount->save();
                $client->setAccessToken($newAccessToken);
            } else {
                throw new Exception('Google Token Expired. Please reauthorize.');
            }
        }

        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $now = Carbon::now()->toRfc3339String();

        $events = $service->events->listEvents($calendarId, [
            'timeMin' => $now,
            'singleEvents' => true,
            'orderBy' => 'startTime'
        ]);

        $bookedDates = [];

        foreach ($events->getItems() as $event) {
            $extendedProps = $event->getExtendedProperties();

            // Skip events created by HiraCollective
            if ($extendedProps && isset($extendedProps->private['category']) && $extendedProps->private['category'] === 'hiracollective') {
                continue;
            }

            // Skip events marked as "Available"
            if ($event->getTransparency() === 'transparent') {
                continue;
            }

            // Add busy events
            if (!empty($event->start->dateTime) && !empty($event->end->dateTime)) {
                $bookedDates[] = [
                    'date' => Carbon::parse($event->start->dateTime)->format('Y-m-d'),
                    'start_time' => Carbon::parse($event->start->dateTime)->format('h:i A'),
                    'end_time' => Carbon::parse($event->end->dateTime)->format('h:i A')
                ];
            } elseif (!empty($event->start->date)) {
                $bookedDates[] = [
                    'date' => $event->start->date,
                    'start_time' => null,
                    'end_time' => null
                ];
            }
        }

        $bookedDates = array_map("unserialize", array_unique(array_map("serialize", $bookedDates)));
        return array_values($bookedDates);

    }


}

