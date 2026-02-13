@extends('backend.layout.app')

@section('title')
    <title>Edit Doctor - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Edit Doctor</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('doctors.doctors') }}" style="color: var(--primary-color);">Doctors</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('doctors.doctors') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Doctors
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-key-fill me-2" style="color: var(--primary-color);"></i>Doctor Information
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
                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="user_id" class="form-label">
                            <i class="bi bi-person me-1 text-muted"></i>Linked User
                        </label>
                        <select name="user_id" id="user_id" class="form-select" required readonly>
                            <option value="">-- Select user --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ $u->id == $doctor->user_id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">Select the user account for this doctor</small>
                    </div>

                    <div class="mb-3">
                        <label for="specialization" class="form-label">
                            <i class="bi bi-briefcase-medical me-1 text-muted"></i>Specialization
                        </label>
                        <input type="text" name="specialization" id="specialization" class="form-control" placeholder="e.g. Cardiology" value="{{ old('specialization', $doctor->specialization) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="license_number" class="form-label">License Number</label>
                            <input type="text" name="license_number" id="license_number" class="form-control" value="{{ old('license_number', $doctor->license_number) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="consultation_fee" class="form-label">Consultation Fee</label>
                            <input type="number" step="0.01" name="consultation_fee" id="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number', $doctor->contact_number) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea name="bio" id="bio" rows="4" class="form-control">{{ old('bio', $doctor->bio) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ old('status', $doctor->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $doctor->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Update Doctor
                        </button>
                        <a href="{{ route('doctors.doctors') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightbulb me-2" style="color: var(--primary-color);"></i>Common Permission Names
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Here are some common permission naming conventions:</p>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><code>view_patients</code></li>
                            <li class="mb-2"><code>create_patients</code></li>
                            <li class="mb-2"><code>edit_patients</code></li>
                            <li class="mb-2"><code>delete_patients</code></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><code>manage_appointments</code></li>
                            <li class="mb-2"><code>view_reports</code></li>
                            <li class="mb-2"><code>manage_billing</code></li>
                            <li class="mb-2"><code>admin_access</code></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection