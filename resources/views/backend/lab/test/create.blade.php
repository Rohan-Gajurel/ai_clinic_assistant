@extends('backend.layout.app')

@section('title')
    <title>Create Lab Test - TeleMed Admin</title>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-semibold">Create Lab Test</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Lab Tests</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('lab-test.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the errors below:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                    </div>
                @endif

                <form action="{{ route('lab-test.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Test Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Method</label>
                            <select name="method_id" class="form-select" >
                                <option value="">Select Method</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}" {{ old('method_id') == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sample</label>
                            <select name="sample_id" class="form-select" >
                                <option value="">Select Sample</option>
                                @foreach($samples as $sample)
                                    <option value="{{ $sample->id }}" {{ old('sample_id') == $sample->id ? 'selected' : '' }}>{{ $sample->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Result Type</label>
                            <select name="result_type" class="form-select" required>
                                <option value="">Select Result Type</option>
                                <option value="numeric" {{ old('result_type') == 'numeric' ? 'selected' : '' }}>Numeric</option>
                                <option value="text" {{ old('result_type') == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="positive_negative" {{ old('result_type') == 'positive_negative' ? 'selected' : '' }}>Positive/Negative</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Reference From</label>
                            <input type="text" name="reference_from" class="form-control" value="{{ old('reference_from') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Reference To</label>
                            <input type="text" name="reference_to" class="form-control" value="{{ old('reference_to') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit" class="form-control" value="{{ old('unit') }}" placeholder="e.g., mg/dL, mmol/L">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Testable</label>
                            <select name="testable" class="form-select" required>
                                <option value="1" {{ old('testable', '1') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('testable') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Create Lab Test
                    </button>

                    <a href="{{ route('lab-test.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection


