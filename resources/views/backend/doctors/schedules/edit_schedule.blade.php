@extends('backend.layout.app')

@section('title')
    <title>Create Scheduels - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Create New Scheduel</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('doctors.doctors') }}" style="color: var(--primary-color);">Doctors</a></li>
                <li class="breadcrumb-item active">Create Scheduel</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('doctors.doctors') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Doctors
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-key-fill me-2" style="color: var(--primary-color);"></i>Scheduel Information
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
                <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">
                            <i class="bi bi-person me-1 text-muted"></i>Linked Doctor
                        </label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="">-- Select doctor --</option>
                            @foreach($doctors as $u)
                                <option value="{{ $u->id }}" {{ old('doctor_id', $schedule->doctor_id) == $u->id ? 'selected' : '' }}>{{ $u->user->name ?? 'N/A' }} ({{ $u->user->email ?? '' }})</option>
                            @endforeach
                        </select>
                        @error('doctor_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        <small class="text-muted mt-1 d-block">Select the doctor account for this schedule</small>
                    </div>

                    <div class="mb-3">
                        <label for="days_of_week" class="form-label">
                            <i class="bi bi-calendar-week me-1 text-muted"></i>Day of Week</label>
                        <select name="days_of_week[]" id="days_of_week" class="form-select" multiple required>
                            @php $selectedDays = old('days_of_week', $schedule->days_of_week ?? []); $selectedDays = is_array($selectedDays) ? $selectedDays : (array)$selectedDays; @endphp
                            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                <option value="{{ $day }}" {{ in_array($day, $selectedDays) ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block">Hold Ctrl (Windows) or Cmd (Mac) to select multiple days.</small>
                        @error('days_of_week')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $schedule->start_time ? date('H:i', strtotime($schedule->start_time)) : '') }}">
                            @error('start_time')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $schedule->end_time ? date('H:i', strtotime($schedule->end_time)) : '') }}" >
                            @error('end_time')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="slot_duration" class="form-label">Slot Duration (minutes)</label>
                        <input type="number" name="slot_duration" id="slot_duration" class="form-control" value="{{ old('slot_duration', $schedule->slot_duration ?? '') }}" min="1" >
                        @error('slot_duration')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ old('status', $schedule->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $schedule->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Update Schedule
                        </button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection