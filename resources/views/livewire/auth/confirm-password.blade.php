<x-layouts::auth>
    <div class="auth-header">
        <h2>Confirm Your Password</h2>
        <p class="text-muted">This is a secure area. Please confirm your password to continue.</p>
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
            <strong>Error!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.confirm.store') }}" class="needs-validation">
        @csrf

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
                autocomplete="current-password"
            >
            @error('password')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-auth mb-3">
            <i class="bi bi-check-circle me-2"></i>Confirm Password
        </button>
    </form>

    <!-- Back to Dashboard -->
    <div class="auth-footer">
        <p><a href="{{ route('dashboard') }}" class="auth-link">Back to dashboard</a></p>
    </div>
</x-layouts::auth>
