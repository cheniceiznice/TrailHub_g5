<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use App\Services\GoogleCalendarService;

class GoogleCalendarController extends Controller
{
    protected $googleService;

    public function __construct(GoogleCalendarService $googleService)
    {
        $this->googleService = $googleService;
    }

    public function redirectToGoogle()
    {
        // Create a new Google Client
        $client = new Google_Client();
        
        // Set the necessary credentials using config() for consistency
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
    
        // Add scopes for both Google Calendar and Google Drive
        $client->addScope(Google_Service_Calendar::CALENDAR);  // For Google Calendar
        $client->addScope('https://www.googleapis.com/auth/drive.file');  // For Google Drive
    
        // Generate the authentication URL and redirect the user
        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        
        // Set credentials using config() for consistency
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        
        // Add scope for Google Calendar (this is optional here, as the scope was already added during the auth request)
        $client->addScope(Google_Service_Calendar::CALENDAR);

        // Authenticate the client and get the access token
        $client->authenticate($request->get('code'));
        $token = $client->getAccessToken();

        // Store the token in the session or database
        session(['google_token' => $token]);

        // Optionally, you could return a response indicating the process is complete
        return response()->json($token);
    }

    public function createEvent(Request $request)
    {
        $token = $request->bearerToken(); // Extract Authorization: Bearer <token>
        
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }
    
        // Pass the token to your service to create the event in Google Calendar
        $event = $this->googleService->createEvent($request->all(), $token);
        return response()->json($event);
    }
}
