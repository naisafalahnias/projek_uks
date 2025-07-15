<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="#" class="app-brand-link d-flex align-items-center">
              <img src="{{ asset('assets/backend/img/logo.png') }}" alt="Logo" width="50" height="50" class="me-2" />
              <span class="app-brand-text demo menu-text fw-bolder">SiSehat</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="{{ route('home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Layouts -->
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Menu</span>
            </li>
            <!-- Cards -->
            <li class="menu-item">
              <a href="{{ route('backend.kelas.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Basic">Data Kelas</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('backend.siswa.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Data Siswa</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('backend.obat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-capsule"></i>
                <div data-i18n="Basic">Data Obat</div>
              </a>
            </li>
            @if (auth()->user()->role === 'admin')
              <li class="menu-item">
                <a href="{{ route('backend.user.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-id-card"></i>
                  <div data-i18n="Basic">Data User</div>
                </a>
              </li>
            @endif
            <li class="menu-item">
              <a href="{{ route('jadwal_pemeriksaan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Basic">Jadwal Pemeriksaan</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('backend.rekam_medis.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-notepad"></i>
                <div data-i18n="Basic">Rekam Medis</div>
              </a>
            </li>
            
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">LAPORAN</span>
            </li>

            <li class="menu-item">
              <a href="{{ route('backend.rekam_medis.laporan') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Basic">Laporan Kunjungan</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="{{ route('jadwal_pemeriksaan.laporan') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file-find"></i>
                <div data-i18n="Basic">Laporan Jadwal</div>
              </a>
            </li>

            @if (auth()->user()->role === 'admin')
              <li class="menu-item">
                <a href="{{ route('backend.log.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-history"></i>
                  <div data-i18n="Basic">Log Aktivitas</div>
                </a>
              </li>
            @endif
          </ul>
        </aside>