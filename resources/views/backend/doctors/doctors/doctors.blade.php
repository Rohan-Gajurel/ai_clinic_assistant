@extends('backend.layout.app')

@section('title')
    <title>Doctors - MediNest Admin</title>
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
                <li class="breadcrumb-item active">Doctors</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('doctors.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New Doctor
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
            <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>All Doctors
        </h5>
        <div class="d-flex align-items-center">
            <div class="input-group me-2" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search doctors..." id="searchDoctors">
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
                        <th scope="col" style="width:220px; min-width:150px;">Specialization</th>
                        <th scope="col" style="width:140px; min-width:100px;">Status</th>
                        <th scope="col" class="text-center" style="width:150px;">Qualification</th>
                        <th scope="col" class="text-center" style="width:150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($doctors as $doctor)
                    <tr>
                        <td class="fw-medium">{{ $i }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $doctor->profile_picture ? asset('storage/' . $doctor->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($doctor->user->name) . '&background=1bb6b1&color=fff&size=200' }}" alt="avatar" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <span class="fw-medium d-block">{{ $doctor->user->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $doctor->specialization ?? 'N/A' }}
                        </td>
                        <td>
                            @if($doctor->status=='active')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Active
                                </span>
                            @elseif($doctor->status=='suspended')
                                <span class="badge bg-warning">
                                    <i class="bi bi-pause-circle me-1"></i>Suspended
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Inactive
                                </span>
                            @endif
                        </td>
                        <td class="text-center">{{ $doctor->qualification ?? 'N/A' }}</td>
                        <td class="text-center">
                            <!-- View (eye) button - always visible -->
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                data-bs-toggle="modal" data-bs-target="#doctorDetailModal"
                                data-id="{{ $doctor->user->id }}"
                                data-name="{{ $doctor->user->name }}"
                                data-email="{{ $doctor->user->email }}"
                                data-role="{{ $doctor->user->getRoleNames()->first() ?? 'No Role' }}"
                                data-specialization="{{ $doctor->specialization ?? 'N/A' }}"
                                data-license="{{ $doctor->license_number ?? 'N/A' }}"
                                data-fee="{{ $doctor->consultation_fee ?? 'N/A' }}"
                                data-contact="{{ $doctor->contact_number ?? 'N/A' }}"
                                data-bio="{{ Str::limit($doctor->bio ?? 'N/A', 300) }}"
                                data-status="{{ $doctor->status }}"
                                title="View">
                                <i class="bi bi-eye"></i>
                            </button>

                            @can('doctor_manage')
                            <a href="{{ route('doctors.edit', $doctor->id) }}" class="action-btn edit me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor?');" class="d-inline">
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
        <span class="text-muted">Showing {{ count($doctors) }} doctors</span>
    </div>
</div> 
        

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('doctorDetailModal')
        if (!modal) return;

        modal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var email = button.getAttribute('data-email');
                var role = button.getAttribute('data-role');
                var specialization = button.getAttribute('data-specialization');
                var license = button.getAttribute('data-license');
                var fee = button.getAttribute('data-fee');
                var contact = button.getAttribute('data-contact');
                var bio = button.getAttribute('data-bio');
                var status = button.getAttribute('data-status');

                modal.querySelector('.modal-title').textContent = name + ' — Details';
                modal.querySelector('#docName').textContent = name;
                modal.querySelector('#docEmail').textContent = email;
                modal.querySelector('#docRole').textContent = role;
                modal.querySelector('#docSpecialization').textContent = specialization;
                modal.querySelector('#docLicense').textContent = license;
                modal.querySelector('#docFee').textContent = fee;
                modal.querySelector('#docContact').textContent = contact;
                modal.querySelector('#docBio').textContent = bio;
                modal.querySelector('#docStatus').textContent = status;
        });
});
</script>

<!-- Doctor Detail Modal -->
<div class="modal fade" id="doctorDetailModal" tabindex="-1" aria-labelledby="doctorDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorDetailModalLabel">Doctor Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="docAvatar" src="" alt="avatar" class="rounded-circle mb-3" width="120" height="120">
                        <h5 id="docName"></h5>
                        <small class="text-muted d-block" id="docRole"></small>
                        <div class="mt-2" id="docStatusBadge"></div>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> <span id="docEmail"></span></li>
                            <li><strong>Specialization:</strong> <span id="docSpecialization"></span></li>
                            <li><strong>License #:</strong> <span id="docLicense"></span></li>
                            <li><strong>Consultation Fee:</strong> <span id="docFee"></span></li>
                            <li><strong>Contact:</strong> <span id="docContact"></span></li>
                        </ul>
                        <hr>
                        <h6>Bio</h6>
                        <p id="docBio" class="small text-muted"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// populate avatar src when modal shows
// Ensure dynamic avatar updates correctly
document.addEventListener('show.bs.modal', function (event) {
        if (event.target.id !== 'doctorDetailModal') return;
        var button = event.relatedTarget;
        var avatar = button.getAttribute('data-avatar') || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(button.getAttribute('data-name')) + '&background=1bb6b1&color=fff&size=200';
        var img = document.getElementById('docAvatar');
        if (img) img.src = avatar;
});
</script>
@endpush