@extends('backend.layout.app')
@section('title')
    <title>Reminders - Tele Med</title>
@endsection

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Reminder Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Reminders</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('reminders.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New Reminder
    </a>

</div>

<!-- Alert Messages -->
@if(session('delete_message'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i>
    <strong>{{ session('delete_message')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <strong>{{ session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session('update_message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <strong>{{ session('update_message')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>All Reminders
        </h5>
        <div class="d-flex align-items-center">
            <div class="input-group me-2" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search reminders..." id="searchReminders">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col" style="width:220px; min-width:200px;">Patient Name</th>
                        <th scope="col" class="text-center" style="width:150px;">Medicine</th>
                        <th scope="col" class="text-center" style="width:150px;">Dosage</th>
                        <th scope="col" style="width:140px; min-width:100px;">Reminder Time</th>
                        <th scope="col" style="width:140px; min-width:100px;">Status</th>
                        <th scope="col" style="width:140px; min-width:100px;">Created By</th>
                        <th scope="col" class="text-center" style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($reminders as $reminder)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td >
                            {{ $reminder->patient->user->name ?? 'N/A' }}
                        </td>
                        <td class="text-center">{{ $reminder->medicine ?? 'N/A' }}</td>
                        <td class="text-center">{{ $reminder->dosage ?? 'N/A' }}</td>
                        <td>{{ $reminder->reminder_time }}</td>
                        <td>{{ ucfirst($reminder->status) }}</td>
                        <td>{{ $reminder->creator ? $reminder->creator->user->name : 'System' }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                data-bs-toggle="modal" data-bs-target="#reminderDetailModal"
                                data-patient="{{ $reminder->patient->user->name ?? 'N/A' }}"
                                data-message="{{ $reminder->message }}"
                                data-medicine="{{ $reminder->medicine ?? 'N/A' }}"
                                data-dosage="{{ $reminder->dosage ?? 'N/A' }}"
                                data-reminder-time="{{$reminder->reminder_time }}"
                                data-status="{{ ucfirst($reminder->status) }}"
                                data-start-date="{{ $reminder->start_date }}"
                                data-end-date="{{ $reminder->end_date}}"
                                title="View">
                                <i class="bi bi-eye"></i>
                            </button>

                            <form action="{{ route('reminders.destroy', $reminder->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this reminder?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <span class="text-muted">Showing {{ count($reminders) }} reminders</span>
    </div>
</div>

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('reminderDetailModal');
    if (!modal) return;

    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var patient = button.getAttribute('data-patient');
        var message = button.getAttribute('data-message');
        var medicine = button.getAttribute('data-medicine');
        var dosage = button.getAttribute('data-dosage');
        var reminderTime = button.getAttribute('data-reminder-time');
        var status = button.getAttribute('data-status');
        var startDate = button.getAttribute('data-start-date');
        var endDate = button.getAttribute('data-end-date');

        modal.querySelector('#reminderPatient').textContent = patient;
        modal.querySelector('#reminderMessage').textContent = message;
        modal.querySelector('#reminderMedicine').textContent = medicine;
        modal.querySelector('#reminderDosage').textContent = dosage;
        modal.querySelector('#reminderTime').textContent = reminderTime;
        modal.querySelector('#reminderStatus').textContent = status;
        modal.querySelector('#reminderStartDate').textContent = startDate
        modal.querySelector('#reminderEndDate').textContent = endDate
    });
});
</script>

<!-- Reminder Detail Modal -->
<div class="modal fade" id="reminderDetailModal" tabindex="-1" aria-labelledby="reminderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reminderDetailModalLabel">Reminder Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    <li><strong>Patient:</strong> <span id="reminderPatient"></span></li>
                    <li><strong>Message:</strong> <span id="reminderMessage"></span></li>
                    <li><strong>Medicine:</strong> <span id="reminderMedicine"></span></li>
                    <li><strong>Dosage:</strong> <span id="reminderDosage"></span></li>
                    <li><strong>Reminder Time:</strong> <span id="reminderTime"></span></li>
                    <li><strong>Start Date:</strong> <span id="reminderStartDate"></span></li>
                    <li><strong>End Date:</strong> <span id="reminderEndDate"></span></li>
                    <li><strong>Status:</strong> <span id="reminderStatus"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush
@endsection
