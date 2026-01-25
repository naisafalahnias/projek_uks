<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ ('assets/backend/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ ('assets/backend/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ ('assets/backend/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ ('assets/backend/css/demo.css') }}" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ ('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ ('assets/backend/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Helpers -->
    <script src="{{ ('assets/backend/vendor/js/helpers.js') }}"></script>
    <script src="{{ ('assets/backend/js/config.js') }}"></script>
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
                <!-- Welcome Card -->
                <div class="row mt-3">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name }}! 🎉</h5>
                          <p class="mb-4">
                            {{ auth()->user()->role === 'admin' ? 'Kamu sudah berhasil mengatur sistem dan akun dengan baik. Terima kasih Admin!' : 'Kamu berhasil masuk dan siap melayani siswa hari ini. Semangat, Petugas!' }}
                          </p>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img src="{{ ('assets/backend/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="View Badge User" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- Siswa & Obat -->
                <div class="col-lg-4 col-md-4 order-1 ">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="avatar flex-shrink-0 bg-primary text-white rounded p-2">
                            <i class="bx bx-user bx-sm"></i>
                          </div>
                          <span class="fw-semibold d-block mb-1">Siswa</span>
                          <h3 class="card-title mb-2">{{ $jumlahSiswa }}</h3>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="avatar flex-shrink-0 bg-primary text-white rounded p-2">
                            <i class="bx bx-test-tube bx-sm"></i>
                          </div>
                          <span class="fw-semibold d-block mb-1">Obat</span>
                          <h3 class="card-title mb-2">{{ $jumlahObat }}</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <!-- Chart + Info Cards -->
                <div class="row mt-3">
                  <div class="col-lg-8 mb-4">
                    <div class="card h-100 p-4">
                      <h5 class="card-header m-0 pb-3">Total Kunjungan</h5>
                      <canvas id="totalRevenueChart" class="px-2" width="100"></canvas>
                    </div>
                  </div>
                  
                  <div class="col-lg-4">
                    <div class="row">
                      <div class="col-sm-6 col-lg-12 mb-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="avatar flex-shrink-0 bg-primary text-white rounded p-2 mb-2">
                              <i class="bx bx-plus-medical bx-sm"></i>
                            </div>
                            <span class="fw-semibold d-block mb-1">Rekam Medis</span>
                            <h3 class="card-title mb-2">{{ $jumlahRekamMedis }}</h3>
                          </div>
                        </div>
                      </div>
                      @if(auth()->user()->role === 'admin')
                      <div class="col-sm-6 col-lg-12 mb-4">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="avatar flex-shrink-0 bg-primary text-white rounded p-2 mb-2">
                              <i class="bx bx-id-card bx-sm"></i>
                            </div>
                            <span class="fw-semibold d-block mb-1">Petugas</span>
                            <h3 class="card-title mb-2">{{ $jumlahUser }}</h3>
                          </div>
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
                  <!-- Tambahkan di bawah chart Total Kunjungan -->
                  <div class="col-lg-8 mb-4">
                    <div class="card h-100 p-4 mt-4">
                      <h5 class="card-header m-0 pb-3">Stok Obat</h5>
                      <canvas id="stokObatChart" class="px-2" width="100"></canvas>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
    <script src="{{ ('assets/backend/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ ('assets/backend/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ ('assets/backend/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ ('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ ('assets/backend/vendor/js/menu.js') }}"></script>
    <script src="{{ ('assets/backend/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ ('assets/backend/js/main.js') }}"></script>
    <script src="{{ ('assets/backend/js/dashboards-analytics.js') }}"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
      // Chart Total Kunjungan
      const ctxKunjungan = document.getElementById('totalRevenueChart').getContext('2d');
      new Chart(ctxKunjungan, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
          datasets: [{
            label: 'Jumlah Kunjungan',
            data: @json($dataKunjungan),
            backgroundColor: '#696CFF'
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false }
          },
          scales: {
            y: { beginAtZero: true }
          }
        }
      });

      // Chart Stok Obat
      const ctxStok = document.getElementById('stokObatChart').getContext('2d');
      new Chart(ctxStok, {
        type: 'bar',
        data: {
          labels: @json($stokObatChart->pluck('nama_obat')),
          datasets: [{
            label: 'Stok Obat',
            data: @json($stokObatChart->pluck('stok')),
            backgroundColor: '#FF6384'
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false }
          },
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    </script>

  </body>
</html>
