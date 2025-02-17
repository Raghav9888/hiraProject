<?php

namespace App\Http\Controllers;


use Google\Client as GoogleClient;
use Google\Exception;
use Google\Service\Calendar;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\GoogleAccount;
use Illuminate\Support\Facades\Session;

class GoogleAuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function redirectToGoogle(): RedirectResponse
    {
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $googleClient->addScope(Google_Service_Calendar::CALENDAR);
        $googleClient->setRedirectUri(config('services.google.redirect'));

        $authUrl = $googleClient->createAuthUrl();
        return redirect()->away($authUrl);
    }

    /**
     * @throws Exception
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $googleClient->setRedirectUri(config('services.google.redirect'));

        // Get the authentication code from the callback
        $code = $request->get('code');

        // Exchange authorization code for access token
        $token = $googleClient->fetchAccessTokenWithAuthCode($code);

        // Store the token in the session
        // Store the token properly in the session
        Session::put('google_token', $token);

        return redirect('/calendar-list');
    }

    public function getCalendarList(): JsonResponse|RedirectResponse
    {
        $accessToken = session('google_token');

        if (!$accessToken) {
            return redirect()->route('google.redirect');
        }

        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(config('services.google.client_secret_path'));
        $googleClient->setAccessToken($accessToken);

        if ($googleClient->isAccessTokenExpired()) {
            return redirect()->route('google.redirect');
        }

        $service = new Google_Service_Calendar($googleClient);

        // Fetch the calendar list
        $calendarList = $service->calendarList->listCalendarList();

        // Return the data in a desired format (JSON or view)
        return response()->json($calendarList);
    }
}
