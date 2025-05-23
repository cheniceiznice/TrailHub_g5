<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SlackService
{
    protected $token;

    public function __construct()
    {
        $this->token = env('SLACK_USER_TOKEN');
    }

    public function sendMessage(string $channel, string $message)
    {
        $response = Http::withToken($this->token)
            ->post('https://slack.com/api/chat.postMessage', [
                'channel' => $channel,
                'text' => $message,
            ]);

        return $this->handleResponse($response);
    }

    public function getMessages(string $channel)
    {
        $response = Http::withToken($this->token)
            ->get('https://slack.com/api/conversations.history', [
                'channel' => $channel,
            ]);

        return $this->handleResponse($response);
    }

    public function updateMessage(string $channel, string $ts, string $message)
    {
        $response = Http::withToken($this->token)
            ->post('https://slack.com/api/chat.update', [
                'channel' => $channel,
                'ts' => $ts,
                'text' => $message,
            ]);

        return $this->handleResponse($response);
    }

    public function deleteMessage(string $channel, string $ts)
    {
        $response = Http::withToken($this->token)
            ->post('https://slack.com/api/chat.delete', [
                'channel' => $channel,
                'ts' => $ts,
            ]);

        return $this->handleResponse($response);
    }

    private function handleResponse($response)
    {
        if ($response->successful() && $response->json('ok')) {
            return $response->json();
        }

        Log::error('Slack API Error', ['response' => $response->body()]);

        return [
            'error' => true,
            'message' => $response->json('error') ?? 'Unknown error',
        ];
    }
}
