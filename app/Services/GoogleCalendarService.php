<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class GoogleCalendarService
{
    protected function getClient($accessToken)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-client-secret.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        // Decode token if JSON string
        if (is_string($accessToken)) {
            $accessToken = json_decode($accessToken, true);
        }

        if (!is_array($accessToken) || !isset($accessToken['access_token'])) {
            throw new \InvalidArgumentException('Invalid or missing access token');
        }

        $client->setAccessToken($accessToken);

        // Refresh token if expired
        if ($client->isAccessTokenExpired() && isset($accessToken['refresh_token'])) {
            $client->fetchAccessTokenWithRefreshToken($accessToken['refresh_token']);
        }

        return $client;
    }

    public function getEvent(string $eventId, $accessToken)
{
    $client = $this->getClient($accessToken);
    $service = new Google_Service_Calendar($client);

    return $service->events->get('primary', $eventId);
}


    public function createEvent(array $data, $accessToken)
    {
        $client = $this->getClient($accessToken);
        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => $data['summary'],
            'start' => [
                'dateTime' => $data['start'],
                'timeZone' => $data['timeZone'] ?? 'Asia/Kolkata',
            ],
            'end' => [
                'dateTime' => $data['end'],
                'timeZone' => $data['timeZone'] ?? 'Asia/Kolkata',
            ],
        ]);

        return $service->events->insert('primary', $event);
    }

    public function updateEvent(string $eventId, array $data, $accessToken)
    {
        $client = $this->getClient($accessToken);
        $service = new Google_Service_Calendar($client);

        // Fetch existing event
        $event = $service->events->get('primary', $eventId);

        // Update fields
        if (isset($data['summary'])) {
            $event->setSummary($data['summary']);
        }
        if (isset($data['start'])) {
            $event->setStart([
                'dateTime' => $data['start'],
                'timeZone' => $data['timeZone'] ?? 'Asia/Kolkata',
            ]);
        }
        if (isset($data['end'])) {
            $event->setEnd([
                'dateTime' => $data['end'],
                'timeZone' => $data['timeZone'] ?? 'Asia/Kolkata',
            ]);
        }

        return $service->events->update('primary', $eventId, $event);
    }

    public function deleteEvent(string $eventId, $accessToken)
    {
        $client = $this->getClient($accessToken);
        $service = new Google_Service_Calendar($client);

        return $service->events->delete('primary', $eventId);
    }
}
