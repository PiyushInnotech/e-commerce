<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PanelAuthController;
use App\Http\Middleware\ValidateForm;

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/signup', 'auth.signup')->name('signup');
    Route::view('/forgot-password', 'auth.forgot-password')->name('forgot-password');
});

Route::post('/login', [PanelAuthController::class, 'signinPanelUser'])->middleware('validateForm:loginSchema')->name('login.submit');
Route::post('/signup', [PanelAuthController::class, 'registerPanelUser'])->middleware('validateForm:registerSchema')->name('signup.submit');
Route::post('/forgot-password', [PanelAuthController::class, 'sendEmailCodeForUser'])->middleware('validateForm:isRegisteredEmailSchema')->name('forgot-password.submit');
Route::post('/logout', [PanelAuthController::class, 'logoutCurrentUser'])->name('logout');

