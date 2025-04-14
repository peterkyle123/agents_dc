<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentDashboardController extends Controller
{
    /**
     * Show the agent dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // You can fetch agent-specific data here if needed
        return view('agent-dashboard'); // Assuming agent-dashboard.blade.php is in resources/views
    }
}
