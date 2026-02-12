@extends('backend.layout.app')

@section('title')
    <title>Edit Permission - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Edit Permission</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}" style="color: var(--primary-color);">Permissions</a></li>
                <li class="breadcrumb-item active">Edit</li>
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
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="permission_name" class="form-label">
                            <i class="bi bi-tag me-1 text-muted"></i>Permission Name
                        </label>
                        <input type="text" name="permission_name" id="permission_name" class="form-control" value="{{ $permission->name }}" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Permission
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
                    <i class="bi bi-info-circle me-2" style="color: var(--primary-color);"></i>Permission Details
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; background: var(--primary-light);">
                    <i class="bi bi-key" style="font-size: 2rem; color: var(--primary-color);"></i>
                </div>
                <h5 class="mb-1">{{ $permission->name }}</h5>
                <span class="badge" style="background: #e8f4f3; color: #1bb6b1;">Guard: web</span>
                <hr class="my-3">
                <div class="text-start">
                    <small class="text-muted d-block mb-2">
                        <i class="bi bi-calendar me-1"></i>Created: {{ $permission->created_at->format('M d, Y') }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="bi bi-clock me-1"></i>Last Updated: {{ $permission->updated_at->format('M d, Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection