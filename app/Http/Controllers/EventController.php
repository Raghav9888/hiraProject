<?php

namespace App\Http\Controllers;

use Google\Client as Google_Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private Google_Client $googleClient;

    public function __construct()
    {
        // Initialize the Google Client
        $this->googleClient = new Google_Client();
        $this->googleClient->setApplicationName('hfh');
        $this->googleClient->setScopes([
            Calendar::CALENDAR_READONLY,
            Calendar::CALENDAR_EVENTS,
        ]);
        $this->googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $this->googleClient->setAccessType('offline');
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->googleClient->createAuthUrl();
        return redirect($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $this->googleClient->fetchAccessTokenWithAuthCode($request->code);
        $token = $this->googleClient->getAccessToken();

        // Save the token in the database associated with the user
        auth()->user()->update(['google_token' => json_encode($token)]);

        return redirect('/calendar');
    }

    public function fetchGoogleCalendarEvents()
    {
        $this->googleClient->setAccessToken(json_decode(auth()->user()->google_token, true));

        if ($this->googleClient->isAccessTokenExpired()) {
            $this->googleClient->fetchAccessTokenWithRefreshToken($this->googleClient->getRefreshToken());
            auth()->user()->update(['google_token' => json_encode($this->googleClient->getAccessToken())]);
        }

        $service = new Calendar($this->googleClient);
        $events = $service->events->listEvents('primary', ['maxResults' => 10]);

        return response()->json($events->getItems());
    }

    public function syncEventToGoogle(Request $request)
    {
        $this->googleClient->setAccessToken(json_decode(auth()->user()->google_token, true));

        $service = new Calendar($this->googleClient);
        $event = new \Google\Service\Calendar\Event(array(
            'summary' => $request->input('title'),
            'start' => array('dateTime' => $request->input('start')),
            'end' => array('dateTime' => $request->input('end')),
        ));

        $service->events->insert('primary', $event);

        return response()->json(['success' => true]);
    }

    public function deleteGoogleCalendarEvent($eventId)
    {
        $this->googleClient->setAccessToken(json_decode(auth()->user()->google_token, true));

        $service = new Calendar($this->googleClient);
        $service->events->delete('primary', $eventId);

        return response()->json(['success' => true]);
    }
}
