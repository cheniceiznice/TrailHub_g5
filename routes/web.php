<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleTaskController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\GoogleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google', [GoogleCalendarController::class, 'redirectToGoogle']);
Route::get('/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback']);
//Route::post('/calendar/event', [GoogleCalendarController::class, 'createEvent']);
//Route::post('/calendar/event', [CalendarController::class, 'createEvent']);

//for google drive
Route::post('/drive/upload', [GoogleDriveController::class, 'uploadFile']);
Route::get('/drive/files', [GoogleDriveController::class, 'listFiles']);


