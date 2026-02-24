@extends('backend.layout.app')

@section('title')
    <title>Lab Tests - TeleMed Admin</title>
@endsection

@push('style')

@endpush

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Lab Test Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Lab Tests</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('lab-test.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Lab Test
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
            <i class="bi bi-calendar3 me-2" style="color: var(--primary-color);"></i>All Lab Tests
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Lab Test Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Method</th>
                        <th>Sample</th>
                        <th>Reference From</th>
                        <th>Reference To</th>
                        <th>Unit</th>
                        <th>Charge Amount</th>
                        <th>Result Field</th>
                        <th>Testable </th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($tests as $test)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $test->name }}</td>
                            <td>{{ $test->code }}</td>
                            <td>{{ $test->category->name }}</td>
                            <td>{{ $test->method ? $test->method->name : '-' }}</td>
                            <td>{{ $test->sample ? $test->sample->name : '-' }}</td>
                            <td>{{ $test->reference_from ?? '-' }}</td>
                            <td>{{ $test->reference_to ?? '-' }}</td>
                            <td>{{ $test->unit }}</td>
                            <td>{{ $test->price }}</td>
                            <td>{{ $test->result_type }}</td>
                            <td>{{ $test->testable ? 'Yes' : 'No' }}</td>
                            <td>{{ $test->status ? 'Active' : 'Inactive' }}</td>
                            <td class="text-center">
                                <a href="{{ route('lab-test.edit', $test->id) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>

                                <form action="{{ route('lab-test.destroy', $test->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this test?');">
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
        <span class="text-muted">Showing {{ count($tests) }} lab tests</span>
    </div>
</div>

@endsection
