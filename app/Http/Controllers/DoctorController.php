<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /**
     * Show the form for creating a new doctor.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create-doctor'); // Assuming create-doctor.blade.php is in resources/views
    }

    /**
     * Store a newly created doctor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'signature' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Adjust mime types and size as needed
        ]);

        $doctorData = $request->except('signature');

        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $filename = time() . '_' . $signature->getClientOriginalName();
            $path = $signature->storeAs('uploads/signatures', $filename, 'public');
            $doctorData['signature'] = $path;
        }

        Doctor::create($doctorData);

        return redirect()->route('agents.index')->with('success', 'Doctor added successfully!'); // Redirect as needed
    }
}
