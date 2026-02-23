<?php

namespace App\Http\Controllers;

use App\Models\DiseaseHistory;
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

    public function storeDiseaseHistory(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'name' => 'nullable|array',
            'name.*' => 'nullable|string',
            'duration_value' => 'nullable|array',
            'duration_value.*' => 'nullable|string',
            'duration_unit' => 'nullable|array',
            'duration_unit.*' => 'nullable|string',
            'status' => 'nullable|array',
            'status.*' => 'nullable|string',
            'drug_name' => 'nullable|array',
            'drug_name.*' => 'nullable|string',
            'drug_dose' => 'nullable|array',
            'drug_dose.*' => 'nullable|string',
            'drug_frequency' => 'nullable|array',
            'drug_frequency.*' => 'nullable|string',
            'drug_for' => 'nullable|array',
            'drug_for.*' => 'nullable|string',
        ]);

        // Save disease history
        if (!empty($validated['name'])) {
            foreach ($validated['name'] as $index => $name) {
                if (!empty($name)) { // Only save if disease name is not empty
                    DiseaseHistory::create([
                        'patient_id' => $validated['patient_id'],
                        'name' => $name,
                        'duration_value' => $validated['duration_value'][$index] ?? null,
                        'duration_unit' => $validated['duration_unit'][$index] ?? null,
                        'status' => $validated['status'][$index] ?? 0,
                    ]);
                }
            }
        }

        // Save drug history
        if (!empty($validated['drug_name'])) {
            foreach ($validated['drug_name'] as $index => $drugName) {
                if (!empty($drugName)) { // Only save if drug name is not empty
                    \App\Models\DrugHistory::create([
                        'patient_id' => $validated['patient_id'],
                        'drug_name' => $drugName,
                        'drug_dose' => $validated['drug_dose'][$index] ?? null,
                        'drug_frequency' => $validated['drug_frequency'][$index] ?? null,
                        'drug_for' => $validated['drug_for'][$index] ?? null,
                        'dose_unit' => $validated['dose_unit'][$index] ?? null,
                        'status' => $validated['drug_status'][$index] ?? 1,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Disease and drug history saved successfully.');
    }
}
