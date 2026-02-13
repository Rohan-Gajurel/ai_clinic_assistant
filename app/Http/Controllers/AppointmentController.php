<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //
    public function getDoctorSlots(Request $request){
        // find any active schedule for the doctor that is available on the requested date
        $schedules = Schedule::where('doctor_id', $request->doctor_id)
            ->where('status', 'active')
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json([]);
        }

        $schedule = $schedules->first(function ($s) use ($request) {
            return $s->isAvailableOn($request->date);
        });

        if (! $schedule) {
            return response()->json([]);
        }

        $slots = $schedule->generateSlots($request->date);

        // normalize slot times to H:i strings
        $slots = array_map(function ($s) {
            return [
                'start_time' => \Carbon\Carbon::parse($s['start_time'])->format('H:i'),
                'end_time' => \Carbon\Carbon::parse($s['end_time'])->format('H:i'),
            ];
        }, $slots);

        $bookedQuery = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $request->date);

        // if editing an existing appointment, exclude it from the booked slots
        if ($request->has('appointment_id') && $request->appointment_id) {
            $bookedQuery->where('id', '!=', $request->appointment_id);
        }

        $bookedSlots = $bookedQuery
            ->pluck('start_time')
            ->map(fn($time) => \Carbon\Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableSlots = array_filter($slots, function ($slot) use ($bookedSlots) {
            return ! in_array($slot['start_time'], $bookedSlots);
        });

        return response()->json(array_values($availableSlots));
    }

    public function index()
    {
        $appointments = Appointment::with('doctor', 'patient')->orderBy('appointment_date', 'desc')->get();
        return view('backend.appointments.appointment', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::orderBy('id')->get();
        $patients = Patient::orderBy('id')->get();
        return view('backend.appointments.create_appointment', compact('doctors', 'patients',));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();

        Appointment::create($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function edit($id)
    {
        $appointment = Appointment::with('doctor', 'patient')->findOrFail($id);
        $doctors = Doctor::orderBy('id')->get();
        $patients = Patient::orderBy('id')->get();
        return view('backend.appointments.edit_appointments', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,approved,reminded,completed,cancelled',
        ]);

        if($appointment->status !== $data['status'] && in_array($data['status'], ['cancelled', 'approved'])){
            $data['rescheduled_by'] = auth()->id();
        }

        $appointment->update($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function frontendAppointments()
    {
        // $appointments = Appointment::with('doctor', 'patient')
        //     ->where('patient_id', auth()->user()->patient->id)
        //     ->orderBy('appointment_date', 'desc')
        //     ->get();
        $appointments=Appointment::all();

        return view('frontend.appointments.index', compact('appointments'));
    }

    public function frontendCreateAppointment()
    {
        $doctors = Doctor::orderBy('id')->get();
        return view('frontend.appointments.create', compact('doctors'));
    }
}
