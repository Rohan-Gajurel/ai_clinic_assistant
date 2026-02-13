<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    public function index()
    {
        $patients = Patient::all();
        return view('backend.patients.patients', compact('patients'));
    }

    public function create()
    {
        return view('backend.patients.create_patient');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'disease' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        Patient::create($data);
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('backend.patients.edit_patient', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'disease' => 'nullable|string',
            'allergies' => 'nullable|string',
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
