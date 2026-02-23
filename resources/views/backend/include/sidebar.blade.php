<!-- Sidebar -->
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar position-fixed h-100">
    <div class="d-flex flex-column h-100">
        <!-- Logo -->
        <div class="sidebar-brand text-center">
            <a href="/" class="text-decoration-none">
                <h4 class="mb-0 d-flex align-items-center justify-content-center">
                    <i class="bi bi-heart-pulse me-2" style="color: #1bb6b1;"></i>
                    <span style="color: #fff;">Tele</span><span style="color: #1bb6b1;">Med</span>
                </h4>
                {{-- <small class="text-white-50">Clinic Management</small> --}}
            </a>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-grow-1 overflow-auto py-3">
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                        <i class="bi bi-grid-1x2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}" href="{{ url('/calendar') }}">
                        <i class="bi bi-calendar"></i>
                        Calendar
                    </a>
                </li>

                <li class="menu-header">Management</li>

                <!-- Appointments -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        Appointments
                    </a>
                </li>

                <!-- Patients -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('patients.index') ? 'active' : '' }}" href="{{ route('patients.index') }}">
                        <i class="bi bi-person-badge"></i>
                        Patients
                    </a>
                </li>


                <!-- Departments -->
               

                <!-- Feedbacks -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('feedback.index') ? 'active' : '' }}" href="{{ route('feedback.index') }}">
                        <i class="bi bi-chat-dots"></i>
                        Feedbacks
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reminders.index') ? 'active' : '' }}" href="{{ route('reminders.index') }}">
                        <i class="bi bi-bell"></i>
                        Reminders
                    </a>
                </li>

                <li class="menu-header">Administration</li>

                <!-- Users Dropdown -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#usersSubmenu" role="button" aria-expanded="{{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'true' : 'false' }}" aria-controls="usersSubmenu">
                        <i class="bi bi-people"></i>
                        <span class="flex-grow-1">User Management</span>
                        <i class="bi bi-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="collapse submenu {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'show' : '' }}" id="usersSubmenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.users') ? 'active' : '' }}" href="{{ route('users.users') }}">
                                    <i class="bi bi-circle-fill" style="font-size: 0.4rem;"></i>
                                    All Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                    <i class="bi bi-circle-fill" style="font-size: 0.4rem;"></i>
                                    Roles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                                    <i class="bi bi-circle-fill" style="font-size: 0.4rem;"></i>
                                    Permissions
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#doctorSubmenu" role="button" aria-expanded="{{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'true' : 'false' }}" aria-controls="doctorSubmenu">
                        <i class="bi bi-people"></i>
                        <span class="flex-grow-1">Doctor Management</span>
                        <i class="bi bi-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="collapse submenu {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'show' : '' }}" id="doctorSubmenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('doctors.doctors') ? 'active' : '' }}" href="{{ route('doctors.doctors') }}">
                                    <i class="bi bi-circle-fill" style="font-size: 0.4rem;"></i>
                                    All Doctors
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                    <i class="bi bi-circle-fill" style="font-size: 0.4rem;"></i>
                                    Departments
                                </a>
                            </li>
                             <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('schedules.index') ? 'active' : '' }}" href="{{ route('schedules.index') }}">
                        <i class="bi bi-building"></i>
                        Schedules
                    </a>
                </li>
                        </ul>
                    </div>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear"></i>
                        Settings
                    </a>
                </li>

                <!-- Reports -->
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Reports
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-top border-secondary">
            <a href="{{ url('/') }}" class="nav-link text-center" target="_blank">
                <i class="bi bi-box-arrow-up-right me-2"></i>
                <small>View Website</small>
            </a>
        </div>
    </div>
</nav>