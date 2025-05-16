<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;

class GoogleCalendarController extends Controller
{
    protected $googleService;

    public function __construct(GoogleCalendarService $googleService)
    {
        $this->googleService = $googleService;
    }

    public function getEvent(Request $request, $eventId)
{
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json(['error' => 'Missing token'], 401);
    }

    try {
        $event = $this->googleService->getEvent($eventId, $token);
        return response()->json($event);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function createEvent(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }

        $data = $request->only(['summary', 'start', 'end', 'timeZone']);

        try {
            $event = $this->googleService->createEvent($data, $token);
            return response()->json($event);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateEvent(Request $request, $eventId)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }

        $data = $request->only(['summary', 'start', 'end', 'timeZone']);

        try {
            $event = $this->googleService->updateEvent($eventId, $data, $token);
            return response()->json($event);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteEvent(Request $request, $eventId)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }

        try {
            $this->googleService->deleteEvent($eventId, $token);
            return response()->json(['message' => 'Event deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
