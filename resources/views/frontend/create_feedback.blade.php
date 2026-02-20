@extends('frontend.layout')

@section('main')
<main class="main">
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="heading-title">Share Your Feedback</h1>
                        <p class="mb-0">
                            Your feedback helps us improve our services and provide better care for our patients.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">Feedback</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Feedback Form Section -->
    <section class="feedback-section section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <strong>{{ session('success') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Error Messages -->
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    <strong>Please fix the following errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('feedback.store') }}" method="POST">
                                @csrf

                                <!-- Doctor Selection -->
                                <div class="mb-4">
                                    <label for="doctor_id" class="form-label fw-bold">
                                        <i class="bi bi-person-check me-2" style="color: var(--primary-color);"></i>Select Doctor
                                    </label>
                                    <select name="doctor_id" id="doctor_id" class="form-select form-select-lg @error('doctor_id') is-invalid @enderror" >
                                        <option value="">-- Choose a Doctor --</option>
                                        @forelse($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->user->name ?? 'Unknown' }} - {{ $doctor->specialization ?? 'N/A' }}
                                            </option>
                                        @empty
                                            <option value="" disabled>No doctors available</option>
                                        @endforelse
                                    </select>
                                    @error('doctor_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Rating Section -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-star-fill me-2" style="color: var(--primary-color);"></i>Overall Rating
                                    </label>
                                    <div class="rating-group d-flex gap-2" id="rating-container">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span 
                                                class="rating-label" 
                                                data-value="{{ $i }}" 
                                                title="{{ $i }} Star">
                                                <i class="bi bi-star-fill" style="font-size: 1.5rem; color: #ddd;"></i>
                                            </span>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                                    @error('rating')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Recommendation Section -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-hand-thumbs-up me-2" style="color: var(--primary-color);"></i>Would you recommend this doctor?
                                    </label>
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input @error('would_recommend') is-invalid @enderror" 
                                            type="radio" 
                                            name="would_recommend" 
                                            id="recommend_yes" 
                                            value="1"
                                            {{ old('would_recommend') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="recommend_yes">
                                            Yes, I would recommend
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input @error('would_recommend') is-invalid @enderror" 
                                            type="radio" 
                                            name="would_recommend" 
                                            id="recommend_no" 
                                            value="0"
                                            {{ old('would_recommend') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="recommend_no">
                                            No, I would not recommend
                                        </label>
                                    </div>
                                    @error('would_recommend')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Review/Comments Section -->
                                <div class="mb-4">
                                    <label for="review" class="form-label fw-bold">
                                        <i class="bi bi-chat-left-text me-2" style="color: var(--primary-color);"></i>Your Feedback/Comments
                                    </label>
                                    <textarea 
                                        name="review" 
                                        id="review" 
                                        class="form-control @error('review') is-invalid @enderror" 
                                        rows="6" 
                                        placeholder="Please share your experience with this doctor. Tell us what went well and what could be improved..."
                                        {{ old('review') }}></textarea>
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Minimum 10 characters required
                                    </small>
                                    @error('review')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid d-sm-flex justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-send me-2"></i>Submit Feedback
                                    </button>
                                    <a href="/" class="btn btn-outline-secondary btn-lg px-5">
                                        <i class="bi bi-arrow-left me-2"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="card mt-4 bg-light border-0">
                        <div class="card-body p-4">
                            <h6 class="mb-3">
                                <i class="bi bi-lightbulb me-2" style="color: var(--primary-color);"></i>Why Your Feedback Matters
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: var(--primary-color);"></i>Helps doctors improve their services</li>
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: var(--primary-color);"></i>Guides other patients in their choices</li>
                                <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: var(--primary-color);"></i>Contributes to overall healthcare quality</li>
                                <li><i class="bi bi-check-circle me-2" style="color: var(--primary-color);"></i>Your honest feedback is appreciated</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Feedback Form Section -->

</main>
@endsection

@push('style')
<style>
    .rating-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .rating-label {
        cursor: pointer;
        font-size: 2rem;
        color: #ddd;
        transition: all 0.2s ease-in-out;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(27, 182, 177, 0.25);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(27, 182, 177, 0.25);
    }
</style>
@endpush

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#rating-container .rating-label');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;

                stars.forEach(s => s.querySelector('i').style.color = '#ddd');
                for (let i = 0; i < value; i++) {
                    stars[i].querySelector('i').style.color = '#ffc107';
                }
            });
        });
    });
</script>
@endpush
