
@extends('frontend.layout')

@push('style')
<style>
  .appointments-section { padding: 3rem 0; }
  .appointments-card { border: 1px solid #eef0f2; border-radius: 8px; }
  .appointments-table thead th { background: #f8f9fa; font-weight: 600; }
</style>
@endpush

@section('main')
  <main class="main py-4">
    <!-- Appointment Section -->
    <section id="appointment" class="appointments-section section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="card appointments-card">
              <div class="card-header d-flex align-items-center justify-content-between px-4 py-3">
                <h5 class="mb-0">My Appointments</h5>
              </div>
              <div class="card-body p-4">
                @if(isset($appointments) && count($appointments))
                  <div class="table-responsive">
                    <table class="table appointments-table mb-0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Doctor</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($appointments as $a)
                          <tr>
                            <td>{{ $a->appointment_date ? \Carbon\Carbon::parse($a->appointment_date)->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $a->start_time ? \Carbon\Carbon::parse($a->start_time)->format('H:i') : '--' }} - {{ $a->end_time ? \Carbon\Carbon::parse($a->end_time)->format('H:i') : '--' }}</td>
                            <td>{{ optional($a->doctor->user)->name ?? 'Dr. ' . $a->doctor_id }}</td>
                            <td>{{ ucfirst($a->status) }}</td>
                            <td>
                              <a href="{{ route('appointments.reschedule', $a->id) }}" class="btn btn-sm btn-outline-primary">Reschedule</a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @else
                  <p class="text-center text-muted mb-0">You have no appointments.</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
