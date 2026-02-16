<x-layouts::auth>
    <div class="auth-header">
        <h2>Create Your Account</h2>
        <p class="text-muted">Join our clinic management system today</p>
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
            <strong>Registration Failed!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="needs-validation">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">
                <i class="bi bi-person me-2" style="color: var(--primary-color);"></i>Full Name
            </label>
            <input 
                id="name"
                type="text" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="John Doe"
                required 
                autofocus
                autocomplete="name"
            >
            @error('name')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

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

        <!-- Terms Agreement -->
        <div class="form-check mb-3">
            <input 
                class="form-check-input" 
                type="checkbox" 
                id="terms" 
                name="terms"
                required
            >
            <label class="form-check-label" for="terms">
                I agree to the <a href="#" class="auth-link">Terms & Conditions</a>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-auth mb-3">
            <i class="bi bi-person-plus me-2"></i>Create Account
        </button>
    </form>

    <!-- Sign In Link -->
    <div class="auth-footer">
        <p>Already have an account? 
            <a href="{{ route('login') }}" class="auth-link">Sign in here</a>
        </p>
    </div>
</x-layouts::auth>
