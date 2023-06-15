<?php

use App\Http\Auth\AuthController;
use App\Http\Auth\RegisterController;
use App\Http\Auth\FirebaseController;

// Auth
Route::post('/', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('/', [AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout']);

