@extends('backend.layout.app')
@section('title')
    <title>Create Reminder - Tele Med</title>
@endsection

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Create New Reminder</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reminders.index') }}" style="color: var(--primary-color);">Reminders</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('reminders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Reminders
    </a>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-key-fill me-2" style="color: var(--primary-color);"></i>Reminder Information
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
                <form action="{{ route('reminders.store') }}" method="POST">
                    @csrf

                    <!-- Patient Selection -->
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">
                            <i class="bi bi-person me-1 text-muted"></i>Patient
                        </label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <option value="">-- Select Patient --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">Select the patient for this reminder</small>
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <label for="message" class="form-label">
                            <i class="bi bi-chat-left-text me-1 text-muted"></i>Message
                        </label>
                        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Enter reminder message" required>{{ old('message') }}</textarea>
                    </div>

                    <!-- Medicine and Dosage -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="medicine" class="form-label">Medicine</label>
                            <input type="text" name="medicine" id="medicine" class="form-control" placeholder="Enter medicine name" value="{{ old('medicine') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dosage" class="form-label">Dosage</label>
                            <input type="text" name="dosage" id="dosage" class="form-control" placeholder="Enter dosage" value="{{ old('dosage') }}">
                        </div>
                    </div>

                    <!-- Reminder Time and Dates -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="reminder_time" class="form-label">Reminder Time</label>
                            <input type="time" name="reminder_time" id="reminder_time" class="form-control" value="{{ old('reminder_time') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="stopped" {{ old('status') == 'stopped' ? 'selected' : '' }}>Stopped</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Create Reminder
                        </button>
                        <a href="{{ route('reminders.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection