<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DictionaryController;

// Existing routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google', [GoogleCalendarController::class, 'redirectToGoogle']);
Route::get('/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback']);

// Add route for creating an event
Route::post('/calendar/event', [GoogleCalendarController::class, 'createEvent']);

// For Google Drive
Route::post('/drive/upload', [GoogleDriveController::class, 'uploadFile']);
Route::get('/drive/files', [GoogleDriveController::class, 'listFiles']);

