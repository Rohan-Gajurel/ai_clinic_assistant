@php
use Carbon\Carbon;

$today = Carbon::today();
$dates = [];

for ($i = 0; $i < 14; $i++) {
    $dates[] = $today->copy()->addDays($i);
}
@endphp

@extends('frontend.layout')

@section('main')
<main class="main pt-5">
    <div class="container my-4">

        {{-- Doctor Profile Card --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row gap-4">
                
                {{-- Profile Image --}}
                <div class="shrink-0 text-center">
                    @if(optional($doctor->user)->profile_photo_path)
                        <img src="{{ asset(optional($doctor->user)->profile_photo_path) }}"
                             alt="{{ optional($doctor->user)->name }}"
                             class="rounded shadow"
                             style="width:120px;height:120px;object-fit:cover;" />
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center shadow"
                             style="width:120px;height:120px;color:#777;">
                            No Image
                        </div>
                    @endif
                </div>

                {{-- Doctor Details --}}
                <div class="grow">
                    <h4 class="mb-2">{{ optional($doctor->user)->name ?? 'Doctor' }}</h4>

                    <p class="mb-1"><strong>Specialization:</strong> {{ $doctor->specialization ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>License:</strong> {{ $doctor->license_number ?? 'N/A' }}</p>
                    <p class="mb-1">
                        <strong>Consultation Fee:</strong>
                        {{ isset($doctor->consultation_fee) ? 'Rs '.$doctor->consultation_fee : 'N/A' }}
                    </p>
                    <p class="mb-1">
                        <strong>Contact:</strong>
                        {{ $doctor->contact_number ?? optional($doctor->user)->email ?? 'N/A' }}
                    </p>

                    @if($doctor->bio)
                        <p class="mt-2 text-muted">{{ $doctor->bio }}</p>
                    @endif
                </div>
            </div>
        </div>


        {{-- Availability Section --}}
        <h4 class="mb-3">Available Dates & Times</h4>

        <div class="list-group shadow-sm">
            @foreach($dates as $date)

                @php
                    $daySchedules = $doctor->schedules->filter(function($s) use ($date) {
                        return $s->isAvailableOn($date->toDateString());
                    });
                    
                @endphp

                <div class="list-group-item">

                    {{-- Date Header --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $date->format('l, j M Y') }}</h6>
                            <small class="text-muted">{{ $date->diffForHumans() }}</small>
                        </div>

                        @if($daySchedules->isNotEmpty())
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-secondary">No Availability</span>
                        @endif
                    </div>

                    {{-- Slots --}}
                    @if($daySchedules->isNotEmpty())
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @foreach($daySchedules as $schedule)
                                @php 
                                    $slots = $schedule->generateSlots($date->toDateString());
                                @endphp

                                @foreach($slots as $slot)
                                    @php
                                        $slotDateTime = Carbon::parse($date->toDateString().' '.$slot['start_time']);
                                        $isPast = $date->isToday() && $slotDateTime->lt(Carbon::now());
                                        
                                        // Check if slot is already booked
                                        $isBooked = \App\Models\Appointment::where('doctor_id', $doctor->id)
                                            ->where('appointment_date', $date->format('Y-m-d'))
                                            ->where('start_time', Carbon::parse($slot['start_time'])->format('H:i'))
                                            ->where('status', '!=', 'cancelled')
                                            ->exists();
                                    @endphp
                                    
                                    @if(!$isPast && !$isBooked)
                                        <form method="POST" action="{{ route('appointments.store') }}" class="d-inline" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="doctor_id" value="{{ optional($doctor)->id }}">
                                            <input type="hidden" name="appointment_date" value="{{ $date->format('Y-m-d') }}">
                                            <input type="hidden" name="start_time" value="{{ Carbon::parse($slot['start_time'])->format('H:i') }}">
                                            <input type="hidden" name="end_time" value="{{ Carbon::parse($slot['end_time'])->format('H:i') }}">

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-primary"
                                                    onclick="return confirm('Book this slot?')">
                                                {{ Carbon::parse($slot['start_time'])->format('g:i A') }}
                                                -
                                                {{ Carbon::parse($slot['end_time'])->format('g:i A') }}
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

    </div>
</main>


@endsection
