<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
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
                'expires_at' => isset($newToken['expires_in']) && $newToken['expires_in']
                    ? now()->addSeconds($newToken['expires_in'])
                    : null,
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


    public function createEvednt(Request $request)
    {
        $client = $this->getClient();

        if ($client->isAccessTokenExpired()) {
            return back()->with('error', 'Google Token Expired. Please reauthorize.');
        }

        $service = new Google_Service_Calendar($client);

        $title = $request->input('title');
        $start = $request->input('start_time');
        $end = $request->input('end_time');

        if (!$title || !$start || !$end) {
            return back()->with('error', 'Invalid event data received.');
        }

        $event = new Google_Service_Calendar_Event([
            'summary' => $title,
            'start' => ['dateTime' => date('c', strtotime($start)), 'timeZone' => 'Asia/Kolkata'],
            'end' => ['dateTime' => date('c', strtotime($end)), 'timeZone' => 'Asia/Kolkata'],
        ]);

        try {
            $service->events->insert('primary', $event);
            return back()->with('success', 'Event added to Google Calendar!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add event: ' . $e->getMessage());
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


        // Retrieve authenticated user's Google token
        $user = Auth::user();
        $googleAccount = GoogleAccount::where('user_id', $user->id)->first();
        $accessToken = $googleAccount->access_token;

        // Initialize Google Client
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
        $client->setAccessToken($accessToken);

        // Refresh token if expired
        if ($client->isAccessTokenExpired()) {
            if (isset($googleAccount->refresh_token)) {
                $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);
                $newAccessToken = $client->getAccessToken();

                $googleAccount->access_token = json_encode($newAccessToken);
                $googleAccount->save();
            } else {
                return redirect()->route('google.auth')->with('error', 'Google Token Expired. Please reauthorize.');
            }
        }

        // Initialize Google Calendar service
        $calendarService = new Google_Service_Calendar($client);

        // Create Event
        $event = new Google_Service_Calendar_Event([
            'summary' => $request->title,
            'description' => $request->description,
            'start' => [
                'dateTime' => date('c', strtotime($request->start)),
                'timeZone' => 'America/Vancouver',
            ],
            'end' => [
                'dateTime' => date('c', strtotime($request->end)),
                'timeZone' => 'America/Vancouver',

            ],
            'extendedProperties' => [
                'private' => [
                    'category' => $request->category,
                ]
            ],
        ]);


        try {
            $calendarService->events->insert('primary', $event);
            return back()->with('success', 'Event added to Google Calendar!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add event: ' . $e->getMessage());
        }
    }
}

