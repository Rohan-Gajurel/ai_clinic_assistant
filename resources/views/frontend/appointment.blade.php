@extends('frontend.layout')

@section('main')
<main class="main">

<div class="page-title">
    <div class="heading">
        <div class="container text-center">
            <h1>Appointment</h1>
        </div>
    </div>
</div>

<section class="section">
<div class="container">
<div class="row gy-4">

<div class="col-lg-6">
    <h3>Quick & Easy Online Booking</h3>
    <p>Book your appointment in just a few simple steps.</p>
</div>

<div class="col-lg-6">
<div class="card shadow-sm p-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

<form action="{{ route('appointments.store') }}" method="POST">
@csrf

{{-- GLOBAL ERROR MESSAGE --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Patient --}}
<div class="mb-3">
    <label class="form-label">Patient</label>
    <select name="patient_id" class="form-select" required>
        <option value="">-- Select Patient --</option>
        @foreach($patients as $p)
            <option value="{{ $p->id }}"
                {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                {{ optional($p->user)->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Doctor --}}
<div class="mb-3">
    <label class="form-label">Doctor</label>
    <select name="doctor_id" id="doctor_id" class="form-select" required>
        <option value="">-- Select Doctor --</option>
        @foreach($doctors as $d)
            <option value="{{ $d->id }}"
                {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                {{ optional($d->user)->name ?? 'Dr. '.$d->id }}
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
            disabled
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
           value="{{ old('end_time') }}"
           readonly
           required>
</div>

</div>

{{-- Reason --}}
<div class="mb-3">
    <label class="form-label">Reason</label>
    <textarea name="reason"
              class="form-control"
              rows="3">{{ old('reason') }}</textarea>
</div>

<button type="submit" class="btn btn-sm btn-primary">
    Book Appointment
</button>

</form>
</div>
</div>

</div>
</div>
</section>

</main>
@endsection


@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const doctorSelect = document.getElementById('doctor_id');
    const dateInput    = document.getElementById('appointment_date');
    const startSelect  = document.getElementById('start_time');
    const endInput     = document.getElementById('end_time');
    const slotHelp     = document.getElementById('slotHelp');

    const slotUrl  = "{{ route('doctor.slots') }}";
    const oldStart = @json(old('start_time'));
    const urlParams = new URLSearchParams(window.location.search);
    const paramDoctor = urlParams.get('doctor_id');
    const paramDate = urlParams.get('date');
    const paramStart = urlParams.get('start_time');
    const paramEnd = urlParams.get('end_time');

    function resetSlots(message = 'Select doctor and date first') {
        startSelect.innerHTML = '<option value="">-- Select Slot --</option>';
        startSelect.disabled = true;
        endInput.value = '';
        slotHelp.textContent = message;
    }

    async function loadSlots() {

        const doctorId = doctorSelect.value;
        const date     = dateInput.value;

        resetSlots();

        if (!doctorId || !date) return;

        slotHelp.textContent = 'Loading slots...';

        try {
            const response = await fetch(
                `${slotUrl}?doctor_id=${doctorId}&date=${date}`
            );

            if (!response.ok) {
                throw new Error('Network error');
            }

            const slots = await response.json();

            if (!slots || slots.length === 0) {
                resetSlots('No available slots');
                return;
            }

            startSelect.disabled = false;
            slotHelp.textContent = '';

            slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.start_time; // H:i
                option.textContent = slot.start_time + ' - ' + slot.end_time;
                option.dataset.end = slot.end_time;
                startSelect.appendChild(option);
            });

            // Prefer the start_time from URL params (H:i), otherwise old input
            const preselected = paramStart || oldStart;
            if (preselected) {
                const opt = Array.from(startSelect.options).find(o => o.value === preselected);
                if (opt) {
                    startSelect.value = preselected;
                    startSelect.dispatchEvent(new Event('change'));
                } else if (paramEnd) {
                    endInput.value = paramEnd;
                }
            } else if (paramEnd) {
                endInput.value = paramEnd;
            }

        } catch (error) {
            console.error(error);
            resetSlots('Error loading slots');
        }
    }

    doctorSelect.addEventListener('change', loadSlots);
    dateInput.addEventListener('change', loadSlots);

    startSelect.addEventListener('change', function () {
        const selected = startSelect.selectedOptions[0];
        endInput.value = selected ? selected.dataset.end : '';
    });

    // Prefill from URL params if present
    if (paramDoctor) doctorSelect.value = paramDoctor;
    if (paramDate) dateInput.value = paramDate;

    if (doctorSelect.value && dateInput.value) {
        loadSlots();
    } else {
        resetSlots();
    }

});
</script>
@endpush
