<x-layouts::auth>
    <div class="auth-header">
        <h2>Verify Email Address</h2>
        <p class="text-muted">Check your email for the verification link</p>
    </div>

    <!-- Session Status -->
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Success!</strong> A new verification link has been sent to your email address.
        </div>
    @endif

    <!-- Verification Message -->
    <div class="alert alert-info" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn't receive it, we will gladly send you another.
    </div>

    <!-- Resend Email Form -->
    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-primary-auth w-100 mb-2">
            <i class="bi bi-envelope-check me-2"></i>Resend Verification Email
        </button>
    </form>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100">
            <i class="bi bi-box-arrow-right me-2"></i>Log Out
        </button>
    </form>

    <style>
        .btn-outline-secondary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 6px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .alert-info {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: none;
            border-radius: 6px;
        }
    </style>
</x-layouts::auth>
