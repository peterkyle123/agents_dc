<?php

namespace App\Http\Controllers;

use App\Models\Agent; // Assuming your agent model is App\Models\Agent
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentAuthController extends Controller
{
    /**
     * Show the agent login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('agent-login');
    }

    /**
     * Handle the agent login attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $agent = Agent::where('email', $request->email)->first();

        if ($agent && Hash::check($request->password, $agent->password)) {
            // Authentication passed...
            Auth::guard('agent')->login($agent, $request->remember);
            return redirect()->intended(route('agent.dashboard'));
        }

        // Authentication failed...
        return back()->withErrors(['email' => 'Invalid login credentials.'])->withInput($request->except('password'));
    }

    /**
     * Log the agent out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('agent.login.form');
    }
}
