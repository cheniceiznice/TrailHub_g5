<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Illuminate\Http\Request;

class OpenAIController extends Controller
{
    protected $openAI;

    public function __construct(OpenAIService $openAI)
    {
        $this->openAI = $openAI;
    }

    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['error' => 'Message is required'], 400);
        }

        $messages = [
            ['role' => 'user', 'content' => $userMessage]
        ];

        $response = $this->openAI->chat($messages);

        if (isset($response['error'])) {
            return response()->json(['error' => $response['message']], 500);
        }

        $reply = $response['choices'][0]['message']['content'] ?? '';

        return response()->json([
            'reply' => $reply,
            'full_response' => $response,
        ]);
    }
}
