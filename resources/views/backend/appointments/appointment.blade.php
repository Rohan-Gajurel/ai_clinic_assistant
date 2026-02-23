@extends('backend.layout.app')

@section('title')
    <title>Appointments - MediNest Admin</title>
@endsection

@push('style')

@endpush

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Appointment Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Appointments</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('appointments.create', 0) }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Appointment
    </a>
</div>

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="bi bi-calendar3 me-2" style="color: var(--primary-color);"></i>All Appointments
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($appointments as $appt)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $appt->patient->full_name ?? 'N/A' }}</td>
                            <td>{{ optional($appt->doctor->user)->name ?? 'Dr. '.$appt->doctor_id }}</td>
                            <td>{{ $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $appt->start_time ? \Carbon\Carbon::parse($appt->start_time)->format('H:i') : 'N/A' }}</td>
                            <td>{{ $appt->end_time ? \Carbon\Carbon::parse($appt->end_time)->format('H:i') : 'N/A' }}</td>
                            <td>{{ ucfirst($appt->status) }}</td>
                            <td class="text-center">
                                <form action="{{ route('patients.visitDetails', $appt->patient->id) }}" method="GET" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="appointment_id" value="{{ $appt->id }}">
                                    <button class="btn btn-sm btn-outline-info me-1" title="View Visit Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </form>
                                <a href="{{ route('appointments.edit', $appt->id) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>

                                <form action="{{ route('appointments.destroy', $appt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this appointment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent">
        <span class="text-muted">Showing {{ count($appointments) }} appointments</span>
    </div>
</div>

@endsection
