<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CylendarService;  // Update service name

class CylendarController extends Controller  // Update controller name
{
    protected $cylendarService;  // Update service reference

    public function __construct(CylendarService $cylendarService)  // Update service name
    {
        $this->cylendarService = $cylendarService;
    }

    public function getEvent(Request $request, $eventId)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }

        try {
            $event = $this->cylendarService->getEvent($eventId, $token);  // Update service method
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
            $event = $this->cylendarService->createEvent($data, $token);  // Update service method
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
            $event = $this->cylendarService->updateEvent($eventId, $data, $token);  // Update service method
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
            $this->cylendarService->deleteEvent($eventId, $token);  // Update service method
            return response()->json(['message' => 'Event deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
