@extends('frontend.layout')

@section('main')
  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1 class="heading-title">Doctors</h1>
              <p class="mb-0">
                Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo
                odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum
                debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat
                ipsum dolorem.
              </p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Doctors</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Doctors Section -->
    <section id="doctors" class="doctors section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Filterable Doctor Directory -->
        <div class="doctor-directory mb-5">
          <div class="directory-bar p-3 p-md-4 rounded-3">
            <div class="row g-3 align-items-center">
              <div class="col-lg-4">
                <label for="doctor-search" class="form-label mb-1">Search Doctors</label>
                <div class="position-relative">
                  <i class="bi bi-search search-icon"></i>
                  <input id="doctor-search" type="text" class="form-control search-input" placeholder="Type a name or keyword">
                </div>
              </div>
              <div class="col-lg-3">
                <label class="form-label mb-1">Department</label>
                <select class="form-select">
                  <option value="*">All Departments</option>
                  <option value=".filter-cardiology">Cardiology</option>
                  <option value=".filter-pediatrics">Pediatrics</option>
                  <option value=".filter-dermatology">Dermatology</option>
                  <option value=".filter-orthopedics">Orthopedics</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label class="form-label mb-1">Location</label>
                <select class="form-select">
                  <option>All Locations</option>
                  <option>Downtown Clinic</option>
                  <option>Westside Center</option>
                  <option>Riverside Campus</option>
                </select>
              </div>
              <div class="col-lg-2 d-grid">
                <button class="btn btn-appointment">Apply Filters</button>
              </div>
            </div>
          </div>

          <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
            <ul class="directory-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-cardiology">Cardiology</li>
              <li data-filter=".filter-pediatrics">Pediatrics</li>
              <li data-filter=".filter-dermatology">Dermatology</li>
              <li data-filter=".filter-orthopedics">Orthopedics</li>
            </ul><!-- End Directory Filters -->

            <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="300">


              @foreach ($doctors as $doctor)
                <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-{{ $doctor->department }}">
                  <article class="doctor-card h-100">
                    <figure class="doctor-media">
                      <img src="{{ asset('assets/img/health/staff-' . $doctor->id . '.webp') }}" class="img-fluid" alt="{{ $doctor->name }}" loading="lazy">
                      @if($doctor->designation)
                      <span class="tag">{{ $doctor->designation }}</span>
                      @endif
                    </figure>
                    <div class="doctor-content">
                      <h3 class="doctor-name">{{ $doctor->user->name }}</h3>
                      <p class="doctor-title">{{ $doctor->specialization }} • {{ $doctor->qualification }}</p>
                      <p class="doctor-desc">{{ Str::limit($doctor->bio ?? '-', 100) }}</p>
                      <div class="doctor-meta">
                        <span class="badge dept">{{ $doctor->department }}</span>
                      </div>
                      <div class="doctor-actions">
                        <a href="{{ route('doctors.appointments', $doctor->id) }}" class="btn btn-sm btn-appointment">Book Appointment</a>
                      </div>
                    </div>
                  </article>
                </div><!-- End Directory Item -->
              @endforeach


            </div><!-- End Directory Items Container -->
          </div>
        </div><!-- End Filterable Doctor Directory -->

        <!-- Minimal Card / Compact View -->
        <div class="compact-view mt-5">
          <div class="row g-3">
            @foreach ($doctors as $doctor)
                            <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="100">
              <div class="minimal-card text-center">
                <img src="{{ asset('assets/img/health/staff-' . $doctor->id . '.webp') }}" alt="{{ $doctor->user->name }}" class="avatar img-fluid" loading="lazy">
                <div class="info">
                  <h4 class="mb-0">{{ $doctor->user->name }}</h4>
                  <small> {{ $doctor->department }} </small>
                </div>
              </div>
            </div>
            @endforeach
        <!-- End Minimal Item -->
          </div>
        </div><!-- End Minimal / Compact -->

      </div>

    </section><!-- /Doctors Section -->

  </main>
@endsection