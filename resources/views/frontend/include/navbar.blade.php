  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        {{-- <img src="{{ asset('assets/img/logo.webp') }}" alt="">  --}}
        <h1 class="sitename">Medi<span>Nest</span></h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html" class="active">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="departments.html">Departments</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="doctors.html">Doctors</a></li>

          <li><a href="contact.html">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route('appointment') }}">Appointment</a>

    </div>
  </header>