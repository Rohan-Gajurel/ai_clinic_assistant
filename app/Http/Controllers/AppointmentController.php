<?php

namespace App\Http\Controllers;

use App\Jobs\AppointmentReminder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class AppointmentController extends Controller
{
    //
    public function getDoctorSlots(Request $request){

        $schedules = Schedule::where('doctor_id', $request->doctor_id)
            ->where('status', 'active')
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json("No active schedule for this doctor", 404);
        }

        $schedule = $schedules->first(function ($s) use ($request) {
            return $s->isAvailableOn($request->date);
        });

        if (! $schedule) {
            return response()->json("No active schedule for this doctor on the selected date", 404);
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
        $appointments = Appointment::with('doctor', 'patient.user')->orderBy('appointment_date', 'desc')->get();
        return view('backend.appointments.appointment', compact('appointments'));
    }

    public function create($patient_id = null)
    {
        $doctors = Doctor::orderBy('id')->get();
        $patients = Patient::with('user')->orderBy('id')->get();
        $selected_patient_id = $patient_id ? (int)$patient_id : null;
        return view('backend.appointments.create_appointment', compact('doctors', 'patients', 'selected_patient_id'));
    }

    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to book an appointment.');
        }

        // Ensure user has a patient profile
       if(auth()->user()->hasRole('Patient') && !auth()->user()->patient){
            return redirect()->route('patients.create')->with('error', 'Please complete your patient profile first.');
        }
        else if(!auth()->user()->hasRole('Patient') && !$request->patient_id){
            return redirect()->back()->with('error', 'Please select a patient for this appointment.');
        }

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'This slot is already booked.']);
        }
        $patient = auth()->user()->patient ?? null;

        $patientId = $request->patient_id ?: $patient->id;
        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patientId,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'created_by' => auth()->id(),
        ]);

        if (auth()->user()->hasRole('Admin')) {
            return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
        } else {
            return redirect()->route('frontend.appointments')->with('success', 'Appointment booked successfully and is pending approval.');
        }
    }


    public function edit($id)
    {
        $appointment = Appointment::with('doctor', 'patient.user')->findOrFail($id);
        $doctors = Doctor::orderBy('id')->get();
        $patients = Patient::with('user')->orderBy('id')->get();
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

        if (auth()->user()->hasRole('Admin')) {
            return redirect()->route('appointments.index');
        } 
        $appointments = Appointment::with('doctor', 'patient')
                ->where('patient_id', auth()->user()->patient->id)
                ->orderBy('appointment_date', 'desc')
                ->get();

        return view('frontend.appointments.index', compact('appointments'));
    }

    public function reschedule($id)
    {
        Gate::authorize('reschedule', Appointment::findOrFail($id));
        $appointment = Appointment::with('doctor', 'patient')->findOrFail($id);
        $doctors = Doctor::orderBy('id')->get();
        $patients = Patient::orderBy('id')->get();
        return view('frontend.appointments.reschedule', compact('appointment', 'doctors', 'patients'));
    }

    public function appointmentForm()
    {
        $doctors = Doctor::orderBy('id')->get();
        $patients = Patient::orderBy('id')->get();
        return view('frontend.appointment', compact('doctors', 'patients'));
    }

    public function updateReschedule(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = $request->validate([
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ]);

        $data['status'] = 'pending';
        $data['rescheduled_by'] = auth()->id();

        $appointment->update($data);

        return redirect()->route('frontend.appointments')->with('success', 'Appointment rescheduled successfully.');

    }

    public function doctorsAppointments($id)
    {
        $appointments = Appointment::with('doctor', 'patient')
            ->where('doctor_id', $id)
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        $doctor=Doctor::findOrFail($id);

        if(!auth()->check()){
            return redirect()->route('login')->with('error', 'Unauthorized access. Please login to book appointments.');
        }
        else
            {return view('frontend.doctors.doctors_appointment', compact('appointments', 'doctor'));}   
    }

    public function cancel($id)
    {
        // Load appointment (with relations) then authorize the current user against it
        $appointment = Appointment::with('doctor', 'patient')->findOrFail($id);
        Gate::authorize('cancel', $appointment);
        $doctors = Doctor::orderBy('id')->get();
        $patients = Patient::orderBy('id')->get();
        return view('frontend.appointments.cancel', compact('appointment', 'doctors', 'patients'));
    }


    public function cancelAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = $request->validate([
            'cancel_reason' => 'required|string',
        ]);

        $data['status'] = 'cancelled';

        $appointment->update($data);

        return redirect()->route('frontend.appointments')->with('success', 'Appointment cancelled successfully.');

    }

    
}
