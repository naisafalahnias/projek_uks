<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="#" class="app-brand-link d-flex align-items-center">
      <img src="{{ asset('assets/backend/img/avatars/logo.png') }}" alt="Logo" width="200" class="me-2" />
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
      <a href="{{ route('home')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Data Utama</span></li>
    
    <li class="menu-item {{ request()->is('backend/kelas*', 'backend/siswa*', 'backend/obat*', 'backend/user*', 'backend/akun_siswa*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div data-i18n="Master Data">Master Data</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('backend.kelas.index') ? 'active' : '' }}">
          <a href="{{ route('backend.kelas.index') }}" class="menu-link"><div>Data Kelas</div></a>
        </li>
        <li class="menu-item {{ request()->routeIs('backend.siswa.index') ? 'active' : '' }}">
          <a href="{{ route('backend.siswa.index') }}" class="menu-link"><div>Data Siswa</div></a>
        </li>
        <li class="menu-item {{ request()->routeIs('backend.obat.index') ? 'active' : '' }}">
          <a href="{{ route('backend.obat.index') }}" class="menu-link"><div>Data Obat</div></a>
        </li>
        @if (auth()->user()->role === 'admin')
          <li class="menu-item {{ request()->routeIs('backend.user.index') ? 'active' : '' }}">
            <a href="{{ route('backend.user.index') }}" class="menu-link"><div>Akun Petugas</div></a>
          </li>
        @endif
        @if(in_array(auth()->user()->role, ['admin', 'petugas']))
          <li class="menu-item {{ request()->routeIs('backend.akun_siswa.*') ? 'active' : '' }}">
            <a href="{{ route('backend.akun_siswa.index') }}" class="menu-link"><div>Akun Siswa</div></a>
          </li>
        @endif
      </ul>
    </li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Kesehatan</span></li>

    <li class="menu-item {{ request()->is('backend/jadwal*', 'backend/rekam_medis*', 'backend/kondisi_kesehatan*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-plus-medical"></i>
        <div data-i18n="Layanan">Layanan Medis</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('backend.jadwal_pemeriksaan.*') ? 'active' : '' }}">
          <a href="{{ route('backend.jadwal_pemeriksaan.index') }}" class="menu-link"><div>Jadwal Pemeriksaan</div></a>
        </li>
        <li class="menu-item {{ request()->routeIs('backend.rekam_medis.index') ? 'active' : '' }}">
          <a href="{{ route('backend.rekam_medis.index') }}" class="menu-link"><div>Rekam Medis</div></a>
        </li>
        <li class="menu-item {{ request()->routeIs('backend.kondisi_kesehatan.index') ? 'active' : '' }}">
          <a href="{{ route('backend.kondisi_kesehatan.index') }}" class="menu-link"><div>Kondisi Kesehatan</div></a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->is('backend/makanan*', 'backend/konsumsi*', 'backend/kebutuhan_kalori*', 'backend/pemeriksaan_gizi*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-restaurant"></i>
        <div data-i18n="Gizi">Manajemen Gizi</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('backend.pemeriksaan_gizi.index') ? 'active' : '' }}">
          <a href="{{ route('backend.pemeriksaan_gizi.index') }}" class="menu-link"><div>Pemeriksaan Gizi</div></a>
        </li>
        <li class="menu-item {{ request()->routeIs('backend.makanans.index') ? 'active' : '' }}">
          <a href="{{ route('backend.makanans.index') }}" class="menu-link"><div>Daftar Makanan</div></a>
        </li>
        <li class="menu-item {{ request()->routeIs('backend.konsumsi_makanan.index') ? 'active' : '' }}">
          <a href="{{ route('backend.konsumsi_makanan.index') }}" class="menu-link"><div>Konsumsi Harian</div></a>
        </li>
        <li class="menu-item {{ request()->routeIs('backend.kebutuhan_kalori.index') ? 'active' : '' }}">
          <a href="{{ route('backend.kebutuhan_kalori.index') }}" class="menu-link"><div>Kebutuhan Kalori</div></a>
        </li>
      </ul>
    </li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan & Log</span></li>

    <li class="menu-item {{ request()->routeIs('backend.rekam_medis.laporan') ? 'active' : '' }}">
      <a href="{{ route('backend.rekam_medis.laporan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Basic">Laporan Kunjungan</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs('backend.jadwal_pemeriksaan.laporan') ? 'active' : '' }}">
      <a href="{{ route('backend.jadwal_pemeriksaan.laporan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file-find"></i>
        <div data-i18n="Basic">Laporan Jadwal</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs('backend.pemeriksaan_gizi.laporan') ? 'active' : '' }}">
      <a href="{{ route('backend.pemeriksaan_gizi.laporan') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-food-menu"></i>
          <div>Laporan Gizi</div>
      </a>
    </li>

    @if (auth()->user()->role === 'admin')
      <li class="menu-item {{ request()->routeIs('backend.log.index') ? 'active' : '' }}">
        <a href="{{ route('backend.log.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-history"></i>
          <div data-i18n="Basic">Log Aktivitas</div>
        </a>
      </li>
    @endif
  </ul>
</aside>