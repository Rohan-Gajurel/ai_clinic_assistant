@extends('backend.layout.app')

@section('title')
    <title>Edit User - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Edit User</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.users') }}" style="color: var(--primary-color);">Users</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('users.users') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Users
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-gear me-2" style="color: var(--primary-color);"></i>User Information
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
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="user_name" class="form-label">
                            <i class="bi bi-person me-1 text-muted"></i>User Name
                        </label>
                        <input type="text" name="user_name" id="user_name" class="form-control" value="{{ $user->name }}" placeholder="Enter user name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1 text-muted"></i>Email Address
                        </label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" placeholder="Enter email address">
                    </div>                
                    <div class="mb-4">
                        <label for="status" class="form-label">
                            <i class="bi bi-toggle-on me-1 text-muted"></i>Status
                        </label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update User
                        </button>
                        <a href="{{ route('users.users') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2" style="color: var(--primary-color);"></i>User Details
                </h5>
            </div>
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1bb6b1&color=fff&size=100" 
                     alt="{{ $user->name }}" 
                     class="rounded-circle mb-3" 
                     width="100" 
                     height="100">
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <span class="badge @if($user->status=='active') bg-success @elseif($user->status=='suspended') bg-warning @else bg-danger @endif">
                    {{ ucfirst($user->status) }}
                </span>
                <hr class="my-3">
                <div class="text-start">
                    <small class="text-muted d-block mb-2">
                        <i class="bi bi-calendar me-1"></i>Created: {{ $user->created_at->format('M d, Y') }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="bi bi-clock me-1"></i>Last Updated: {{ $user->updated_at->format('M d, Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection