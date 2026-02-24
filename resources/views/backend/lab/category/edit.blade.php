@extends('backend.layout.app')

@section('title')
    <title>Edit Category - TeleMed Admin</title>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-semibold">Edit Category</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('lab-category.index') }}" class="btn btn-outline-secondary">
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

                <form action="{{ route('lab-category.update', $labCategory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $labCategory->name) }}" required>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Update Category
                    </button>

                    <a href="{{ route('lab-category.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection


