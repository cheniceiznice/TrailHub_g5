<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NikaTalkService;  // Update service name

class NikaTalkController extends Controller  // Update controller name
{
    protected $slackService;  // Update service reference

    public function __construct(NikaTalkService $slackService)  // Update service name
    {
        $this->slackService = $slackService;
    }

    public function sendMessage(Request $request)
    {
        $channel = $request->input('channel');
        $text = $request->input('text');

        $result = $this->slackService->sendMessage($channel, $text);  // Update service method

        if (!empty($result['error'])) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json($result);
    }

    public function getMessages(Request $request)
    {
        $channel = $request->input('channel');

        $result = $this->slackService->getMessages($channel);  // Update service method

        if (!empty($result['error'])) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json($result);
    }

    public function updateMessage(Request $request)
    {
        $channel = $request->input('channel');
        $ts = $request->input('ts');
        $text = $request->input('text');

        $result = $this->slackService->updateMessage($channel, $ts, $text);  // Update service method

        if (!empty($result['error'])) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json($result);
    }

    public function deleteMessage(Request $request)
    {
        $channel = $request->input('channel');
        $ts = $request->input('ts');

        $result = $this->slackService->deleteMessage($channel, $ts);  // Update service method

        if (!empty($result['error'])) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json($result);
    }
}
