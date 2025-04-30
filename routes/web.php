<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Ensure you are importing the controller here
use App\Http\Controllers\AgentAuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentDashboardController;
use App\Http\Controllers\DoctorController;

// Display the login form (GET request)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Handle the login form submission (POST request)
Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // Changed URL to /login and updated name

// Logout route (POST request is more common for actions that change state)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route - now controlled by AuthController and potentially protected
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
Route::get('/agent-dr', function () {
    return view('agent-dr');
});
// agents
Route::get('/agents/create', [AgentController::class, 'create'])->name('agents.create');
Route::post('/agents', [AgentController::class, 'store'])->name('agents.store');
Route::get('/agents/index', [AgentController::class, 'index'])->name('agents.index'); // Route for listing agents
//edit,update,delete
// Route to display the edit form (though we're using a modal now)
Route::get('/agents/{agent}/edit', [AgentController::class, 'edit'])->name('agents.edit');

// Route to handle the submission of the edit form and update the agent's data
Route::put('/agents/{agent}', [AgentController::class, 'update'])->name('agents.update');

// Route to handle the deletion of a specific agent
Route::delete('/agents/{agent}', [AgentController::class, 'destroy'])->name('agents.destroy');
//agents login
// Route to display the agent login form
Route::get('/agents/login', [AgentAuthController::class, 'showLoginForm'])->name('agent.login.form');

// Route to handle the agent login attempt (form submission)
Route::post('/agents/login', [AgentAuthController::class, 'login'])->name('agent.login');

// Example route for the agent dashboard (you'll need to create this controller and view)
Route::get('/agent/dashboard', [AgentDashboardController::class, 'index'])->name('agent.dashboard')->middleware('auth:agent');

// Route for agent logout
Route::post('/agents/logout', [AgentAuthController::class, 'logout'])->name('agent.logout');
//
// Route to display the form for adding a new doctor
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');

// Route to handle the submission of the add doctor form
Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');

// You'll likely want routes for listing, editing, and deleting doctors later
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
