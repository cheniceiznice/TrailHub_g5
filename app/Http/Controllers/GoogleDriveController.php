<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleDriveService;

class GoogleDriveController extends Controller
{
    protected $driveService;

    public function __construct(GoogleDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

    public function uploadFile(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }

        $file = $request->file('file');
        if (!$file) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        // Handle the file upload with Google Drive service
        $response = $this->driveService->uploadFile($file, $token);
        return response()->json($response);
    }

    public function listFiles(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 401);
        }

        // List files in Google Drive
        $files = $this->driveService->listFiles($token);
        return response()->json($files);
    }
}
