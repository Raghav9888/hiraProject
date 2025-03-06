<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));
        $client->setRedirectUri(route('google_callback'));
        $client->setAccessType('offline'); // Request refresh token
        $client->setApprovalPrompt('force'); // Force refresh token
        $client->addScope(Google_Service_Calendar::CALENDAR);

        return redirect($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/google-calendar.json'));

        $token = $client->fetchAccessTokenWithAuthCode($request->code);
        if (isset($token['error'])) {
            return redirect()->route('dashboard')->with('error', 'Google authentication failed.');
        }

        $client->setAccessToken($token);

        $googleAccount = GoogleAccount::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? null,
                'expires_at' => now()->addSeconds($token['expires_in']),
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Google account connected successfully!');
    }

    public function disconnectToGoogle()
    {
        $user = Auth::user();
        $googleAccount = GoogleAccount::where('user_id', $user->id)->first();

        if ($googleAccount) {
            if ($googleAccount->access_token) {
                $response = Http::asForm()->post('https://accounts.google.com/o/oauth2/revoke', [
                    'token' => $googleAccount->access_token
                ]);

                if ($response->failed()) {
                    \Log::error('Failed to revoke Google token', ['response' => $response->body()]);
                    return redirect()->route('dashboard')->with('error', 'Failed to revoke Google access.');
                }
            }

            $googleAccount->update([
                'access_token' => null,
                'expires_at' => null
            ]);
            Session::forget('googleAuthSuccess');
        }

        return redirect()->route('my_profile')->with('success', 'Google Calendar access revoked.');
    }
}


