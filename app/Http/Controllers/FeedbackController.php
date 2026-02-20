<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    //
    public function index()
    {
        $feedbacks = Feedback::all();
        return view('backend.feedback.feedback', compact('feedbacks'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->where('status', 'active')->orderBy('id')->get();
        return view('frontend.create_feedback', compact('doctors'));
    }

    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to submit feedback.');
        }

        // Validate the request
        $validated = $request->validate([
            'doctor_id' => 'nullable|exists:doctors,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
            'would_recommend' => 'required|in:0,1',
        ]);

        // Get or create patient for the user
        $patient = auth()->user()->patient;
        if (!$patient) {
            return redirect()->route('patients.create')->with('error', 'Please complete your patient profile first.');
        }

        // Create feedback
        Feedback::create([
            'doctor_id' => $validated['doctor_id'] ?? null,
            'patient_id' => $patient->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'would_recommend' => $validated['would_recommend'],
        ]);

        return redirect()->route('feedback.create')->with('success', 'Thank you! Your feedback has been submitted successfully.');
    }
}
