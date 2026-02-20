@extends('backend.layout.app')

@section('title')
    <title>Create Patient - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Create New Patient</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" style="color: var(--primary-color);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('doctors.doctors') }}" style="color: var(--primary-color);">Doctors</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('doctors.doctors') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Doctors
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-lines-fill me-2" style="color: var(--primary-color);"></i>Patient Information
                </h5>
            </div>
            @if($errors->any())
                <div class="alert alert-danger m-3" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Patient Personal Information -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="mb-3">Personal Information</h6>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="title" class="form-label">Title</label>
                                <select name="title" id="title" class="form-select @error('title') is-invalid @enderror">
                                    <option value="">-- Select --</option>
                                    <option value="mr" {{ old('title') == 'mr' ? 'selected' : '' }}>Mr.</option>
                                    <option value="ms" {{ old('title') == 'ms' ? 'selected' : '' }}>Ms.</option>
                                    <option value="mrs" {{ old('title') == 'mrs' ? 'selected' : '' }}>Mrs.</option>
                                    <option value="dr" {{ old('title') == 'dr' ? 'selected' : '' }}>Dr.</option>
                                    <option value="prof" {{ old('title') == 'prof' ? 'selected' : '' }}>Prof.</option>
                                </select>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-9 mb-3">
                                <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror" placeholder="Enter full name" value="{{ old('full_name') }}" required>
                                @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                <input type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror" placeholder="Age" value="{{ old('age') }}" required>
                                @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="age_unit" class="form-label">Age Unit</label>
                                <select name="age_unit" id="age_unit" class="form-select @error('age_unit') is-invalid @enderror">
                                    <option value="years" {{ old('age_unit') == 'years' ? 'selected' : '' }}>Years</option>
                                    <option value="months" {{ old('age_unit') == 'months' ? 'selected' : '' }}>Months</option>
                                    <option value="weeks" {{ old('age_unit') == 'weeks' ? 'selected' : '' }}>Weeks</option>
                                    <option value="days" {{ old('age_unit') == 'days' ? 'selected' : '' }}>Days</option>
                                </select>
                                @error('age_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth </label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" >
                                @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                <select name="sex" id="sex" class="form-select @error('sex') is-invalid @enderror" required>
                                    <option value="">-- Select --</option>
                                    <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('sex') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('sex') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marital_status" class="form-label">Marital Status</label>
                                <select name="marital_status" id="marital_status" class="form-select @error('marital_status') is-invalid @enderror">
                                    <option value="">-- Select --</option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                                @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="mb-3">Contact Information</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" name="contact_number" id="contact_number" class="form-control @error('contact_number') is-invalid @enderror" placeholder="Phone number" value="{{ old('contact_number') }}" required>
                                @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" value="{{ old('email') }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Full address" value="{{ old('address') }}" required>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Medical Information -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="mb-3">Medical Information</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="blood_group" class="form-label">Blood Group</label>
                                <select name="blood_group" id="blood_group" class="form-select @error('blood_group') is-invalid @enderror">
                                    <option value="">-- Select --</option>
                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_group') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="patient_type" class="form-label">Patient Type</label>
                                <input type="text" name="patient_type" id="patient_type" class="form-control @error('patient_type') is-invalid @enderror" placeholder="e.g., General, Emergency" value="{{ old('patient_type') }}">
                                @error('patient_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Identification -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="mb-3">Identification</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_card_type" class="form-label">ID Card Type</label>
                                <select name="id_card_type" id="id_card_type" class="form-select @error('id_card_type') is-invalid @enderror">
                                    <option value="">-- Select --</option>
                                    <option value="passport" {{ old('id_card_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                    <option value="citizenship" {{ old('id_card_type') == 'citizenship' ? 'selected' : '' }}>Citizenship</option>
                                    <option value="driver_license" {{ old('id_card_type') == 'driver_license' ? 'selected' : '' }}>Driver License</option>
                                    <option value="national_id" {{ old('id_card_type') == 'national_id' ? 'selected' : '' }}>National ID</option>
                                    <option value="citizenship" {{ old('id_card_type') == 'citizenship' ? 'selected' : '' }}>Citizenship</option>
                                </select>
                                @error('id_card_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_card_number" class="form-label">ID Card Number</label>
                                <input type="text" name="id_card_number" id="id_card_number" class="form-control @error('id_card_number') is-invalid @enderror" placeholder="ID number" value="{{ old('id_card_number') }}">
                                @error('id_card_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" name="nationality" id="nationality" class="form-control @error('nationality') is-invalid @enderror" placeholder="Country" value="{{ old('nationality') }}">
                            @error('nationality') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="mb-3">Permanent Address</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label">Province</label>
                                <input type="text" name="province" id="province" class="form-control @error('province') is-invalid @enderror" placeholder="Province" value="{{ old('province') }}">
                                @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="district" class="form-label">District</label>
                                <input type="text" name="district" id="district" class="form-control @error('district') is-invalid @enderror" placeholder="District" value="{{ old('district') }}">
                                @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="local_level" class="form-label">Local Level</label>
                                <input type="text" name="local_level" id="local_level" class="form-control @error('local_level') is-invalid @enderror" placeholder="Local level" value="{{ old('local_level') }}">
                                @error('local_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ward_number" class="form-label">Ward Number</label>
                                <input type="text" name="ward_number" id="ward_number" class="form-control @error('ward_number') is-invalid @enderror" placeholder="Ward number" value="{{ old('ward_number') }}">
                                @error('ward_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="mb-4">
                        <label for="photo" class="form-label">Patient Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Create Patient Profile
                        </button>
                        <a href="{{ route('patients.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection