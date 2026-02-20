<?php

namespace App\Http\Controllers;

use App\Models\ObservationExamination;
use App\Models\ObservationVital;
use App\Models\Patient;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    //

    public function storeExamination(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'primary_symptom' => 'nullable|string',
            'other_symptoms' => 'nullable|string',
            'symptom_duration_value' => 'nullable|integer',
            'symptom_duration_unit' => 'nullable|string',
        ]);

        ObservationExamination::create($data);
        return redirect()->back()->with('success', 'Examination details saved successfully.');
    }

    public function upsertVitals(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|string',
            'temperature' => 'nullable|string',
            'respiratory_rate' => 'nullable|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
        ]);

        $vital = ObservationVital::where('patient_id', $request->patient_id)->first();

        if ($vital) {
            // Update existing vital signs
            $vital->update($data);
            return redirect()->back()->with('success', 'Vital signs updated successfully.');
        } else {
            // Create new vital signs
            ObservationVital::create($data);
            return redirect()->back()->with('success', 'Vital signs created successfully.');
        }
    }
}
