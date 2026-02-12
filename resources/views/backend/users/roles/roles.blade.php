@extends('backend.layout.app')

@section('title')
    <title>Roles - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Role Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </nav>
    </div>
    {{-- @can('role_permission_manage') --}}
    <a href="{{ route('roles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New Role
    </a>
    {{-- @endcan --}}
</div>

<!-- Alert Messages -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <strong>{{ session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session('delete_message'))
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
            <i class="bi bi-shield-check me-2" style="color: var(--primary-color);"></i>All Roles
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col">Role Name</th>
                        <th scope="col" class="text-center" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($roles as $role)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px; background: var(--primary-light);">
                                    <i class="bi bi-shield" style="color: var(--primary-color);"></i>
                                </div>
                                <span class="fw-medium">{{ $role->name }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('roles.edit', $role->id) }}" class="action-btn edit me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" class="d-inline">
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
        <span class="text-muted">Showing {{ count($roles) }} roles</span>
    </div>
</div>

@endsection