<x-layouts::auth>
    <div class="auth-header">
        <h2>Login to Your Account</h2>
        <p class="text-muted">Sign in to access your clinic dashboard</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Login Failed!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="needs-validation">
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
                autocomplete="email"
            >
            @error('email')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">
                <i class="bi bi-lock me-2" style="color: var(--primary-color);"></i>Password
            </label>
            <div class="password-field">
                <input 
                    id="password"
                    type="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    required 
                    autocomplete="current-password"
                >
                @error('password')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-3">
            <input 
                class="form-check-input" 
                type="checkbox" 
                id="remember" 
                name="remember"
                {{ old('remember') ? 'checked' : '' }}
            >
            <label class="form-check-label" for="remember">
                Remember me for 30 days
            </label>
        </div>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="mb-3 text-end">
                <a href="{{ route('password.request') }}" class="auth-link" style="font-size: 0.85rem;">
                    Forgot your password?
                </a>
            </div>
        @endif

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-auth mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <!-- Sign Up Link -->
    @if (Route::has('register'))
        <div class="auth-footer">
            <p>Don't have an account? 
                <a href="{{ route('register') }}" class="auth-link">Create one now</a>
            </p>
        </div>
    @endif
</x-layouts::auth>
