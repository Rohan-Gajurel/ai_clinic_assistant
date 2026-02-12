@extends('backend.layout.app')

@section('title')
    <title>Create Permission - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Create New Permission</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}" style="color: var(--primary-color);">Permissions</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Permissions
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-key-fill me-2" style="color: var(--primary-color);"></i>Permission Information
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
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="permission_name" class="form-label">
                            <i class="bi bi-tag me-1 text-muted"></i>Permission Name
                        </label>
                        <input type="text" name="permission_name" id="permission_name" class="form-control" placeholder="e.g. view_patients, edit_appointments" required>
                        <small class="text-muted mt-1 d-block">
                            <i class="bi bi-info-circle me-1"></i>Use lowercase with underscores (e.g., manage_users)
                        </small>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Create Permission
                        </button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-light">Cancel</a>
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