<x-layouts::auth>
    <div class="auth-header">
        <h2>Forgot Password?</h2>
        <p class="text-muted">Enter your email and we'll send you a password reset link</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="needs-validation">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">
                <i class="bi bi-envelope me-2" style="color: var(--primary-color);"></i>Email Address
            </label>
            <input 
                id="email"
                type="email" 
                name="email" 
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="your@email.com"
                required 
                autofocus
            >
            @error('email')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
            <small class="text-muted d-block mt-2">
                <i class="bi bi-info-circle me-1"></i>We'll send a password reset link to this email address.
            </small>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-auth mb-3">
            <i class="bi bi-envelope-exclamation me-2"></i>Send Reset Link
        </button>
    </form>

    <!-- Back to Login Link -->
    <div class="auth-footer">
        <p>Remember your password? 
            <a href="{{ route('login') }}" class="auth-link">Back to login</a>
        </p>
    </div>
</x-layouts::auth>
