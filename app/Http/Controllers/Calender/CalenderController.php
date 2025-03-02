<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    public function showCalendar(): View
    {
        $user = Auth::user();

        return view('user.calendar', [
            'user' => $user,
        ]);
    }

    public function getGoogleCalendarEvents()
    {
        $user = Auth::user();
        $googleAccount = GoogleAccount::where('user_id', $user->id)->first();

        if (!$googleAccount || !$googleAccount->refresh_token) {
            return response()->json(['error' => 'Google account not connected.'], 401);
        }

        try {
            $client = new Google_Client();
            $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
            $client->setAccessToken($googleAccount->access_token);

            // Check if the access token is expired and refresh it
            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);
                $newToken = $client->getAccessToken();
dd($newToken);
                $googleAccount->update([
                    'access_token' => $newToken['access_token'],
                    'refresh_token' => $newToken['refresh_token'] ?? $googleAccount->refresh_token, // Preserve refresh token
                ]);

                $client->setAccessToken($newToken);
            }

            // Fetch Calendar Events
            $service = new Google_Service_Calendar($client);
            $events = $service->events->listEvents('primary');

            $userEvents = [];
            foreach ($events->getItems() as $event) {
                $userEvents[] = [
                    'id' => $event->getId(),
                    'title' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'start' => $event->getStart()->getDateTime() ?? $event->getStart()->getDate(),
                    'end' => $event->getEnd()->getDateTime() ?? $event->getEnd()->getDate(),
                ];
            }

            return response()->json(['events' => $userEvents], 200);
        } catch (Google_Service_Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred.'], 500);
        }
    }


    public function upComingEvents()
    {
        $user = Auth::user();
        $googleAccount = GoogleAccount::where('user_id', $user->id)->first();

        if (!$googleAccount || $googleAccount->access_token == null) {
            return;
        }

        $events = $this->getGoogleCalendarEvents();
        $now = new \DateTime();
        $filterEvents = array_filter($events, function ($event) use ($now) {
            if (empty($event['start']) || empty($event['end'])) {
                return false;
            }

            $eventStart = new \DateTime($event['start']);
            return $eventStart >= $now;
        });
        return [
            'events' => $filterEvents,
        ];
    }


}
