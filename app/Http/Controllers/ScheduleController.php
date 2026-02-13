<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;


class ScheduleController extends Controller
{
    //
    public function index()
    {
        $schedules = Schedule::all();
        return view('backend.doctors.schedules.schedules', compact('schedules'));
    }

    public function create()
    {
        $doctors = Doctor::orderBy('id')->get();
        return view('backend.doctors.schedules.create_schedule', compact('doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        Schedule::create($data);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $doctors = Doctor::orderBy('id')->get();
        return view('backend.doctors.schedules.edit_schedule', compact('schedule', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'slot_duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);


        $schedule->update($data);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
