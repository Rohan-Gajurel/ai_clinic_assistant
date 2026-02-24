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
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Lab Methods Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Lab Methods</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('lab-method.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Lab Method
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
            <i class="bi bi-calendar3 me-2" style="color: var(--primary-color);"></i>All Lab Methods
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Lab Method</th>
                        <th>Code</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($methods as $method)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->code }}</td>
                            <td class="text-center">
                                <a href="{{ route('lab-method.edit', $method->id) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>

                                <form action="{{ route('lab-method.destroy', $method->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this method?');">
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
        <span class="text-muted">Showing {{ count($methods) }} lab methods</span>
    </div>
</div>

@endsection
