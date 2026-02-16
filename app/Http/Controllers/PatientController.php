<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('backend.patients.patients', compact('patients'));
    }

    public function create()
    {
        // $users = User::whereDoesntHave('patient')->get();
        $users= User::all();
        return view('backend.patients.create_patient', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:patients,user_id',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'disease' => 'nullable|string',
            'allergies' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:30',
        ]);

        Patient::create($data);
        return redirect()->route('patients.index')->with('success', 'Patient profile created successfully.');
    }

    public function edit($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('backend.patients.edit_patient', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $data = $request->validate([
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'disease' => 'nullable|string',
            'allergies' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:30',
        ]);

        $patient->update($data);
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }      

}
