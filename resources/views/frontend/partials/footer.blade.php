<footer id="footer" class="footer light-background">

  <div class="container footer-top">
    <div class="row gy-4">

      {{-- ABOUT --}}
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ route('landing') }}" class="logo d-flex align-items-center">
          <span class="sitename">UKS Sekolah</span>
        </a>

        <div class="footer-contact pt-3">
          <p>SMP / SMA Contoh</p>
          <p>Jl. Pendidikan No. 10</p>
          <p class="mt-3">
            <strong>Telepon:</strong>
            <span>08xxxxxxxxxx</span>
          </p>
          <p>
            <strong>Email:</strong>
            <span>uks@sekolah.sch.id</span>
          </p>
        </div>

        <div class="social-links d-flex mt-4">
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-facebook"></i></a>
        </div>
      </div>

      {{-- LINKS --}}
      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Menu</h4>
        <ul>
          <li><a href="{{ route('landing') }}">Home</a></li>
          <li><a href="#about">Profil UKS</a></li>
          <li><a href="#services">Layanan</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
      </div>

      {{-- LAYANAN --}}
      <div class="col-lg-3 col-md-3 footer-links">
        <h4>Layanan UKS</h4>
        <ul>
          <li>Pemeriksaan Kesehatan</li>
          <li>Pencatatan Rekam Medis</li>
          <li>Konsultasi Gizi</li>
          <li>Monitoring Kesehatan</li>
        </ul>
      </div>

      {{-- AKSES --}}
      <div class="col-lg-3 col-md-3 footer-links">
        <h4>Akses Sistem</h4>
        <ul>
          @guest
            <li><a href="{{ route('login') }}">Login</a></li>
          @endguest

          @auth
            <li>
              <a href="{{ auth()->user()->role === 'admin'
                ? route('admin.dashboard')
                : (auth()->user()->role === 'petugas'
                    ? route('petugas.dashboard')
                    : route('home')) }}">
                Dashboard
              </a>
            </li>
          @endauth
        </ul>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>
      © {{ date('Y') }}
      <strong class="px-1 sitename">UKS Sekolah</strong>
      <span>All Rights Reserved</span>
    </p>

    <div class="credits">
      Template by
      <a href="https://bootstrapmade.com/" target="_blank">BootstrapMade</a>
    </div>
  </div>

</footer>
