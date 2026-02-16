<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

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
        ]);

        $doctor = \App\Models\Doctor::create($data);

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
        ]);

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
