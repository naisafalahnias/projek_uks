<header id="header" class="header sticky-top">

  <div class="branding d-flex align-items-center">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('assets/frontend/img/logo-1.png') }}" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>

          {{-- MENU UMUM --}}
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#contact">Contact</a></li>

          {{-- MENU KHUSUS SISWA (HANYA MUNCUL JIKA LOGIN SISWA) --}}
          @auth
            @if(auth()->user()->role === 'siswa')
              <li class="dropdown">
                <a href="#">
                  <span>Data Kesehatan Saya</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
                  <li>
                    <a href="{{ route('siswa.dashboard') }}">
                      <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('siswa.rekam_medis') }}">
                      <i class="bi bi-file-medical me-1"></i> Rekam Medis
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('siswa.dashboard') }}#gizi">
                      <i class="bi bi-activity me-1"></i> Pemeriksaan Gizi
                    </a>
                  </li>
                </ul>
              </li>
            @endif
          @endauth

        </ul>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      {{-- BELUM LOGIN --}}
      @guest
        <a class="cta-btn d-none d-sm-block" href="{{ route('siswa.login') }}">
          Login Siswa
        </a>
      @endguest

      {{-- SUDAH LOGIN SISWA --}}
      @auth
        @if(auth()->user()->role === 'siswa')
          <form action="{{ route('siswa.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="cta-btn d-none d-sm-block">
              Logout
            </button>
          </form>
        @endif
      @endauth

    </div>
  </div>

</header>
