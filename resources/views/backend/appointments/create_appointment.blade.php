@extends('backend.layout.app')

@section('title')
    <title>Create Appointment - MediNest Admin</title>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-semibold">Create Appointment</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Appointments</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the errors below:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                    </div>
                @endif

                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- Patient --}}
                        <div class="col-md-6 mb-3">
                        <label class="form-label">Patient</label>
                        <select name="patient_id" class="form-select" required>
                            <option value="">-- Select Patient --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('patient_id', $selected_patient_id ?? null) == $p->id ? 'selected' : '' }}>
                                    {{ $p->full_name ?? 'N/A' }} ({{ $p->contact_number ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Doctor --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="">-- Select Doctor --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}"
                                    {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                    {{ optional($d->user)->name ?? 'Dr. '.$d->id }}
                                    - {{ $d->specialization ?? 'General' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date + Slot --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date"
                                   name="appointment_date"
                                   id="appointment_date"
                                   class="form-control"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('appointment_date') }}"
                                   required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Time Slot</label>
                            <select name="start_time"
                                    id="start_time"
                                    class="form-select"
                                    required>
                                <option value="">-- Select Slot --</option>
                            </select>
                            <small class="text-muted" id="slotHelp">
                                Select doctor and date first
                            </small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time"
                                   name="end_time"
                                   id="end_time"
                                   class="form-control"
                                   readonly
                                   required>
                        </div>
                    </div>

                    {{-- Reason --}}
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="reason"
                                  class="form-control"
                                  rows="3">{{ old('reason') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Create Appointment
                    </button>

                    <a href="{{ route('appointments.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

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

    async function loadSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;

        startSelect.innerHTML = '<option value="">-- Select Slot --</option>';
        endInput.value = '';

        if (!doctorId || !date) {
            slotHelp.textContent = 'Select doctor and date first';
            return;
        }

        slotHelp.textContent = 'Loading slots...';

        try {
            const response = await fetch(
                `{{ route('doctor.slots') }}?doctor_id=${doctorId}&date=${date}`
            );

            if (!response.ok) throw new Error('Failed');

            const slots = await response.json();

            if (!slots.length) {
                slotHelp.textContent = 'No available slots';
                return;
            }

            slotHelp.textContent = '';

            slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.start_time;
                option.textContent = slot.start_time + ' - ' + slot.end_time;
                option.dataset.end = slot.end_time;
                startSelect.appendChild(option);
            });

            // Restore old value after validation error
            const oldStart = "{{ old('start_time') }}";
            if (oldStart) {
                startSelect.value = oldStart;
                startSelect.dispatchEvent(new Event('change'));
            }

        } catch (error) {
            slotHelp.textContent = 'Error loading slots';
            console.error(error);
        }
    }

    doctorSelect.addEventListener('change', loadSlots);
    dateInput.addEventListener('change', loadSlots);

    startSelect.addEventListener('change', function () {
        const selected = startSelect.selectedOptions[0];
        endInput.value = selected?.dataset?.end ?? '';
    });

    // Auto-load if returning with old input
    if (doctorSelect.value && dateInput.value) {
        loadSlots();
    }

});
</script>
@endpush
