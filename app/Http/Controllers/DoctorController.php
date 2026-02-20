<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    //
    public function index()
    {
        $doctors=Doctor::all();
        return view('backend.doctors.doctors.doctors', compact('doctors'));
    }

    public function create()
    {
        $users = \App\Models\User::orderBy('name')->get();
        return view('backend.doctors.doctors.create_doctor', compact('users'));
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'specialization' => 'required|string|max:150',
            'license_number' => 'required|string|unique:doctors,license_number',
            'consultation_fee' => 'required|numeric',
            'contact_number' => 'required|string|max:30',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'qualification' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('doctors', 'public');
        }
        
        $doctor = Doctor::create($data);

        return redirect()->route('doctors.doctors')->with('success', 'Doctor created successfully.');
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $users = \App\Models\User::orderBy('name')->get();
        return view('backend.doctors.doctors.edit_doctor', compact('doctor', 'users'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $data = $request->validate([
            'specialization' => 'required|string|max:150',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'consultation_fee' => 'required|numeric',
            'contact_number' => 'required|string|max:30',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'qualification' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('doctors', 'public');
        }
        $doctor->update($data);

        return redirect()->route('doctors.doctors')->with('success', 'Doctor updated successfully.');
    }

    public function destroy($id)
        {
            $doctor = Doctor::findOrFail($id);
            $doctor->delete();
    
            return redirect()->route('doctors.doctors')->with('success', 'Doctor deleted successfully.');
        }

    public function frontendDoctors()
    {
        $doctors = Doctor::where('status', 'active')->get();
        return view('frontend.doctors.doctors', compact('doctors'));
    }

}
