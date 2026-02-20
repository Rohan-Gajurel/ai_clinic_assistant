<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::all();
        return view('backend.reminder.reminder', compact('reminders'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('backend.reminder.create_reminder', compact('patients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'message' => 'required|string',
            'medicine' => 'nullable|string',
            'dosage' => 'nullable|string',
            'reminder_time' => 'required|date_format:H:i',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data['created_by'] = auth()->user()->doctor ? auth()->user()->doctor->id : null;

        Reminder::create($data);

        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully.');
    }


    public function update(Request $request, $id)
    {
        $reminder = Reminder::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:active,completed,stopped',
        ]);

        $reminder->update($data);

        return redirect()->route('reminders.index')->with('update_message', 'Reminder updated successfully.');
    }

    public function destroy($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();

        return redirect()->route('reminders.index')->with('delete_message', 'Reminder deleted successfully.');
    }   

}
