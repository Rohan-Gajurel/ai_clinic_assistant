@extends('backend.layout.app')

@section('title')
    <title>Patient Visit Details - MediNest Admin</title>
@endsection

@section('content')
<div @class(['d-flex', 'justify-content-between', 'align-items-center', 'mb-4'])>
    <div>
        <h4 @class(['mb-1', 'fw-semibold'])>Patient Visit Details</h4>
        <nav aria-label="breadcrumb">
            <ol @class(['breadcrumb', 'mb-0'])>
                <li @class(['breadcrumb-item'])><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li @class(['breadcrumb-item'])><a href="{{ route('patients.index') }}">Patients</a></li>
                <li @class(['breadcrumb-item', 'active'])>Visit Details</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('patients.index') }}" @class(['btn', 'btn-outline-secondary'])>
        <i @class(['bi', 'bi-arrow-left', 'me-2'])></i>Back
    </a>
</div>

<!-- Patient Header Card -->
<div @class(['card', 'mb-4', 'shadow-sm'])>
    <div @class(['card-body'])>
        <div @class(['row'])>
            <!-- Patient Photo and ID -->
            <div @class(['col-md-2', 'text-center'])>
                <img src="{{ $patient->photo ? asset('storage/' . $patient->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->full_name) . '&background=1bb6b1&color=fff' }}"
                     alt="avatar" @class(['rounded-circle', 'mb-2']) width="80" height="80">
                <div @class(['fw-bold', 'fs-5', 'text-muted'])>ID: {{ $patient->id }}</div>
            </div>
            
            <!-- Patient Info -->
            <div @class(['col-md-10'])>
                <div @class(['row', 'mb-3'])>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Registration Date</small>
                        <strong>{{ optional($patient->created_at)->format('Y-m-d') ?? 'N/A' }}</strong>
                    </div>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Full Name</small>
                        <strong>{{ $patient->full_name ?? 'N/A' }}</strong>
                    </div>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Age / Gender</small>
                        <strong>{{ $patient->age ?? 'N/A' }} / {{ ucfirst($patient->sex ?? 'N/A') }}</strong>
                    </div>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Contact</small>
                        <strong>{{ $patient->contact_number ?? 'N/A' }}</strong>
                    </div>
                </div>
                <div @class(['row', 'mb-3'])>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Address</small>
                        <strong>{{ $patient->address ?? 'N/A' }}</strong>
                    </div>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Blood Group</small>
                        <strong>{{ $patient->blood_group ?? 'N/A' }}</strong>
                    </div>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Email</small>
                        <strong>{{ $patient->email ?? 'N/A' }}</strong>
                    </div>
                    <div @class(['col-md-3'])>
                        <small @class(['text-muted', 'd-block'])>Marital Status</small>
                        <strong>{{ ucfirst($patient->marital_status ?? 'N/A') }}</strong>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div @class(['mt-3'])>
                    <button @class(['btn', 'btn-info', 'btn-sm', 'me-2']) title="View visit history">
                        <i @class(['bi', 'bi-clock-history', 'me-1'])></i>Visit History
                    </button>
                    <button @class(['btn', 'btn-success', 'btn-sm', 'me-2']) title="View patient card">
                        <i @class(['bi', 'bi-card-text', 'me-1'])></i>Patient Card
                    </button>
                    <button @class(['btn', 'btn-primary', 'btn-sm', 'me-2']) title="Refer to another doctor">
                        <i @class(['bi', 'bi-arrow-repeat', 'me-1'])></i>Refer
                    </button>
                    <button @class(['btn', 'btn-warning', 'btn-sm', 'me-2']) title="Add new appointment">
                        <i @class(['bi', 'bi-calendar-check', 'me-1'])></i>New Appointment
                    </button>
                    <button @class(['btn', 'btn-danger', 'btn-sm']) title="End current visit">
                        <i @class(['bi', 'bi-x-circle', 'me-1'])></i>End Visit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<ul @class(['nav', 'nav-tabs', 'mb-3']) id="visitTabs" role="tablist">
    <li @class(['nav-item']) role="presentation">
        <button @class(['nav-link', 'active']) id="observations-tab" data-bs-toggle="tab" data-bs-target="#observations" type="button" role="tab">
            <i @class(['bi', 'bi-binoculars', 'me-1'])></i>Observations
        </button>
    </li>
    <li @class(['nav-item']) role="presentation">
        <button @class(['nav-link']) id="laborders-tab" data-bs-toggle="tab" data-bs-target="#laborders" type="button" role="tab">
            <i @class(['bi', 'bi-flask', 'me-1'])></i>Lab Orders
        </button>
    </li>
    <li @class(['nav-item']) role="presentation">
        <button @class(['nav-link']) id="diagnosis-tab" data-bs-toggle="tab" data-bs-target="#diagnosis" type="button" role="tab">
            <i @class(['bi', 'bi-file-earmark-text', 'me-1'])></i>Diagnosis
        </button>
    </li>
    <li @class(['nav-item']) role="presentation">
        <button @class(['nav-link']) id="medication-tab" data-bs-toggle="tab" data-bs-target="#medication" type="button" role="tab">
            <i @class(['bi', 'bi-capsule', 'me-1'])></i>Medication
        </button>
    </li>
</ul>

<!-- Tab Contents -->
<div @class(['tab-content']) id="visitTabsContent">
    <!-- Observations Tab -->
    <div @class(['tab-pane', 'fade', 'show', 'active']) id="observations" role="tabpanel" aria-labelledby="observations-tab">
        <div @class(['card', 'shadow-sm'])>
            <div @class(['card-header', 'bg-light'])>
                <h6 @class(['mb-0'])>Examination Details</h6>
            </div>
            <div @class(['card-body'])>
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
                <form method="POST" action="{{ route('visit.storeExamination') }}">
                    @csrf
                    <div @class(['row'])>
                        <input type="text" @class(['form-control']) name="patient_id" value="{{ $patient->id }}" hidden>
                    
                    <div @class(['col-md-6', 'mb-3'])>
                        <label @class(['form-label'])>Primary Symptom</label>
                        <input type="text" @class(['form-control']) name="primary_symptom" placeholder="Enter primary symptom...">
                    </div>
                    <div @class(['col-md-6', 'mb-3'])>
                        <label @class(['form-label'])>For how long?</label>
                        <input type="text" @class(['form-control']) name="symptom_duration_value" placeholder="Duration of symptoms...">
                    </div>
                    </div>
                    <div @class(['row'])>
                    <div @class(['col-md-6', 'mb-3'])>
                        <label @class(['form-label'])>Duration of Symptoms</label>
                        <select @class(['form-select']) name="symptom_duration_unit">
                            <option value="">Select duration</option>
                            <option value="days">Days</option>
                            <option value="weeks">Weeks</option>
                            <option value="months">Months</option>
                            <option value="years">Years</option>
                        </select>
                    </div>
                    <div @class(['col-md-6', 'mb-3'])>
                        <label @class(['form-label'])>Other Symptoms</label>
                        <input type="text" @class(['form-control']) name="other_symptoms" placeholder="Enter other symptoms if any...">   
                    </div>
                    </div>
                <button type="submit" @class(['btn', 'btn-primary', 'btn-sm'])>
                    <i @class(['bi', 'bi-check-lg', 'me-1'])></i>Save 
                </button>
                </form>
            </div>
        </div>

        <!-- Vitals and Visit Details Row -->
<div @class(['row', 'mt-4'])>
    <!-- Vitals Card -->
        <div @class(['card', 'shadow-sm'])>
            <div @class(['card-header', 'bg-light'])>
                <h6 @class(['mb-0'])>
                    <i @class(['bi', 'bi-heart-pulse', 'me-2'])></i>Vital Signs
                </h6>
            </div>
            <form method="POST" action="{{ route('visit.storeVitals') }}">
            @csrf
            <input type="text" @class(['form-control']) name="patient_id" value="{{ $patient->id }}" hidden>
            <div @class(['card-body'])>
                <div @class(['row'])>
                    <div @class(['col-md-6', 'mb-3'])>
                        <small @class(['text-muted', 'd-block'])>Blood Pressure</small>
                        <input name="blood_pressure" type="text" @class(['form-control']) value="{{ $patient->observationVitals->blood_pressure ?? '120/80 mmHg' }}">
                    </div>
                    <div @class(['col-md-6', 'mb-3'])>
                        <small @class(['text-muted', 'd-block'])>Pulse</small>
                        <input name="heart_rate" type="text" @class(['form-control']) value="{{ $patient->observationVitals->heart_rate ?? '72 bpm' }}">
                    </div>
                    <div @class(['col-md-6', 'mb-3'])>
                        <small @class(['text-muted', 'd-block'])>Temperature</small>
                        <input name="temperature" type="text" @class(['form-control']) value="{{ $patient->observationVitals->temperature ?? '98.6°F' }}">
                    </div>
                    <div @class(['col-md-6', 'mb-3'])>
                        <small @class(['text-muted', 'd-block'])>Respiratory Rate</small>
                        <input name="respiratory_rate" type="text" @class(['form-control']) value="{{ $patient->observationVitals->respiratory_rate ?? '16 breaths/min' }}">
                    </div>
                    <div @class(['col-md-6'])>
                        <small @class(['text-muted', 'd-block'])>Height</small>
                        <input type="text" name="height" @class(['form-control']) value="{{ $patient->observationVitals->height ?? '5\'10"' }}">
                    </div>
                    <div @class(['col-md-6'])>
                        <small @class(['text-muted', 'd-block'])>Weight</small>
                        <input type="text" name="weight" @class(['form-control']) value="{{ $patient->observationVitals->weight ?? '70 kg' }}">
                    </div>
                </div>
                <button @class(['btn', 'btn-sm', 'btn-outline-primary', 'mt-3'])>
                    <i @class(['bi', 'bi-pencil', 'me-1'])></i>Edit Vitals
                </button>
            </div>
            </form>
        </div>
    </div>

    <div @class(['row', 'mt-4'])>
    <!-- Medical History Card - Disease & Drug History -->
        <div @class(['card', 'shadow-sm'])>
            <div @class(['card-header', 'bg-light'])>
                <h6 @class(['mb-0'])>
                    <i @class(['bi', 'bi-file-earmark-medical', 'me-2'])></i>Patient History
                </h6>
            </div>
            <div @class(['card-body'])>
                <form id="medicalHistoryForm">
                    <!-- Disease History Section -->
                    <div @class(['mb-4'])>
                        <h6 @class(['fw-bold', 'mb-3', 'text-primary'])>Disease History</h6>
                        <table @class(['table', 'table-bordered', 'table-sm'])>
                            <thead @class(['bg-light'])>
                                <tr>
                                    <th style="width: 35%;">Name <span @class(['text-danger'])>*</span></th>
                                    <th style="width: 35%;">For <span @class(['text-danger'])>*</span></th>
                                    <th style="width: 20%;">State <span @class(['text-danger'])>*</span></th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody id="diseaseHistoryBody2">
                                <tr>
                                    <td><input type="text" @class(['form-control', 'form-control-sm']) name="disease_name[]" placeholder="Disease name" required></td>
                                    <td><input type="text" @class(['form-control', 'form-control-sm']) name="disease_for[]" placeholder="Duration" required></td>
                                    <td><input type="text" @class(['form-control', 'form-control-sm']) name="disease_state[]" placeholder="Active/Cured" required></td>
                                    <td @class(['text-center'])>
                                        <button type="button" @class(['btn', 'btn-sm', 'btn-danger', 'removeRow2']) style="display:none;">
                                            <i @class(['bi', 'bi-x'])></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" @class(['btn', 'btn-primary', 'btn-sm']) id="addDiseaseRow2">
                            <i @class(['bi', 'bi-plus-lg', 'me-1'])></i>Add
                        </button>
                    </div>

                    <!-- Drug History Section -->
                    <div @class(['mb-4'])>
                        <h6 @class(['fw-bold', 'mb-3', 'text-primary'])>Drug History</h6>
                        <table @class(['table', 'table-bordered', 'table-sm'])>
                            <thead @class(['bg-light'])>
                                <tr>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 20%;">Dose</th>
                                    <th style="width: 20%;">Frequency</th>
                                    <th style="width: 20%;">For</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody id="drugHistoryBody2">
                                <tr>
                                    <td><input type="text" @class(['form-control', 'form-control-sm']) name="drug_name[]" placeholder="Drug name"></td>
                                    <td><input type="text" @class(['form-control', 'form-control-sm']) name="drug_dose[]" placeholder="Dose"></td>
                                    <td>
                                        <select @class(['form-select', 'form-select-sm']) name="drug_frequency[]">
                                            <option value="">Select</option>
                                            <option value="once_daily">Once Daily</option>
                                            <option value="twice_daily">Twice Daily</option>
                                            <option value="thrice_daily">Thrice Daily</option>
                                            <option value="as_needed">As Needed</option>
                                        </select>
                                    </td>
                                    <td><input type="text" @class(['form-control', 'form-control-sm']) name="drug_for[]" placeholder="Condition"></td>
                                    <td @class(['text-center'])>
                                        <button type="button" @class(['btn', 'btn-sm', 'btn-danger', 'removeRow2']) style="display:none;">
                                            <i @class(['bi', 'bi-x'])></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" @class(['btn', 'btn-primary', 'btn-sm']) id="addDrugRow2">
                            <i @class(['bi', 'bi-plus-lg', 'me-1'])></i>Add
                        </button>
                    </div>

                    <!-- Action Button -->
                    <button type="submit" @class(['btn', 'btn-success', 'btn-sm'])>
                        <i @class(['bi', 'bi-check-circle', 'me-1'])></i>Save
                    </button>
                </form>
            </div>
    </div>
</div>

    </div>

    <!-- Lab Orders Tab -->
    <div @class(['tab-pane', 'fade']) id="laborders" role="tabpanel" aria-labelledby="laborders-tab">
        <div @class(['card', 'shadow-sm'])>
            <div @class(['card-header', 'bg-light', 'd-flex', 'justify-content-between', 'align-items-center'])>
                <h6 @class(['mb-0'])>Lab Orders</h6>
                <button @class(['btn', 'btn-sm', 'btn-primary'])>
                    <i @class(['bi', 'bi-plus-lg', 'me-1'])></i>Add Lab Order
                </button>
            </div>
            <div @class(['card-body'])>
                @if(false)
                    <table @class(['table', 'table-hover'])>
                        <thead @class(['bg-light'])>
                            <tr>
                                <th>Test Name</th>
                                <th>Date Ordered</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Blood Work</td>
                                <td>2026-02-20</td>
                                <td><span @class(['badge', 'bg-warning'])>Pending</span></td>
                                <td>
                                    <button @class(['btn', 'btn-sm', 'btn-outline-secondary'])>View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p @class(['text-muted', 'text-center', 'py-4'])>
                        <i @class(['bi', 'bi-inbox', 'me-2'])></i>No lab orders yet
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Diagnosis Tab -->
    <div @class(['tab-pane', 'fade']) id="diagnosis" role="tabpanel" aria-labelledby="diagnosis-tab">
        <div @class(['card', 'shadow-sm'])>
            <div @class(['card-header', 'bg-light', 'd-flex', 'justify-content-between', 'align-items-center'])>
                <h6 @class(['mb-0'])>Diagnosis</h6>
                <button @class(['btn', 'btn-sm', 'btn-primary'])>
                    <i @class(['bi', 'bi-plus-lg', 'me-1'])></i>Add Diagnosis
                </button>
            </div>
            <div @class(['card-body'])>
                <div @class(['form-group'])>
                    <label @class(['form-label'])>Primary Diagnosis</label>
                    <input type="text" @class(['form-control']) placeholder="Enter primary diagnosis...">
                </div>
                <div @class(['form-group', 'mt-3'])>
                    <label @class(['form-label'])>Secondary Diagnosis</label>
                    <textarea @class(['form-control']) rows="3" placeholder="Enter secondary diagnoses if any..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Medication Tab -->
    <div @class(['tab-pane', 'fade']) id="medication" role="tabpanel" aria-labelledby="medication-tab">
        <div @class(['card', 'shadow-sm'])>
            <div @class(['card-header', 'bg-light', 'd-flex', 'justify-content-between', 'align-items-center'])>
                <h6 @class(['mb-0'])>Medications</h6>
                <button @class(['btn', 'btn-sm', 'btn-primary'])>
                    <i @class(['bi', 'bi-plus-lg', 'me-1'])></i>Add Medication
                </button>
            </div>
            <div @class(['card-body'])>
                @if(false)
                    <table @class(['table', 'table-hover'])>
                        <thead @class(['bg-light'])>
                            <tr>
                                <th>Medicine Name</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Paracetamol</td>
                                <td>500mg</td>
                                <td>2x Daily</td>
                                <td>5 days</td>
                                <td>
                                    <button @class(['btn', 'btn-sm', 'btn-outline-danger'])>Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p @class(['text-muted', 'text-center', 'py-4'])>
                        <i @class(['bi', 'bi-capsule', 'me-2'])></i>No medications prescribed yet
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Add Disease History Row
    document.getElementById('addDiseaseRow').addEventListener('click', function() {
        const tbody = document.getElementById('diseaseHistoryBody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" @class(['form-control']) name="disease_name[]" placeholder="Disease name" required></td>
            <td><input type="text" @class(['form-control']) name="disease_for[]" placeholder="Duration" required></td>
            <td>
                <select @class(['form-select']) name="disease_time[]" required>
                    <option value="">Select</option>
                    <option value="days">Days</option>
                    <option value="weeks">Weeks</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </td>
            <td><input type="text" @class(['form-control']) name="disease_state[]" placeholder="e.g., Active, Cured" required></td>
            <td @class(['text-center'])>
                <button type="button" @class(['btn', 'btn-sm', 'btn-danger', 'removeRow'])>
                    <i @class(['bi', 'bi-x'])></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        attachRemoveHandler();
    });

    // Add Drug History Row
    document.getElementById('addDrugRow').addEventListener('click', function() {
        const tbody = document.getElementById('drugHistoryBody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" @class(['form-control']) name="drug_name[]" placeholder="Drug name"></td>
            <td><input type="text" @class(['form-control']) name="drug_dose[]" placeholder="Dose"></td>
            <td>
                <select @class(['form-select']) name="drug_dose_unit[]">
                    <option value="">Select</option>
                    <option value="mg">mg</option>
                    <option value="g">g</option>
                    <option value="mcg">mcg</option>
                    <option value="ml">ml</option>
                    <option value="units">units</option>
                </select>
            </td>
            <td>
                <select @class(['form-select']) name="drug_frequency[]">
                    <option value="">Select</option>
                    <option value="once_daily">Once Daily</option>
                    <option value="twice_daily">Twice Daily</option>
                    <option value="thrice_daily">Thrice Daily</option>
                    <option value="as_needed">As Needed</option>
                </select>
            </td>
            <td><input type="text" @class(['form-control']) name="drug_for[]" placeholder="Condition"></td>
            <td>
                <select @class(['form-select']) name="drug_duration[]">
                    <option value="">Select</option>
                    <option value="days">Days</option>
                    <option value="weeks">Weeks</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </td>
            <td @class(['text-center'])>
                <button type="button" @class(['btn', 'btn-sm', 'btn-danger', 'removeRow'])>
                    <i @class(['bi', 'bi-x'])></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        attachRemoveHandler();
    });

    // Remove Row Handler
    function attachRemoveHandler() {
        document.querySelectorAll('.removeRow').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                this.closest('tr').remove();
            });
        });

        // Show remove buttons if more than one row
        const diseaseRows = document.querySelectorAll('#diseaseHistoryBody tr');
        diseaseRows.forEach(row => {
            const removeBtn = row.querySelector('.removeRow');
            if (removeBtn) {
                removeBtn.style.display = diseaseRows.length > 1 ? 'inline-block' : 'none';
            }
        });

        const drugRows = document.querySelectorAll('#drugHistoryBody tr');
        drugRows.forEach(row => {
            const removeBtn = row.querySelector('.removeBtn');
            if (removeBtn) {
                removeBtn.style.display = drugRows.length > 1 ? 'inline-block' : 'none';
            }
        });
    }

    // Form submit handler
    document.getElementById('historyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your form submission logic here
        alert('History saved successfully!');
    });

    // Initialize remove handlers on page load
    attachRemoveHandler();
</script>

@endsection
