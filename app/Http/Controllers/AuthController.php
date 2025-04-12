<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login'); // The login view you created earlier
    }

    // Handle the login attempt
    public function login(Request $request)
{
    // Validates the email and password input fields
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Hardcoded admin credentials for testing
    $adminEmail = 'admin@example.com';   // Replace with your test email
    $adminPassword = 'password123';   // Replace with your test password

    // Checks if the email and password match the hardcoded values
    if ($request->email == $adminEmail && $request->password == $adminPassword) {
        session(['admin' => $request->email]); // Store admin session
        return redirect()->to('/dashboard'); // Redirect to the specific URL
    }

    return back()->withErrors(['Invalid credentials']); // Returns an error if login fails
}

    public function logout()
    {
        session()->forget('admin');
        return redirect()->route('login');
    }

    public function showDashboard()
    {
        if (!session()->has('admin')) {
            return redirect()->route('login');
        }
        return view('U_dashbrd');   // 'U_dashboard' is the name of your Blade file
    }
}
