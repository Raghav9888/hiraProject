<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use App\Models\GoogleAccount;
use App\Models\User;
use Carbon\Carbon;
use Google\Service\Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
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
        $client->setAuthConfig(storage_path('app/google/calendar/credential.json'));
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


        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'date' => $request->date,
        ];

        try {
            $this->createGoogleEvent($data);
            return back()->with('success', 'Event added to Google Calendar!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add event: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     * @throws \Google\Exception
     */
    public function createGoogleEvent($data): array
    {

        $googleAccount = GoogleAccount::where('user_id', $data['user_id'])->firstOrFail();
        $accessToken = json_decode($googleAccount->access_token, true);

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google/calendar/credential.json'));
        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            if (!empty($googleAccount->refresh_token)) {
                $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);
                $googleAccount->access_token = json_encode($client->getAccessToken());
                $googleAccount->save();
            } else {
                throw new \Exception('Google Token Expired. Please reauthorize.');
            }
        }

        $calendarService = new Google_Service_Calendar($client);

        $createEvent = [
            'summary' => $data['title'],
            'description' => $data['description'],
            'start' => [
                'dateTime' => $data['start']['dateTime'],
                'timeZone' => $data['start']['timeZone'],
            ],
            'end' => [
                'dateTime' => $data['end']['dateTime'],
                'timeZone' => $data['end']['timeZone'],
            ],
            'extendedProperties' => [
                'private' => [
                    'category' => $data['category'],
                ]
            ],
        ];

        if ( isset($data['offering_type']) && $data['offering_type'] === 'virtual') {

            $createEvent['conferenceData'] = [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => uniqid(),
                ],
            ];
        }

        $createEvent['attendees'] = [
            ['email' => $data['guest_email']],
        ];

        $event = new Google_Service_Calendar_Event($createEvent);

        $createdEvent = $calendarService->events->insert('primary', $event, ['conferenceDataVersion' => 1, 'sendUpdates' => 'all']);
        $meetLink = '';
        if ( isset($data['offering_type']) && $data['offering_type'] === 'virtual') {
            $meetLink = optional($createdEvent->getConferenceData())->getEntryPoints()[0]->getUri();
        }

        return [
            'success' => true,
            'meet_link' => $meetLink,
            'google_event_id' => $createdEvent->getId(),
        ];
    }



    public function updateEvent(Request $request)
    {
        // Validate request data
        $request->validate([
            'event_id' => 'required|string',
            'title' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);

        try {

            $event = $service->events->get('primary', $request->event_id);

            // ✅ Update event details
            $event->setSummary($request->title);
            $event->setDescription($request->description);

            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime(date('c', strtotime($request->start)));
            $start->setTimeZone('America/Vancouver');
            $event->setStart($start);

            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime(date('c', strtotime($request->end)));
            $end->setTimeZone('America/Vancouver');
            $event->setEnd($end);

            $updatedEvent = $service->events->update('primary', $request->event_id, $event);

            return response()->json([
                'message' => 'Event updated successfully in Google Calendar!',
                'updated_event' => $updatedEvent
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update event: ' . $e->getMessage()
            ], 500);
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

    public function getBookedSlots(Request $request, $userId)
    {
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User ID is required.',
            ], 400);
        }

        $user = User::find($userId);
        $timezone = $user->userDetail->timezone ?? config('app.timezone');

        try {
            $bookedSlots = $this->fetchGoogleCalendarEvents($userId, $timezone);

            return response()->json([
                'status' => 'success',
                'bookedDates' => $bookedSlots,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error fetching booked slots: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch booked slots. Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Fetch Google Calendar events, excluding HiraCollective bookings.
     *
     * @throws \Exception
     * @throws \Google\Service\Exception
     */
    private function fetchGoogleCalendarEvents($userId, $timezone)
    {
        $googleAccount = GoogleAccount::where('user_id', $userId)->first();

        if (!$googleAccount) {
            throw new \Exception('No Google account linked for this user.');
        }

        $accessTokenRaw = $googleAccount->access_token;

        // Handle both raw token and JSON
        if (is_string($accessTokenRaw)) {
            $trimmed = trim($accessTokenRaw);

            if (str_starts_with($trimmed, '{')) {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON token: ' . json_last_error_msg());
                }
                $accessToken = $decoded;
            } else {
                $accessToken = ['access_token' => $trimmed];
            }
        } else {
            throw new \Exception('Invalid token format.');
        }

        $client = new \Google_Client();

        $credentialsPath = storage_path('app/google/calendar/credential.json');
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Google credentials file is missing.');
        }

        $client->setAuthConfig($credentialsPath);
        $client->setAccessToken($accessToken);

        // Refresh token if expired
        if ($client->isAccessTokenExpired()) {
            if (!empty($googleAccount->refresh_token)) {
                $newAccessToken = $client->fetchAccessTokenWithRefreshToken($googleAccount->refresh_token);

                if (isset($newAccessToken['error'])) {
                    throw new \Exception('Failed to refresh access token: ' . $newAccessToken['error_description']);
                }

                $googleAccount->access_token = json_encode($newAccessToken);
                $googleAccount->save();

                $client->setAccessToken($newAccessToken);
            } else {
                throw new \Exception('Google token expired. Please reauthorize.');
            }
        }

        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';
        $now = Carbon::now()->toRfc3339String();

        $events = $service->events->listEvents($calendarId, [
            'timeMin' => $now,
            'singleEvents' => true,
            'orderBy' => 'startTime'
        ]);

        $bookedDates = [];

        foreach ($events->getItems() as $event) {
            // Skip cancelled events
            if ($event->status === 'cancelled') {
                continue;
            }

            // Skip transparent events (marked as available)
            if ($event->getTransparency() === 'transparent') {
                continue;
            }

            // Skip events explicitly created by HiraCollective (optional)
            // $extendedProps = $event->getExtendedProperties();
            // if ($extendedProps && isset($extendedProps->private['category']) && $extendedProps->private['category'] === 'hiracollective') {
            //     continue;
            // }

            // Handle datetime-based events
            if (!empty($event->start->dateTime) && !empty($event->end->dateTime)) {
                $date = Carbon::parse($event->start->dateTime);
                $startTime = Carbon::parse($event->start->dateTime);
                $endTime = Carbon::parse($event->end->dateTime);
                $dateConvertPractitionerTimezone = Carbon::parse($event->start->dateTime)->setTimezone($timezone);
                $startTimePractitionerTimezone = Carbon::parse($event->start->dateTime)->setTimezone($timezone);
                $endTimeConvertPractitionerTimezone = Carbon::parse($event->end->dateTime)->setTimezone($timezone);

                $bookedDates[] = [
                    'date' => $date->format('Y-m-d'),
                    'start_time' => $startTime->format('h:i A'),
                    'end_time' => $endTime->format('h:i A'),
                    'convertDate' => $dateConvertPractitionerTimezone->format('Y-m-d'),
                    'convertStartTime' => $startTimePractitionerTimezone->format('h:i A'),
                    'convertEndTime' => $endTimeConvertPractitionerTimezone->format('h:i A'),
                    'timezone' => $timezone,
                ];
            } // Handle all-day events
            elseif (!empty($event->start->date)) {
                $bookedDates[] = [
                    'date' => $event->start->date,
                    'start_time' => null,
                    'end_time' => null
                ];
            }
        }

        // Remove duplicates
        $bookedDates = array_map("unserialize", array_unique(array_map("serialize", $bookedDates)));

        return array_values($bookedDates);
    }

}

