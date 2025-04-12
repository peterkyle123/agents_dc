<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Ensure you are importing the controller here

// Display the login form (GET request)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Handle the login form submission (POST request)
Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // Changed URL to /login and updated name

// Logout route (POST request is more common for actions that change state)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route - now controlled by AuthController and potentially protected
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
Route::get('/doctors', function () {
    return view('doctors');
});
