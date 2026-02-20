@extends('backend.layout.app')
@section('title')
    <title>Feedbacks - Tele Med</title>
@endsection
@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Feedback Management</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item active">Feedbacks</li>
            </ol>
        </nav>
    </div>
</div>


<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>All Feedbacks
        </h5>
        <div class="d-flex align-items-center">
            <div class="input-group me-2" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search feedbacks..." id="searchFeedbacks">
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
                        <th scope="col" style="width:250px; min-width:150px;">Doctor Name</th>
                        <th scope="col" class="text-center" style="width:150px;">Rating</th>
                        <th scope="col" class="text-center" style="width:150px;">Review</th>
                        <th scope="col" style="width:140px; min-width:100px;">Would Recommend</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($feedbacks as $feedback)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td >
                            {{ $feedback->patient->user->name ?? 'N/A' }}
                        </td>
                        <td>
                             {{ $feedback->doctor->user->name ?? 'N/A' }}
                        </td>
                        <td >{{ $feedback->rating ?? 'N/A' }}</td>
                        <td class="text-center">{{ $feedback->review ?? 'N/A' }}</td>
                        <td>{{ $feedback->would_recommend ? 'Yes' : 'No' }}</td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <span class="text-muted">Showing {{ count($feedbacks) }} feedbacks</span>
    </div>
</div>
@endsection


