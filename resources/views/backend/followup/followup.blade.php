@extends('backend.layout.app')
@section('title')
    <title>Follow-ups - Tele Med</title>
@endsection
@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Follow-up Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Follow-ups</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('followups.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New Follow-up
    </a>
</div>

<!-- Alert Messages -->
@if(session('delete_message'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i>
    <strong>{{ session('delete_message')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <strong>{{ session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>All Follow-ups
        </h5>
        <div class="d-flex align-items-center">
            <div class="input-group me-2" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search follow-ups..." id="searchFollowups">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col" style="width:220px; min-width:200px;">Patient Name</th>
                        <th scope="col" style="width:250px; min-width:150px;">Notes</th>
                        <th scope="col" class="text-center" style="width:150px;">Date</th>
                        <th scope="col" class="text-center" style="width:150px;">Time</th>
                        <th scope="col" style="width:140px; min-width:100px;">Status</th>
                        <th scope="col" class="text-center" style="width:150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($followups as $followup)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td >
                            {{ $followup->appointment->patient->user->name ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $followup->notes ?? 'N/A' }}
                        </td>
                        <td >{{ $followup->followup_date ?? 'N/A' }}</td>
                        <td class="text-center">{{ $followup->followup_time ?? 'N/A' }}</td>
                        <td>
                            <form method="POST" action="{{ route('followups.update', $followup->id) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select class="badge {{ $followup->status == 'completed' ? 'bg-success' : 'bg-warning' }}"" name="status" style="width: auto; display: inline-block;" onchange="this.form.submit();">
                                    <option value="pending" {{ $followup->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $followup->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td> 
                            
                        <td class="text-center">
                            <form action="{{ route('followups.destroy', $followup->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this follow-up?');" class="d-inline">
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
        <span class="text-muted">Showing {{ count($followups) }} follow-ups</span>
    </div>
</div>
@endsection


