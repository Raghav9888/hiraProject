<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
        $client->setRedirectUri(route('google.callback'));

        $client->setAccessType('offline'); // Get refresh token
        $client->setPrompt('consent'); // Always ask for permissions
        $client->addScope('https://www.googleapis.com/auth/calendar.events');

        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('dashboard')->with('error', 'Google authentication failed.');
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return redirect()->route('dashboard')->with('error', 'Google authentication failed.');
        }

        $user = Auth::user();
        GoogleAccount::updateOrCreate(
            ['user_id' => $user->id],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? GoogleAccount::where('user_id', $user->id)->value('refresh_token'),
                'expires_at' => now()->addSeconds($token['expires_in']),
            ]
        );

        return redirect()->route('calendar')->with('success', 'Google Calendar connected successfully!');
    }

    public function disconnectGoogle()
    {
        $user = Auth::user();
        GoogleAccount::where('user_id', $user->id)->delete();

        return redirect()->route('dashboard')->with('success', 'Google Calendar disconnected.');
    }
}
