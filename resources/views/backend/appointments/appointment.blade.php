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
                            <td>{{ optional($appt->patient)->name ?? 'N/A' }}</td>
                            <td>{{ optional($appt->doctor->user)->name ?? 'Dr. '.$appt->doctor_id }}</td>
                            <td>{{ $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $appt->start_time ? \Carbon\Carbon::parse($appt->start_time)->format('H:i') : 'N/A' }}</td>
                            <td>{{ $appt->end_time ? \Carbon\Carbon::parse($appt->end_time)->format('H:i') : 'N/A' }}</td>
                            <td>{{ ucfirst($appt->status) }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#appointmentDetailModal"
                                        data-id="{{ $appt->id }}"
                                        data-patient="{{ optional($appt->patient)->name }}"
                                        data-doctor="{{ optional($appt->doctor->user)->name }}"
                                        data-date="{{ $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d') : '' }}"
                                        data-start="{{ $appt->start_time ? \Carbon\Carbon::parse($appt->start_time)->format('H:i') : '' }}"
                                        data-end="{{ $appt->end_time ? \Carbon\Carbon::parse($appt->end_time)->format('H:i') : '' }}"
                                        data-status="{{ $appt->status }}"
                                        data-reason="{{ Str::limit($appt->reason ?? 'N/A', 300) }}"
                                ><i class="bi bi-eye"></i></button>

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

@push('script')
<script>
document.addEventListener('show.bs.modal', function (event) {
    if (event.target.id !== 'appointmentDetailModal') return;
    var button = event.relatedTarget;
    var patient = button.getAttribute('data-patient');
    var doctor = button.getAttribute('data-doctor');
    var date = button.getAttribute('data-date');
    var start = button.getAttribute('data-start');
    var end = button.getAttribute('data-end');
    var status = button.getAttribute('data-status');
    var reason = button.getAttribute('data-reason');

    var modal = event.target;
    modal.querySelector('.modal-title').textContent = (patient || 'Appointment') + ' — Details';
    modal.querySelector('#adPatient').textContent = patient || 'N/A';
    modal.querySelector('#adDoctor').textContent = doctor || 'N/A';
    modal.querySelector('#adDate').textContent = date || 'N/A';
    modal.querySelector('#adStart').textContent = start || 'N/A';
    modal.querySelector('#adEnd').textContent = end || 'N/A';
    modal.querySelector('#adStatus').textContent = status || 'N/A';
    modal.querySelector('#adReason').textContent = reason || 'N/A';
});
</script>

<!-- Appointment Detail Modal -->
<div class="modal fade" id="appointmentDetailModal" tabindex="-1" aria-labelledby="appointmentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentDetailModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    <li><strong>Patient:</strong> <span id="adPatient"></span></li>
                    <li><strong>Doctor:</strong> <span id="adDoctor"></span></li>
                    <li><strong>Date:</strong> <span id="adDate"></span></li>
                    <li><strong>Start:</strong> <span id="adStart"></span></li>
                    <li><strong>End:</strong> <span id="adEnd"></span></li>
                    <li><strong>Status:</strong> <span id="adStatus"></span></li>
                    <li><strong>Reason:</strong> <p id="adReason" class="small text-muted"></p></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endpush