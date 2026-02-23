@extends('backend.layout.app')

@section('title')
    <title>Patients - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Patient Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Patients</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('patients.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New Patient
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
            <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>All Patients
        </h5>
        <div class="d-flex align-items-center">
            <div class="input-group me-2" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search patients..." id="searchPatients">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col" style="width:320px; min-width:200px;">Name</th>
                        <th scope="col" style="width:220px; min-width:150px;">Address</th>
                        <th scope="col" style="width:140px; min-width:100px;">Contact</th>
                        <th scope="col" style="width:140px; min-width:100px;">Age</th>
                        <th scope="col" class="text-center" style="width:150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($patients as $patient)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $patient->photo ? asset('storage/' . $patient->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->full_name ?? 'Unknown') . '&background=1bb6b1&color=fff' }}" alt="avatar" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <div>{{ $patient->full_name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $patient->address ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $patient->contact_number ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $patient->age }} {{ $patient->age_unit ?? 'N/A' }} 
                        </td>
                        <td class="text-center">
                            @can('patient_manage')
                            <a href="{{ route('patients.visitDetails', $patient->id) }}" class="btn btn-sm btn-outline-info me-1"title="View Visit Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('patients.edit', $patient->id) }}" class="action-btn edit me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <span class="text-muted">Showing {{ count($patients) }} patients</span>
    </div>
</div> 
        

@endsection
