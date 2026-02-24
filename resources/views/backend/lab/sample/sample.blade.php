@extends('backend.layout.app')

@section('title')
    <title>Samples - TeleMed Admin</title>
@endsection

@push('style')

@endpush

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Sample Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Samples</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('lab-sample.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Sample
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
            <i class="bi bi-calendar3 me-2" style="color: var(--primary-color);"></i>All Samples
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sample Name</th>
                        <th>Code</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($samples as $sample)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $sample->name }}</td>
                            <td>{{ $sample->code }}</td>
                            <td class="text-center">
                                <a href="{{ route('lab-sample.edit', $sample->id) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>

                                <form action="{{ route('lab-sample.destroy', $sample->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this sample?');">
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
        <span class="text-muted">Showing {{ count($samples) }} samples</span>
    </div>
</div>

@endsection
