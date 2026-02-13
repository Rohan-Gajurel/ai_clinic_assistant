@extends('backend.layout.app')
@section('title')
    <title>Schedules - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Doctor Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Schedules</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('schedules.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New Schedule
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
            <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>All Schedules
        </h5>
        <div class="d-flex align-items-center">
            <div class="input-group me-2" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search schedules..." id="searchSchedules">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col" style="width:320px; min-width:200px;">Doctor</th>
                        <th scope="col" style="width:220px; min-width:150px;">Days of Week</th>
                        <th scope="col" style="width:140px; min-width:100px;">Start Time</th>
                        <th scope="col" style="width:140px; min-width:100px;">End Time</th>
                        <th scope="col" style="width:140px; min-width:100px;">Slot Duration</th>
                        <th scope="col" style="width:140px; min-width:100px;">Status</th>
                        <th scope="col" class="text-center" style="width:150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($schedules as $schedule)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="fw-medium d-block">{{ $schedule->doctor->user->name ?? 'N/A' }}</span>
                                    <small class="text-muted">{{ $schedule->doctor->specialization ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $days = 'N/A';
                                if (is_array($schedule->days_of_week)) {
                                    $days = implode(', ', $schedule->days_of_week);
                                } elseif (!empty($schedule->days_of_week)) {
                                    $days = $schedule->days_of_week;
                                }
                            @endphp
                            {{ $days }}
                        </td>
                        <td>
                            {{ $schedule->start_time ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $schedule->end_time ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $schedule->slot_duration ?? 'N/A' }} minutes
                        </td>
                        <td>
                            @php $status = $schedule->status ?? 'inactive'; @endphp
                            @if($status == 'active')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Active
                                </span>
                            @elseif($status == 'suspended')
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

                            @can('doctor_manage')
                            @if(auth()->user()->can('doctor_manage'))   
                            <a href="{{ route('schedules.edit', $schedule->id) }}" class="action-btn edit me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
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
        <span class="text-muted">Showing {{ count($schedules) }} schedules</span>
    </div>
</div> 
        

@endsection
