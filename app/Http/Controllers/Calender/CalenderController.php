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
            return;
        }
dd($googleAccount->refresh_token , $googleAccount->expires_in);
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
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

        return $userEvents;
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
