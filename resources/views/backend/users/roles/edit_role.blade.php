@extends('backend.layout.app')

@section('title')
    <title>Edit Role - MediNest Admin</title>
@endsection

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Edit Role</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" style="color: var(--primary-color);">Roles</a></li>
                <li class="breadcrumb-item active">Edit</li>
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
                    <i class="bi bi-shield-check me-2" style="color: var(--primary-color);"></i>Role Information
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
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Role Name --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-tag me-1 text-muted"></i>Role Name
                        </label>
                        <input type="text"
                               name="role_name"
                               value="{{ old('role_name', $role->name) }}"
                               class="form-control"
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
                                               style="border-color: var(--primary-color);"
                                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
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
                                <option value="{{ $user->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">
                            <i class="bi bi-info-circle me-1"></i>Hold Ctrl (Windows) or Cmd (Mac) to select multiple users
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Role
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
                    <i class="bi bi-info-circle me-2" style="color: var(--primary-color);"></i>Role Details
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: var(--primary-light);">
                    <i class="bi bi-shield-check" style="font-size: 2rem; color: var(--primary-color);"></i>
                </div>
                <h5 class="mb-1">{{ $role->name }}</h5>
                <p class="text-muted mb-3">{{ $role->permissions->count() }} permissions assigned</p>
                <hr class="my-3">
                <div class="text-start">
                    <small class="text-muted d-block mb-2">
                        <i class="bi bi-calendar me-1"></i>Created: {{ $role->created_at->format('M d, Y') }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="bi bi-clock me-1"></i>Last Updated: {{ $role->updated_at->format('M d, Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection