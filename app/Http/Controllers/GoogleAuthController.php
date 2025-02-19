<?php

namespace App\Http\Controllers;

use Google\Client as GoogleClient;
use Google\Service\Calendar;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GoogleAuthController extends Controller
{
    private Google_Client $googleClient;

    public function __construct()
    {
        $this->googleClient = new Google_Client();
        $this->googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $this->googleClient->setScopes([Google_Service_Calendar::CALENDAR_READONLY]);
        $this->googleClient->setRedirectUri(config('services.google.redirect'));
        $this->googleClient->setAccessType('offline'); // Allows refreshing tokens
        $this->googleClient->setPrompt('select_account consent');
    }

    /**
     * Redirect to Google for authentication.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return redirect()->away($this->googleClient->createAuthUrl());
    }

    /**
     * Handle OAuth callback and store access token.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        if (!$request->has('code')) {
            return redirect()->route('redirectToGoogle')->with('error', 'Authorization failed.');
        }

        $token = $this->googleClient->fetchAccessTokenWithAuthCode($request->get('code'));

        if (isset($token['error'])) {
            return redirect()->route('redirectToGoogle')->with('error', 'Failed to get access token.');
        }

        // Store token in session
        Session::put('google_token', $token);

        return redirect()->route('calendarEvents');
    }

    /**
     * Retrieve user's Google Calendar list.
     */
    public function getCalendarList(): JsonResponse|RedirectResponse
    {
        $service = $this->getGoogleService();
        if (!$service) {
            return redirect()->route('redirectToGoogle');
        }

        $calendarList = $service->calendarList->listCalendarList();

        return response()->json($calendarList);
    }

    public static function getCalendarEvents(): JsonResponse
    {
        $service = (new self())->getGoogleService();

        if (!$service) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $events = $service->events->listEvents('primary');

        $formattedEvents = array_map(function ($event) {
            return [
                'id' => $event->getId(),
                'title' => $event->getSummary(),
                'start' => $event->getStart()->getDateTime() ?: $event->getStart()->getDate(),
                'end' => $event->getEnd()->getDateTime() ?: $event->getEnd()->getDate(),
            ];
        }, iterator_to_array($events->getItems()));

        return response()->json($formattedEvents);
    }


    /**
     * Get Google Service instance with valid token.
     */
    private function getGoogleService(): ?Google_Service_Calendar
    {
        $token = session('google_token');

        if (!$token) {
            return null;
        }

        $this->googleClient->setAccessToken($token);

        if ($this->googleClient->isAccessTokenExpired()) {
            if (isset($token['refresh_token'])) {
                $newToken = $this->googleClient->fetchAccessTokenWithRefreshToken($token['refresh_token']);
                if (!isset($newToken['error'])) {
                    Session::put('google_token', $newToken);
                    $this->googleClient->setAccessToken($newToken);
                } else {
                    return null;
                }
            } else {
                return null;
            }
        }

        return new Google_Service_Calendar($this->googleClient);
    }

}
