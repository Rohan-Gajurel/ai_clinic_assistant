@extends('frontend.layout')

@push('style')
<style>
  .reschedule-section { padding: 3rem 0; }
  .reschedule-card { max-width: 820px; margin: 0 auto; border-radius: 8px; }
  .reschedule-card .card-body { padding: 1.5rem; }
  .form-label { font-weight: 600; }
  @media (max-width: 576px) { .reschedule-card { padding: 0 1rem; } }
</style>
@endpush

@section('main')
  <main class="main py-4">
    <section class="reschedule-section">
      <div class="container">
        <div class="reschedule-card card shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Cancel Appointment</h5>
            <a href="{{ route('appointment') }}" class="btn btn-outline-primary btn-sm">Book New</a>
          </div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger" role="alert">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="doctor_id" class="form-label">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-select" readonly disabled>
                  <option value="">-- Select Doctor --</option>
                  @foreach($doctors as $d)
                    <option value="{{ $d->id }}" {{ old('doctor_id', $appointment->doctor_id) == $d->id ? 'selected' : '' }}>{{ optional($d->user)->name ?? 'Dr. '.$d->id }} - {{ $d->specialization ?? 'General' }}</option>
                  @endforeach
                </select>
              </div>

              <div class="row g-3">
                <div class="col-md-5">
                  <label for="appointment_date" class="form-label">Date</label>
                  <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '') }}" required readonly disabled>
                </div>
                <div class="col-md-4">
                  <label for="start_time" class="form-label">Start Time</label>
                  <select name="start_time" id="start_time" class="form-select" readonly disabled>
                    <option value="">-- Select Slot --</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="end_time" class="form-label">End Time</label>
                  <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : '') }}" readonly required>
                </div>
              </div>

              <div class="mb-3 mt-3">
                <label for="cancel_reason" class="form-label">Cancel Reason</label>
                <textarea name="cancel_reason" id="cancel_reason" rows="3" class="form-control">{{ old('cancel_reason', $appointment->cancel_reason) }}</textarea>
              </div>

              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('frontend.appointments') ?? route('appointments.index') }}" class="btn btn-light">Cancel</a>
              </div>
            </form>
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
    const dateInput = document.getElementById('appointment_date');
    const startSelect = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');

    const preselected = '{{ old('start_time', $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('H:i') : '') }}';

    async function loadSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;
        startSelect.innerHTML = '<option value="">-- Select Slot --</option>';
        endInput.value = '';
        if (!doctorId || !date) {
            return;
        }
        try {
            const url = `/doctor-slots?doctor_id=${encodeURIComponent(doctorId)}&date=${encodeURIComponent(date)}&appointment_id={{ $appointment->id }}`;
            const res = await fetch(url);
            if (!res.ok) throw new Error('Failed to load slots');
            const slots = await res.json();
            if (!slots || slots.length === 0) {
                return;
            }
            slots.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.start_time;
                opt.textContent = s.start_time + ' — ' + s.end_time;
                opt.dataset.end = s.end_time;
                startSelect.appendChild(opt);
            });
            if (preselected) startSelect.value = preselected;
            startSelect.dispatchEvent(new Event('change'));
        } catch (err) {
            console.error(err);
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

    if (doctorSelect.value && dateInput.value) loadSlots();
});
</script>
@endpush