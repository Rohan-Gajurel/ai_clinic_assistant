@extends('backend.layout.app')

@section('title')
    <title>Create Role - MediNest Admin</title>
@endsection

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Create New Role</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" style="color: var(--primary-color);">Roles</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Roles
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-shield-plus me-2" style="color: var(--primary-color);"></i>Role Information
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
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    {{-- Role Name --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-tag me-1 text-muted"></i>Role Name
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="e.g. Doctor, Nurse, Receptionist"
                               required>
                    </div>

                    {{-- Permissions --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-key me-1 text-muted"></i>Assign Permissions
                        </label>
                        <div class="row g-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 col-6">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               class="form-check-input"
                                               id="perm_{{ $permission->id }}"
                                               style="border-color: var(--primary-color);">
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Users --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-people me-1 text-muted"></i>Assign Users
                        </label>
                        <select name="users[]" multiple class="form-select" size="5">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">
                            <i class="bi bi-info-circle me-1"></i>Hold Ctrl (Windows) or Cmd (Mac) to select multiple users
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Create Role
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightbulb me-2" style="color: var(--primary-color);"></i>Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background: var(--primary-light);">
                            <i class="bi bi-1-circle" style="color: var(--primary-color);"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <small class="fw-medium d-block">Choose a clear name</small>
                        <small class="text-muted">Use descriptive role names like "Doctor" or "Admin"</small>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background: var(--primary-light);">
                            <i class="bi bi-2-circle" style="color: var(--primary-color);"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <small class="fw-medium d-block">Assign permissions</small>
                        <small class="text-muted">Select only necessary permissions for security</small>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background: var(--primary-light);">
                            <i class="bi bi-3-circle" style="color: var(--primary-color);"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <small class="fw-medium d-block">Add users (optional)</small>
                        <small class="text-muted">Assign users now or later from Users page</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection