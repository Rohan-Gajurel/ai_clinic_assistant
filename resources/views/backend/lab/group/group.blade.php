@extends('backend.layout.app')

@section('title')
    <title>Lab Methods - TeleMed Admin</title>
@endsection

@push('style')

@endpush

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Lab Groups Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Lab Groups</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('lab-group.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Lab Group
    </a>
</div>

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('updated'))
    <div class="alert alert-info">{{ session('updated') }}</div>
@elseif(session('deleted'))
    <div class="alert alert-danger">{{ session('deleted') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="bi bi-calendar3 me-2" style="color: var(--primary-color);"></i>All Lab Groups
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Group Name</th>
                        <th>Charge Amount</th>
                        <th>Lab Category</th>
                        <th>Lab Test</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($groups as $method)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->charge_amount }}</td>
                            <td>{{ $method->category ? $method->category->name : 'N/A' }}</td>
                            <td>{{ $method->tests->pluck('name')->implode(', ') }}</td>
                            

                            <td class="text-center">
                                <a href="{{ route('lab-group.edit', $method->id) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>

                                <form action="{{ route('lab-group.destroy', $method->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this group?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent">
        <span class="text-muted">Showing {{ count($groups) }} lab groups</span>
    </div>
</div>

@endsection
