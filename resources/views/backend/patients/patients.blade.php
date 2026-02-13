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
                        <th scope="col" style="width:220px; min-width:150px;">Email</th>
                        <th scope="col" style="width:140px; min-width:100px;">Contact</th>
                        <th scope="col" style="width:140px; min-width:100px;">DOB</th>
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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}&background=1bb6b1&color=fff" 
                                     alt="{{ $patient->name }}" 
                                     class="rounded-circle me-3" 
                                     width="40" 
                                     height="40">
                                <div>
                                    <span class="fw-medium d-block">{{ $patient->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $patient->email ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $patient->phone ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $patient->dob ? $patient->dob->format('Y-m-d') : 'N/A' }}
                        </td>
                        <td class="text-center">
                            <!-- View (eye) button - always visible -->
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                data-bs-toggle="modal" data-bs-target="#patientDetailModal"
                                data-id="{{ $patient->id }}"
                                data-name="{{ $patient->name }}"
                                data-email="{{ $patient->email }}"
                                data-phone="{{ $patient->phone ?? 'N/A' }}"
                                data-dob="{{ $patient->dob ? $patient->dob->format('Y-m-d') : 'N/A' }}"
                                data-blood="{{ $patient->blood_group ?? 'N/A' }}"
                                data-disease="{{ Str::limit($patient->disease ?? 'N/A', 300) }}"
                                data-allergies="{{ Str::limit($patient->allergies ?? 'N/A', 300) }}"
                                title="View">
                                <i class="bi bi-eye"></i>
                            </button>

                            @can('patient_manage')
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

<!-- Patient Detail Modal -->
<div class="modal fade" id="patientDetailModal" tabindex="-1" aria-labelledby="patientDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientDetailModalLabel">Patient Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="patientAvatar" src="" alt="avatar" class="rounded-circle mb-3" width="120" height="120">
                        <h5 id="patientName"></h5>
                        <small class="text-muted d-block" id="patientExtra"></small>
                        <div class="mt-2" id="patientStatusBadge"></div>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> <span id="patientEmail"></span></li>
                            <li><strong>Date of Birth:</strong> <span id="patientDob"></span></li>
                            <li><strong>Blood Group:</strong> <span id="patientBlood"></span></li>
                            <li><strong>Contact:</strong> <span id="patientContact"></span></li>
                            <li><strong>Allergies:</strong> <span id="patientAllergies"></span></li>
                        </ul>
                        <hr>
                        <h6>Medical History</h6>
                        <p id="patientDisease" class="small text-muted"></p>
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
document.addEventListener('show.bs.modal', function (event) {
    if (event.target.id !== 'patientDetailModal') return;
    var button = event.relatedTarget;
    var name = button.getAttribute('data-name');
    var email = button.getAttribute('data-email');
    var contact = button.getAttribute('data-contact');
    var dob = button.getAttribute('data-dob');
    var blood = button.getAttribute('data-blood');
    var disease = button.getAttribute('data-disease');
    var allergies = button.getAttribute('data-allergies');

    var avatar = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&background=1bb6b1&color=fff&size=200';
    var img = document.getElementById('patientAvatar');
    if (img) img.src = avatar;

    var modal = event.target;
    modal.querySelector('.modal-title').textContent = (name || 'Patient') + ' — Details';
    modal.querySelector('#patientName').textContent = name || 'N/A';
    modal.querySelector('#patientEmail').textContent = email || 'N/A';
    modal.querySelector('#patientContact').textContent = contact || 'N/A';
    modal.querySelector('#patientDob').textContent = dob || 'N/A';
    modal.querySelector('#patientBlood').textContent = blood || 'N/A';
    modal.querySelector('#patientDisease').textContent = disease || 'N/A';
    modal.querySelector('#patientAllergies').textContent = allergies || 'N/A';
});
</script>
@endpush