<?php

namespace App\Http\Controllers;

use App\Models\Agent; // Assuming your model is named Agent
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
       public function index()
    {
        $agents = Agent::all(); // Fetch all agents from the database
        return view('agents-index', compact('agents'));
    }
    /**
     * Show the form for creating a new agent.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create-agent'); // Direct path to your blade file
    }

    /**
     * Store a newly created agent in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        $agentData = $request->except('profile_picture', 'password_confirmation');
        $agentData['password'] = Hash::make($request->password);

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/agents', $filename, 'public');
            $agentData['profile_picture'] = $path;
        }

        Agent::create($agentData);

        // Adjust the redirect route if your index page is also directly in views
        return redirect()->route('agents.index')->with('success', 'Agent created successfully!');
    }

    /**
     * Display a listing of the agents.
     *
     * @return \Illuminate\View\View
     */

     public function edit(Agent $agent)
    {
        return view('edit-agent', compact('agent')); // Direct path to edit-agent.blade.php
    }

    /**
     * Update the specified agent in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents,email,' . $agent->id, // Ignore current agent's email
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'password' => 'nullable|string|min:8|confirmed', // Password is optional on update
        ]);

        $agentData = $request->except('profile_picture', 'password', 'password_confirmation');

        if ($request->filled('password')) {
            $agentData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($agent->profile_picture && Storage::disk('public')->exists($agent->profile_picture)) {
                Storage::disk('public')->delete($agent->profile_picture);
            }

            $image = $request->file('profile_picture');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/agents', $filename, 'public');
            $agentData['profile_picture'] = $path;
        }

        $agent->update($agentData);

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully!');
    }

    /**
     * Remove the specified agent from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Agent $agent)
    {
        // Delete the profile picture if it exists
        if ($agent->profile_picture && Storage::disk('public')->exists($agent->profile_picture)) {
            Storage::disk('public')->delete($agent->profile_picture);
        }

        $agent->delete();

        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully!');
    }
}
