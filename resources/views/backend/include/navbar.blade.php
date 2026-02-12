<!-- Top Navbar -->
<div class="top-navbar d-flex align-items-center justify-content-between">
    <!-- Left: Toggle & Search -->
    <div class="d-flex align-items-center">
        <!-- Toggle Button for Mobile Sidebar -->
        <button class="btn d-lg-none me-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" style="color: var(--primary-color);">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Search Bar -->
        <div class="position-relative d-none d-md-block">
            <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
            <input type="search" class="search-box" placeholder="Search patients, appointments...">
        </div>
    </div>

    <!-- Right Side Items -->
    <div class="d-flex align-items-center">
        <!-- Quick Actions -->
        <button class="btn btn-primary me-3 d-none d-md-flex align-items-center" style="font-size: 0.875rem;">
            <i class="bi bi-plus-lg me-2"></i>
            New Appointment
        </button>

        <!-- Notification Dropdown -->
        <div class="dropdown me-3">
            <button class="btn position-relative p-2" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: var(--primary-light); border-radius: 0.5rem;">
                <i class="bi bi-bell" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                <span class="notification-badge">3</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="notificationDropdown" style="min-width: 320px; border-radius: 0.75rem;">
                <li class="px-3 py-2 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="mb-0 fw-bold">Notifications</h6>
                    <span class="badge bg-primary" style="background: var(--primary-color) !important;">3 New</span>
                </li>
                <li>
                    <a class="dropdown-item py-3" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--primary-light);">
                                    <i class="bi bi-calendar-check" style="color: var(--primary-color);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-medium">New appointment request</p>
                                <small class="text-muted">John Doe - 2 min ago</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-3" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(40, 167, 69, 0.1);">
                                    <i class="bi bi-person-plus" style="color: #28a745;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-medium">New patient registered</p>
                                <small class="text-muted">Jane Smith - 1 hour ago</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="border-top">
                    <a class="dropdown-item text-center py-2" href="#" style="color: var(--primary-color);">
                        View all notifications
                    </a>
                </li>
            </ul>
        </div>

        <!-- Messages -->
        <div class="dropdown me-3">
            <button class="btn position-relative p-2" type="button" style="background: rgba(40, 167, 69, 0.1); border-radius: 0.5rem;">
                <i class="bi bi-chat-dots" style="color: #28a745; font-size: 1.25rem;"></i>
            </button>
        </div>

        <!-- User Profile Dropdown -->
        <div class="dropdown user-dropdown">
            <button class="btn d-flex align-items-center p-1 pe-3" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: var(--body-bg); border-radius: 2rem;">
                <img src="{{ asset('assets/img/health/staff-1.webp') }}" 
                     alt="User" 
                     class="rounded-circle me-2" 
                     width="38" 
                     height="38" 
                     style="object-fit: cover;"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=1bb6b1&color=fff'">
                <div class="text-start d-none d-md-block">
                    <span class="d-block fw-medium" style="font-size: 0.9rem; color: var(--secondary-color);">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <small class="text-muted" style="font-size: 0.75rem;">Administrator</small>
                </div>
                <i class="bi bi-chevron-down ms-2" style="font-size: 0.75rem;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown" style="border-radius: 0.75rem; min-width: 200px;">
                <li class="px-3 py-2 border-bottom">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/img/health/staff-1.webp') }}" 
                             alt="User" 
                             class="rounded-circle me-2" 
                             width="45" 
                             height="45"
                             style="object-fit: cover;"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=1bb6b1&color=fff'">
                        <div>
                            <span class="d-block fw-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <small class="text-muted">{{ Auth::user()->email ?? 'admin@example.com' }}</small>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="#">
                        <i class="bi bi-person me-2" style="color: var(--primary-color);"></i>My Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="#">
                        <i class="bi bi-gear me-2" style="color: var(--primary-color);"></i>Settings
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="#">
                        <i class="bi bi-question-circle me-2" style="color: var(--primary-color);"></i>Help Center
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>