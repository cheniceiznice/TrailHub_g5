<?php

namespace App\Http\Controllers;

use App\Services\JatrAIlService;  // Update service name
use Illuminate\Http\Request;

class JatrAIlController extends Controller  // Update controller name
{
    protected $openAI;  // Update service reference

    public function __construct(JatrAIlService $openAI)  // Update service name
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

        $response = $this->openAI->chat($messages);  // Update service method

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
