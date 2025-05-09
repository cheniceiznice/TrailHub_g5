<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class GoogleCalendarService
{
    public function createEvent(array $data, $accessToken)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-client-secret.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        // Decode token if JSON string
        if (is_string($accessToken)) {
            $accessToken = json_decode($accessToken, true);
        }

        // Validate token
        if (!is_array($accessToken) || !isset($accessToken['access_token'])) {
            throw new \InvalidArgumentException('Invalid or missing access token');
        }

        $client->setAccessToken($accessToken);

        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => $data['summary'],
            'start' => [
                'dateTime' => $data['start'],
                'timeZone' => 'Asia/Kolkata',
            ],
            'end' => [
                'dateTime' => $data['end'],
                'timeZone' => 'Asia/Kolkata',
            ],
        ]);

        return $service->events->insert('primary', $event);
    }
}
