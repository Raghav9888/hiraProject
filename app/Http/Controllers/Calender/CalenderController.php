<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Google_Client;
use Google_Service_Calendar;
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
            return response()->json([
                'error' => 'No Google account linked or missing refresh token.'
            ], 401);
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
        $client->setAccessToken($googleAccount->access_token);

        // Handle token expiration
        if ($client->isAccessTokenExpired()) {
            \Log::info('Access token expired, attempting refresh...');

            $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);
            $newToken = $client->getAccessToken();

            if (!isset($newToken['access_token'])) {
                \Log::error('Failed to refresh token: ' . json_encode($newToken));
                return response()->json(['error' => 'Failed to refresh access token.'], 401);
            }

            // Update the new token in the database
            $googleAccount->update([
                'access_token' => $newToken['access_token'],
            ]);

            $client->setAccessToken($newToken);
        }

        try {
            $service = new Google_Service_Calendar($client);
            $events = $service->events->listEvents('primary');

            $userEvents = [];
            foreach ($events as $event) {
                $userEvents[] = [
                    'id' => $event->getId(),
                    'title' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'start' => $event->getStart()->getDateTime(),
                    'end' => $event->getEnd()->getDateTime(),
                ];
            }

            return response()->json(['events' => $userEvents], 200);
        } catch (\Exception $e) {
            \Log::error('Google API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Google API request failed.'], 500);
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
