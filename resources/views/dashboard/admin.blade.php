<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard | Sistem Kesehatan</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/backend/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/fonts/boxicons.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/apex-charts/apex-charts.css') }}" />

    <script src="{{ asset('assets/backend/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/backend/js/config.js') }}"></script>
  </head>

  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        @include('layouts.component-backend.sidebar')

        <div class="layout-page">
          
          @include('layouts.component-backend.navbar')

          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              
              <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name }}! 🎉</h5>
                          <p class="mb-4">
                            {{ auth()->user()->role === 'admin' ? 'Sistem berjalan optimal. Anda memiliki kendali penuh atas data medis dan inventaris obat hari ini.' : 'Siap melayani siswa hari ini? Tetap teliti dalam pencatatan rekam medis ya!' }}
                          </p>
                          <a href="javascript:;" class="btn btn-sm btn-outline-primary">Lihat Laporan Terbaru</a>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img src="{{ asset('assets/backend/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="View Badge User" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-4 col-6 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-primary p-2"><i class="bx bx-plus-medical text-primary"></i></span>
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Total Rekam Medis</span>
                      <h3 class="card-title mb-2">{{ $jumlahRekamMedis }}</h3>
                      <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Data Tersimpan</small>
                    </div>
                  </div>
                </div>

                @if(auth()->user()->role === 'admin')
                <div class="col-lg-4 col-md-4 col-6 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-info p-2"><i class="bx bx-user-voice text-info"></i></span>
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Total Petugas</span>
                      <h3 class="card-title mb-2">{{ $jumlahUser }}</h3>
                      <small class="text-muted">Aktif dalam sistem</small>
                    </div>
                  </div>
                </div>
                @endif

                <div class="col-lg-4 col-md-4 col-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <span class="badge bg-label-warning p-2"><i class="bx bx-package text-warning"></i></span>
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Jenis Obat</span>
                      <h3 class="card-title mb-2">{{ $stokObatChart->count() }}</h3>
                      <small class="text-muted">Dalam Inventaris</small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-lg-8 mb-4">
                  <div class="card">
                    <div class="row row-bordered g-0">
                      <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">Statistik Kunjungan Siswa (Bulanan)</h5>
                        <div class="card-body">
                           <canvas id="canvasKunjungan" style="max-height: 300px;"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Peringatan Stok</h5>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">
                        @foreach($stokObatChart->where('stok', '<', 15)->take(5) as $obat)
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-{{ $obat->stok < 10 ? 'danger' : 'warning' }}">
                              <i class="bx bx-capsule"></i>
                            </span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ $obat->nama_obat }}</h6>
                              <small class="text-muted">Segera Restock</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold text-{{ $obat->stok < 10 ? 'danger' : 'warning' }}">{{ $obat->stok }}</small>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-4">
                   <div class="card">
                      <div class="card-header">
                         <h5 class="card-title">Perbandingan Stok Seluruh Obat</h5>
                      </div>
                      <div class="card-body">
                         <canvas id="canvasStok" style="max-height: 350px;"></canvas>
                      </div>
                   </div>
                </div>
              </div>

            </div>
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="{{ asset('assets/backend/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/backend/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
      // Chart Kunjungan (Line/Bar)
      const ctxKunjungan = document.getElementById('canvasKunjungan').getContext('2d');
      new Chart(ctxKunjungan, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
          datasets: [{
            label: 'Siswa Datang',
            data: @json($dataKunjungan),
            borderColor: '#696CFF',
            backgroundColor: 'rgba(105, 108, 255, 0.1)',
            fill: true,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        }
      });

      // Chart Stok Obat (Horizontal Bar)
      const ctxStok = document.getElementById('canvasStok').getContext('2d');
      new Chart(ctxStok, {
        type: 'bar',
        data: {
          labels: @json($stokObatChart->pluck('nama_obat')),
          datasets: [{
            label: 'Jumlah Unit',
            data: @json($stokObatChart->pluck('stok')),
            backgroundColor: '#03C3EC',
            borderRadius: 5
          }]
        },
        options: {
          indexAxis: 'y', // Membuat bar horizontal supaya nama obat panjang tidak terpotong
          responsive: true,
          maintainAspectRatio: false,
        }
      });
    </script>

  </body>
</html>