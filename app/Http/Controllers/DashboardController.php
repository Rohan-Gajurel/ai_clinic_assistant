<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function getStatusColor($status)
    {
        return match ($status) {
            'approved' => '#28a745', // green
            'pending' => '#ffc107', // yellow
            'cancelled' => '#dc3545', // red
            'completed' => '#007bff', // blue
            default => '#6c757d', // gray
        };
    }

    public function events(){
        $appointments = Appointment::with('doctor.user', 'patient.user')->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'title' => "Appointment with Dr. {$appointment->doctor->user->name} for {$appointment->patient->full_name}",
                'start' => $appointment->appointment_date . 'T' . $appointment->start_time,
                'end' => $appointment->appointment_date . 'T' . $appointment->end_time,
                'color' => $this->getStatusColor($appointment->status),
            ];
        });

        return response()->json($events);
    }
    
    public function index(){
        return view('backend.dashboard');
    }

    public function calender(){
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', now()->toDateString())->count();
        $upcomingWeekAppointments = Appointment::whereBetween('appointment_date', [now(), now()->addDays(7)])->count();
        $appointments=Appointment::whereBetween('appointment_date', [now()->startOfMonth(), now()->endOfMonth()])->get();
        return view('backend.calender', compact('totalAppointments', 'todayAppointments', 'upcomingWeekAppointments', 'appointments'));
    }

    
}
