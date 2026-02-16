<x-layouts::auth>
    <div class="auth-header">
        <h2>Reset Your Password</h2>
        <p class="text-muted">Enter your new password below</p>
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
            <strong>Reset Failed!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="needs-validation">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                value="{{ request('email') }}"
                required 
                readonly
            >
            @error('email')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">
                <i class="bi bi-lock me-2" style="color: var(--primary-color);"></i>New Password
            </label>
            <input 
                id="password"
                type="password" 
                name="password" 
                class="form-control @error('password') is-invalid @enderror"
                placeholder="••••••••"
                required 
                autocomplete="new-password"
            >
            @error('password')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                <i class="bi bi-lock-check me-2" style="color: var(--primary-color);"></i>Confirm Password
            </label>
            <input 
                id="password_confirmation"
                type="password" 
                name="password_confirmation" 
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="••••••••"
                required 
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-auth mb-3">
            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Password
        </button>
    </form>

    <!-- Back to Login Link -->
    <div class="auth-footer">
        <p>Remembered your password? 
            <a href="{{ route('login') }}" class="auth-link">Back to login</a>
        </p>
    </div>
</x-layouts::auth>
