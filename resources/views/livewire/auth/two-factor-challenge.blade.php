<x-layouts::auth>
    <div class="auth-header">
        <h2>Two-Factor Authentication</h2>
        <p class="text-muted">Enter your authentication code</p>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Verification Failed!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login.store') }}" class="needs-validation">
        @csrf

        <div id="code-container">
            <div class="form-group">
                <label for="code" class="form-label">
                    <i class="bi bi-shield-check me-2" style="color: var(--primary-color);"></i>Authentication Code
                </label>
                <input 
                    id="code"
                    type="text" 
                    name="code" 
                    class="form-control @error('code') is-invalid @enderror"
                    placeholder="000000"
                    inputmode="numeric"
                    maxlength="6"
                    autocomplete="one-time-code"
                    required
                >
                <small class="text-muted d-block mt-2">
                    Enter the 6-digit code from your authenticator app.
                </small>
                @error('code')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div id="recovery-container" style="display: none;">
            <div class="form-group">
                <label for="recovery_code" class="form-label">
                    <i class="bi bi-key me-2" style="color: var(--primary-color);"></i>Recovery Code
                </label>
                <input 
                    id="recovery_code"
                    type="text" 
                    name="recovery_code" 
                    class="form-control @error('recovery_code') is-invalid @enderror"
                    placeholder="XXXX-XXXX-XXXX"
                    autocomplete="one-time-code"
                >
                <small class="text-muted d-block mt-2">
                    Enter one of your emergency recovery codes.
                </small>
                @error('recovery_code')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-auth mb-3">
            <i class="bi bi-check-circle me-2"></i>Verify
        </button>
    </form>

    <!-- Toggle Recovery Code -->
    <div class="auth-footer text-center">
        <button type="button" id="toggle-code" class="btn btn-link text-decoration-none" style="padding: 0; color: var(--primary-color); font-size: 0.85rem;">
            Can't access authenticator app? Use recovery code instead
        </button>
    </div>

    <script>
        const codeContainer = document.getElementById('code-container');
        const recoveryContainer = document.getElementById('recovery-container');
        const toggleBtn = document.getElementById('toggle-code');
        const codeInput = document.getElementById('code');
        const recoveryInput = document.getElementById('recovery_code');

        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (codeContainer.style.display === 'none') {
                codeContainer.style.display = 'block';
                recoveryContainer.style.display = 'none';
                codeInput.focus();
                toggleBtn.textContent = 'Can\'t access authenticator app? Use recovery code instead';
            } else {
                codeContainer.style.display = 'none';
                recoveryContainer.style.display = 'block';
                recoveryInput.focus();
                toggleBtn.textContent = 'Have your authentication code? Enter it instead';
            }
        });

        // Auto-focus on first input
        @if ($errors->has('recovery_code'))
            codeContainer.style.display = 'none';
            recoveryContainer.style.display = 'block';
            recoveryInput.focus();
            toggleBtn.textContent = 'Have your authentication code? Enter it instead';
        @else
            codeInput.focus();
        @endif
    </script>

    <style>
        .btn-link {
            border: none;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-link:hover {
            color: #0d9b96 !important;
            text-decoration: underline !important;
        }
    </style>
</x-layouts::auth>
