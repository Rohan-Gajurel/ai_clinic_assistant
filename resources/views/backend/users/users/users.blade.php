@extends('backend.layout.app')

@section('title')
    <title>Users - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">User Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div>
    <a href="#" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New User
    </a>
</div>

<!-- Alert Messages -->
@if(session('delete_message'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i>
    <strong>{{ session('delete_message')}}</strong>
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
            <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>All Users
        </h5>
        <div class="d-flex align-items-center">
            <div class="input-group me-2" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search users..." id="searchUsers">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1bb6b1&color=fff" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle me-3" 
                                     width="40" 
                                     height="40">
                                <div>
                                    <span class="fw-medium d-block">{{ $user->name }}</span>
                                    <small class="text-muted">ID: #{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="bi bi-envelope me-1 text-muted"></i>
                            {{ $user->email }}
                        </td>
                        <td>
                            <span class="badge" style="background: var(--primary-light); color: var(--primary-color);">
                                {{ $user->getRoleNames()->first() ?? 'No Role' }}
                            </span>
                        </td>
                        <td>
                            @if($user->status=='active')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Active
                                </span>
                            @elseif($user->status=='suspended')
                                <span class="badge bg-warning">
                                    <i class="bi bi-pause-circle me-1"></i>Suspended
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Inactive
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', $user->id) }}" class="action-btn edit me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete">
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
        <span class="text-muted">Showing {{ count($users) }} users</span>
    </div>
</div> 
        

@endsection