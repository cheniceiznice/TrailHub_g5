<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\SlackController;
use App\Http\Controllers\OpenAIController;




// For Google Drive upload
Route::post('/drive/upload', [UploadController::class, 'upload']);
Route::post('/drive/google-upload', [GoogleDriveController::class, 'uploadFile']);

// For Google Calendar
Route::get('/calendar/event/{eventId}', [GoogleCalendarController::class, 'getEvent']); // Get event details
Route::post('/calendar/event', [GoogleCalendarController::class, 'createEvent']); // Create event
Route::put('/calendar/event/{eventId}', [GoogleCalendarController::class, 'updateEvent']); // Update event
Route::delete('/calendar/event/{eventId}', [GoogleCalendarController::class, 'deleteEvent']); // Delete event


//For Merriam-Webster
Route::get('api/define', [DictionaryController::class, 'define']);

//Slack 

Route::prefix('slack-bot')->group(function () {
    Route::post('send', [SlackController::class, 'sendMessage']);
    Route::get('messages', [SlackController::class, 'getMessages']);
    Route::post('update', [SlackController::class, 'updateMessage']);
    Route::post('delete', [SlackController::class, 'deleteMessage']);
});



//ai
Route::post('api/openai/chat', [OpenAIController::class, 'chat']);
