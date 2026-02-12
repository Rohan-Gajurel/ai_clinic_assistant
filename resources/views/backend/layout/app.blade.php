<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <meta name="description" content="MediNest Admin Dashboard">
    <meta name="keywords" content="Clinic, Healthcare, Admin, Dashboard">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    @stack('style')

    <style>
        :root {
            --primary-color: #1bb6b1;
            --primary-hover: #159e9a;
            --primary-light: rgba(27, 182, 177, 0.1);
            --secondary-color: #2c4964;
            --sidebar-bg: linear-gradient(180deg, #1a5653 0%, #0d3230 100%);
            --body-bg: #f0f5f4;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg);
        }

        /* Sidebar Styles */
        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 0;
        }

        .sidebar-brand span {
            color: var(--primary-color);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.85rem 1.25rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(27, 182, 177, 0.3);
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar .menu-header {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1rem 1.25rem 0.5rem;
            margin-top: 0.5rem;
        }

        .sidebar .submenu .nav-link {
            padding-left: 3rem;
            font-size: 0.85rem;
        }

        /* Main Content */
        .main-content {
            min-height: 100vh;
            background: var(--body-bg);
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .search-box {
            background: var(--body-bg);
            border: none;
            border-radius: 0.5rem;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            background: #fff;
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }

        .card-header .card-title {
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--body-bg);
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
            padding: 1rem 1.25rem;
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            color: #495057;
        }

        .table-hover tbody tr:hover {
            background-color: var(--primary-light);
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 0.5rem;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(27, 182, 177, 0.35);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 0.5rem;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-danger {
            border-radius: 0.5rem;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.5em 0.85em;
            border-radius: 0.375rem;
        }

        .badge.bg-success {
            background: rgba(40, 167, 69, 0.15) !important;
            color: #28a745;
        }

        .badge.bg-warning {
            background: rgba(255, 193, 7, 0.15) !important;
            color: #d39e00;
        }

        .badge.bg-danger {
            background: rgba(220, 53, 69, 0.15) !important;
            color: #dc3545;
        }

        .badge.bg-info {
            background: rgba(13, 202, 240, 0.15) !important;
            color: #0dcaf0;
        }

        /* Stats Cards */
        .stats-card {
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Forms */
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #e0e0e0;
            padding: 0.65rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 0.5rem;
            padding: 1rem 1.25rem;
        }

        /* Footer */
        .admin-footer {
            background: #fff;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-top: 1.5rem;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.03);
        }

        /* Stats Cards */
        .stat-card {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card .stat-icon.primary {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .stat-card .stat-icon.success {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .stat-card .stat-icon.warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .stat-card .stat-icon.danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Action Buttons */
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 0.375rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .action-btn.edit {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .action-btn.edit:hover {
            background: var(--primary-color);
            color: #fff;
        }

        .action-btn.delete {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .action-btn.delete:hover {
            background: #dc3545;
            color: #fff;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            @include('backend.include.sidebar')

            <!-- Main Content -->
            <main class="col-md-10 col-lg-10 ms-auto main-content">
                <div class="p-4">
                    <!-- Navbar -->
                    @include('backend.include.navbar')

                    <!-- Page Content -->
                    <div class="py-2">
                        @yield('content')
                    </div>

                    <!-- Footer -->
                    @include('backend.include.footer')
                </div>
            </main>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('script')

    <script>
        // Initialize AOS
        AOS.init();
    </script>
</body>

</html>