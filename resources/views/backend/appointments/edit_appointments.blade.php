@extends('backend.layout.app')

@section('title')
    <title>Edit Appointment - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Edit Appointment</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Appointments</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Appointments
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-calendar-event me-2" style="color: var(--primary-color);"></i>Appointment Information
                </h5>
            </div>
            @if($errors->any())
                <div class="alert alert-danger m-3" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Patient</label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <option value="">-- Select Patient --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ old('patient_id', $appointment->patient_id) == $p->id ? 'selected' : '' }}>{{ optional($p->user)->name }} ({{ optional($p->user)->email ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="">-- Select Doctor --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" {{ old('doctor_id', $appointment->doctor_id) == $d->id ? 'selected' : '' }}>{{ optional($d->user)->name ?? 'Dr. '.$d->id }} - {{ $d->specialization ?? 'General' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="appointment_date" class="form-label">Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <select name="start_time" id="start_time" class="form-select" required>
                                <option value="">-- Select Slot --</option>
                            </select>
                            <div class="form-text" id="slotHelp">Select doctor and date to load slots</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : '') }}" readonly required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea name="reason" id="reason" rows="3" class="form-control">{{ old('reason', $appointment->reason) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            @php $statuses = ['pending', 'approved', 'reminded', 'completed', 'cancelled']; @endphp
                            @foreach($statuses as $s)
                                <option value="{{ $s }}" {{ old('status', $appointment->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label">Cancel Reason (optional)</label>
                        <textarea name="cancel_reason" id="cancel_reason" rows="2" class="form-control">{{ old('cancel_reason', $appointment->cancel_reason) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Appointment
                        </button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date');
    const startSelect = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');
    const slotHelp = document.getElementById('slotHelp');

    // preselected start value from server (old or existing)
    const preselected = '{{ old('start_time', $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('H:i') : '') }}';

    async function loadSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;
        startSelect.innerHTML = '<option value="">-- Select Slot --</option>';
        endInput.value = '';
        if (!doctorId || !date) {
            slotHelp.textContent = 'Select doctor and date to load slots';
            return;
        }
        slotHelp.textContent = 'Loading slots...';
        try {
            const url = `/doctor-slots?doctor_id=${encodeURIComponent(doctorId)}&date=${encodeURIComponent(date)}&appointment_id={{ $appointment->id }}`;
            const res = await fetch(url);
            if (!res.ok) throw new Error('Failed to load slots');
            const slots = await res.json();
            if (!slots || slots.length === 0) {
                slotHelp.textContent = 'No available slots for selected date';
                return;
            }
            slotHelp.textContent = '';
            slots.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.start_time;
                opt.textContent = s.start_time + ' — ' + s.end_time;
                opt.dataset.end = s.end_time;
                startSelect.appendChild(opt);
            });
            // try to preselect existing slot
            if (preselected) startSelect.value = preselected;
            startSelect.dispatchEvent(new Event('change'));
        } catch (err) {
            console.error(err);
            slotHelp.textContent = 'Error loading slots';
        }
    }

    doctorSelect?.addEventListener('change', loadSlots);
    dateInput?.addEventListener('change', loadSlots);

    startSelect?.addEventListener('change', function () {
        const opt = startSelect.selectedOptions[0];
        if (opt && opt.dataset && opt.dataset.end) {
            endInput.value = opt.dataset.end;
        } else {
            endInput.value = '';
        }
    });

    // load initially
    if (doctorSelect.value && dateInput.value) {
        loadSlots();
    }
});
</script>
@endpush