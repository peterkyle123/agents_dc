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
    public function index()
    {
        $doctors = Doctor::all();
        return view('docs-index', compact('doctors'));
    }
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('docs-edit', compact('doctor'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'specialty' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'signature' => 'nullable|image|max:2048',
    ]);

    $doctor = Doctor::findOrFail($id);
    $doctor->name = $request->name;
    $doctor->specialty = $request->specialty;
    $doctor->address = $request->address;

    if ($request->hasFile('signature')) {
        // Delete old image if exists
        if ($doctor->signature && \Storage::exists($doctor->signature)) {
            \Storage::delete($doctor->signature);
        }

        $path = $request->file('signature')->store('signatures', 'public');
        $doctor->signature = $path;
    }

    $doctor->save();

    return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
}
public function destroy($id)
{
    $doctor = Doctor::findOrFail($id);

    if ($doctor->signature && \Storage::exists($doctor->signature)) {
        \Storage::delete($doctor->signature);
    }

    $doctor->delete();

    return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
}
}
