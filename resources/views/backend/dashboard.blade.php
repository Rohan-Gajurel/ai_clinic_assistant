@extends('backend.layout.app')

@section('title')
    <title>Dashboard - MediNest Admin</title>
@endsection

@push('style')

@endpush
    

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: var(--secondary-color); font-weight: 600;">Dashboard</h4>
        <p class="text-muted mb-0">Welcome back! Here's your clinic overview.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary">
            <i class="bi bi-download me-2"></i>Export
        </button>
        <button class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>New Appointment
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Total Patients</p>
                        <h3 class="mb-0 fw-bold">1,248</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 12% from last month</small>
                    </div>
                    <div class="stats-icon" style="background: rgba(27, 182, 177, 0.1);">
                        <i class="bi bi-people" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Appointments Today</p>
                        <h3 class="mb-0 fw-bold">42</h3>
                        <small class="text-muted">8 pending confirmation</small>
                    </div>
                    <div class="stats-icon" style="background: rgba(13, 110, 253, 0.1);">
                        <i class="bi bi-calendar-check" style="color: #0d6efd; font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Active Doctors</p>
                        <h3 class="mb-0 fw-bold">18</h3>
                        <small class="text-muted">Across 6 departments</small>
                    </div>
                    <div class="stats-icon" style="background: rgba(25, 135, 84, 0.1);">
                        <i class="bi bi-person-badge" style="color: #198754; font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Revenue This Month</p>
                        <h3 class="mb-0 fw-bold">$48,250</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 8% increase</small>
                    </div>
                    <div class="stats-icon" style="background: rgba(111, 66, 193, 0.1);">
                        <i class="bi bi-currency-dollar" style="color: #6f42c1; font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Appointments -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="bi bi-calendar3 me-2" style="color: var(--primary-color);"></i>Recent Appointments
                </h5>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Department</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=1bb6b1&color=fff" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <span class="fw-medium">John Doe</span>
                                    </div>
                                </td>
                                <td>Dr. Sarah Smith</td>
                                <td>Cardiology</td>
                                <td>09:00 AM</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Jane+Wilson&background=1bb6b1&color=fff" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <span class="fw-medium">Jane Wilson</span>
                                    </div>
                                </td>
                                <td>Dr. Michael Brown</td>
                                <td>Dermatology</td>
                                <td>10:30 AM</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Robert+Johnson&background=1bb6b1&color=fff" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <span class="fw-medium">Robert Johnson</span>
                                    </div>
                                </td>
                                <td>Dr. Emily Davis</td>
                                <td>Pediatrics</td>
                                <td>11:00 AM</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Lisa+Anderson&background=1bb6b1&color=fff" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <span class="fw-medium">Lisa Anderson</span>
                                    </div>
                                </td>
                                <td>Dr. James Wilson</td>
                                <td>Orthopedics</td>
                                <td>02:00 PM</td>
                                <td><span class="badge bg-info">In Progress</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Mark+Taylor&background=1bb6b1&color=fff" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <span class="fw-medium">Mark Taylor</span>
                                    </div>
                                </td>
                                <td>Dr. Sarah Smith</td>
                                <td>Cardiology</td>
                                <td>03:30 PM</td>
                                <td><span class="badge bg-danger">Cancelled</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions & Activity -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning me-2" style="color: var(--primary-color);"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-primary text-start">
                        <i class="bi bi-person-plus me-2"></i>Add New Patient
                    </a>
                    <a href="#" class="btn btn-outline-primary text-start">
                        <i class="bi bi-calendar-plus me-2"></i>Schedule Appointment
                    </a>
                    <a href="#" class="btn btn-outline-primary text-start">
                        <i class="bi bi-file-earmark-medical me-2"></i>Create Medical Record
                    </a>
                    <a href="#" class="btn btn-outline-primary text-start">
                        <i class="bi bi-receipt me-2"></i>Generate Invoice
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-activity me-2" style="color: var(--primary-color);"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 36px; height: 36px; background: rgba(25, 135, 84, 0.1);">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0 fw-medium">Appointment Completed</p>
                            <small class="text-muted">John Doe - Dr. Smith</small>
                            <small class="text-muted d-block">10 min ago</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 36px; height: 36px; background: rgba(13, 110, 253, 0.1);">
                                <i class="bi bi-person-plus text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0 fw-medium">New Patient Registered</p>
                            <small class="text-muted">Emily Watson</small>
                            <small class="text-muted d-block">25 min ago</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 36px; height: 36px; background: rgba(111, 66, 193, 0.1);">
                                <i class="bi bi-receipt text-purple" style="color: #6f42c1;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0 fw-medium">Payment Received</p>
                            <small class="text-muted">$150.00 - Invoice #1234</small>
                            <small class="text-muted d-block">1 hour ago</small>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 36px; height: 36px; background: rgba(255, 193, 7, 0.1);">
                                <i class="bi bi-calendar text-warning"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0 fw-medium">Appointment Rescheduled</p>
                            <small class="text-muted">Mark Taylor</small>
                            <small class="text-muted d-block">2 hours ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
