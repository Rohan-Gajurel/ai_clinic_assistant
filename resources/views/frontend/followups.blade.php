
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
                <h5 class="mb-0">My Follow-ups</h5>
              </div>
              <div class="card-body p-4">
                @if(isset($followups) && count($followups))
                  <div class="table-responsive">
                    <table class="table followups-table mb-0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Notes</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($followups as $f)
                          <tr>
                            <td>{{ $f->followup_date ? \Carbon\Carbon::parse($f->followup_date)->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $f->followup_time ? \Carbon\Carbon::parse($f->followup_time)->format('H:i') : '--' }}</td>
                            <td>{{ $f->notes ?? 'N/A' }}</td>
                            <td>{{ ucfirst($f->status) }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @else
                  <p class="text-center text-muted mb-0">You have no follow-ups.</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
