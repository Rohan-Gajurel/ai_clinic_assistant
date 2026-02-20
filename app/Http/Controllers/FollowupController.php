<?php

namespace App\Http\Controllers;

use App\Models\Followup;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    public function index()
    {
        $followups = Followup::with('appointment.doctor.user', 'appointment.patient.user')->get();
        return view('backend.followup.followup', compact('followups'));
    }

    public function create()
    {
        $appointments = \App\Models\Appointment::with('doctor.user', 'patient.user')->get();
        return view('backend.followup.create_followup', compact('appointments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'notes' => 'nullable|string',
            'followup_date' => 'required|date',
            'followup_time' => 'required',
        ]);

        Followup::create($data);

        return redirect()->route('followups.index')->with('success', 'Follow-up created successfully.');
    }

    public function update(Request $request, $id)
    {
        $followup = Followup::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $followup->update($data);

        return redirect()->route('followups.index')->with('update_message', 'Follow-up updated successfully.');
    }

    public function destroy($id)
    {
        $followup = Followup::findOrFail($id);
        $followup->delete();

        return redirect()->route('followups.index')->with('delete_message', 'Follow-up deleted successfully.');
    }

    public function frontendFollowups()
    {
        if (auth()->user()->hasRole('Admin')) {
            return redirect()->route('followups.index');
        } else {
            $followups = Followup::whereHas('appointment.patient', function ($query) {
                $query->where('user_id', auth()->id());
            })->with('appointment.doctor.user')->get();

            return view('frontend.followups', compact('followups'));
        }
    }


}
