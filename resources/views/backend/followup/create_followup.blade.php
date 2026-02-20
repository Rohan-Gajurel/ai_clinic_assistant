@extends('backend.layout.app')

@section('title')
    <title>Create Follow-up - Tele Med</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Create New Follow-up</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('followups.index') }}" style="color: var(--primary-color);">Follow-ups</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('followups.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Follow-ups
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-key-fill me-2" style="color: var(--primary-color);"></i>Follow-up Information
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
                <form action="{{ route('followups.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="appointment_id" class="form-label">
                            <i class="bi bi-person me-1 text-muted"></i>Appointment (Patient)
                        </label>
                        <select name="appointment_id" id="appointment_id" class="form-select" required>
                            <option value="">-- Select Patient --</option>
                            @foreach($appointments as $appointment)
                                <option value="{{$appointment->id ?? '' }}">{{ $appointment->patient->user->name ?? 'N/A' }} ({{ $appointment->patient->user->email ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">Select the user account for this follow-up</small>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            <i class="bi bi-briefcase-medical me-1 text-muted"></i>Notes
                        </label>
                        <input type="text" name="notes" id="notes" class="form-control" placeholder="Enter follow-up notes" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="followup_time" class="form-label">Follow-up Time</label>
                            <input type="time" name="followup_time" id="followup_time" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="followup_date" class="form-label">Follow-up Date</label>
                            <input type="date" name="followup_date" id="followup_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Create Follow-up
                        </button>
                        <a href="{{ route('followups.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection