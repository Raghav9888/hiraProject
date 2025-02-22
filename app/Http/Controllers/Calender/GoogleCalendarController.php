<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
        $client->setAccessToken($googleAccount->access_token);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);
            $newToken = $client->getAccessToken();

            $googleAccount->update([
                'access_token' => $newToken['access_token'],
                'expires_at' => now()->addSeconds($newToken['expires_in']),
            ]);
        }

        return $client;
    }

    public function listEvents()
    {
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        $events = $service->events->listEvents('primary');

        return view('calendar.index', ['events' => $events->getItems()]);
    }


    public function createEvent(Request $request)
    {
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => $request->title,
            'start' => ['dateTime' => date('c', strtotime($request->start_time)), 'timeZone' => 'Asia/Kolkata'],
            'end' => ['dateTime' => date('c', strtotime($request->end_time)), 'timeZone' => 'Asia/Kolkata'],
        ]);

        $service->events->insert('primary', $event);
        return back()->with('success', 'Event added to Google Calendar!');
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
}
