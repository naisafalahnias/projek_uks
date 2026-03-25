<footer id="footer" class="footer light-background">

  <div class="container footer-top">
    <div class="row gy-4">

      {{-- ABOUT --}}
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ route('landing') }}" class="logo d-flex align-items-center">
          <span class="sitename">MediSchool</span>
        </a>

        <div class="footer-contact pt-3">
          <p>SMK ASSALAAM BANDUNG</p>
          <p>Jl. Situ Tarate, Cibaduyut, Dayeuhkolot, Kota Bandung, Jawa Barat 40265</p>
          <p class="mt-3">
            <strong>Telepon:</strong>
            <span>(022) 5420220</span>
          </p>
          <p>
            <strong>Email:</strong>
            <span>uks@sekolah.sch.id</span>
          </p>
        </div>

        <div class="social-links d-flex mt-4">
          <a href="https://www.instagram.com/smkassalaam/?__pwa=1"><i class="bi bi-instagram"></i></a>
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

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>
      © {{ date('Y') }}
      <strong class="px-1 sitename">UKS Sekolah</strong>
      <span>All Rights Reserved</span>
    </p>

    <div class="credits">
      by
      <a href="https://www.instagram.com/naisanaic/?__pwa=1" target="_blank">Naisafalah</a>
    </div>
  </div>

</footer>
