<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateRequest;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'registerUser'])->middleware('validateRequest:register');
    Route::post('/login', [AuthController::class, 'login'])->middleware('validateRequest:login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});