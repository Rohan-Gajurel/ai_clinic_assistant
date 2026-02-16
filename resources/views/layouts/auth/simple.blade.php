<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Authentication' }} - {{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Healthcare clinic management system">
        
        <!-- Favicons -->
        <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        
        <!-- Main CSS -->
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
        
        <style>
            :root {
                --primary-color: #1bb6b1;
                --secondary-color: #0d6efd;
                --light-bg: #f8f9fa;
                --border-color: #e9ecef;
            }

            * {
                font-family: 'Poppins', sans-serif;
            }

            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .auth-container {
                width: 100%;
                max-width: 450px;
                padding: 1.5rem;
            }

            .auth-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                padding: 2.5rem;
            }

            .auth-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .auth-logo {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
            }

            .auth-logo img,
            .auth-logo i {
                width: 50px;
                height: 50px;
                color: var(--primary-color);
            }

            .auth-card h2 {
                color: #1a1a1a;
                font-weight: 600;
                margin-bottom: 0.5rem;
                font-size: 1.5rem;
            }

            .auth-card .text-muted {
                color: #6c757d !important;
                font-size: 0.95rem;
            }

            .form-control {
                border: 1px solid var(--border-color);
                border-radius: 6px;
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
                margin-bottom: 1rem;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(27, 182, 177, 0.25);
            }

            .form-label {
                color: #333;
                font-weight: 500;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }

            .btn-primary-auth {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0d9b96 100%);
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                color: white;
                font-weight: 600;
                width: 100%;
                transition: all 0.3s ease;
            }

            .btn-primary-auth:hover {
                background: linear-gradient(135deg, #0d9b96 0%, var(--primary-color) 100%);
                box-shadow: 0 5px 15px rgba(27, 182, 177, 0.3);
                transform: translateY(-2px);
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-check {
                margin-bottom: 1rem;
            }

            .form-check-input {
                width: 1rem;
                height: 1rem;
                border-color: var(--border-color);
                margin-top: 0.3rem;
            }

            .form-check-input:checked {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .form-check-label {
                margin-left: 0.5rem;
                color: #333;
                font-weight: 500;
            }

            .auth-footer {
                text-align: center;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid var(--border-color);
            }

            .auth-footer p {
                margin: 0;
                color: #666;
                font-size: 0.9rem;
            }

            .auth-link {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .auth-link:hover {
                color: #0d9b96;
                text-decoration: underline;
            }

            .alert {
                border-radius: 6px;
                border: none;
                margin-bottom: 1.5rem;
            }

            .alert-success {
                background-color: rgba(25, 135, 84, 0.1);
                color: #198754;
            }

            .alert-danger {
                background-color: rgba(220, 53, 69, 0.1);
                color: #dc3545;
            }

            .password-toggle {
                position: absolute;
                right: 12px;
                top: 38px;
                cursor: pointer;
                color: #999;
                background: none;
                border: none;
                padding: 0;
            }

            .password-field {
                position: relative;
            }

            .divider {
                display: flex;
                align-items: center;
                margin: 1.5rem 0;
            }

            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: var(--border-color);
            }

            .divider span {
                margin: 0 1rem;
                color: #999;
                font-size: 0.85rem;
            }

            @media (max-width: 576px) {
                .auth-card {
                    padding: 1.5rem;
                }

                .auth-card h2 {
                    font-size: 1.25rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <a href="{{ route('home') }}">
                            <i class="bi bi-hospital"></i>
                        </a>
                    </div>
                </div>

                {{ $slot }}
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
