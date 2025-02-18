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
    /**
     * Redirect to Google for authentication.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $googleClient->setScopes([Google_Service_Calendar::CALENDAR_READONLY]);
        $googleClient->setRedirectUri(config('services.google.redirect'));
        $googleClient->setAccessType('offline'); // Allows refreshing tokens
        $googleClient->setPrompt('select_account consent');

        return redirect()->away($googleClient->createAuthUrl());
    }

    /**
     * Handle OAuth callback and store access token.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $googleClient->setRedirectUri(config('services.google.redirect'));

        if (!$request->has('code')) {
            return redirect()->route('redirectToGoogle')->with('error', 'Authorization failed.');
        }

        $token = $googleClient->fetchAccessTokenWithAuthCode($request->get('code'));

        if (isset($token['error'])) {
            return redirect()->route('redirectToGoogle')->with('error', 'Failed to get access token.');
        }

        Session::put('google_token', $token);

        return redirect()->route('calendarList');
    }

    /**
     * Retrieve user's Google Calendar list.
     */
    public function getCalendarList(): JsonResponse|RedirectResponse
    {
        $token = session('google_token');

        if (!$token) {
            return redirect()->route('redirectToGoogle');
        }

        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $googleClient->setAccessToken($token);

        if ($googleClient->isAccessTokenExpired()) {
            return redirect()->route('redirectToGoogle');
        }

        $service = new Google_Service_Calendar($googleClient);
        $calendarList = $service->calendarList->listCalendarList();

        return response()->json($calendarList);
    }
}
