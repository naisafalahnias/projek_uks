@extends('layouts.frontend')

@section('content')

<!-- Hero Section -->
<section id="hero" class="hero section light-background">

  <img src="{{ asset('assets/frontend/img/hero-bg.jpg') }}" alt="UKS Medischool" data-aos="fade-in">

  <div class="container position-relative">

    <!-- Welcome Text -->
    <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
      <h2>SELAMAT DATANG DI <span>MEDISCHOOL</span></h2>
      <p>
        Sistem Informasi UKS Sekolah untuk pemantauan kesehatan, gizi,
        dan layanan medis siswa secara terintegrasi.
      </p>
    </div>
    <!-- End Welcome -->

    <div class="content row gy-4">

      <!-- Why Box -->
      <div class="col-lg-4 d-flex align-items-stretch">
        <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
          <h3>Kenapa Medischool?</h3>
          <p>
            Medischool membantu petugas UKS dan sekolah dalam mengelola
            data kesehatan siswa, mulai dari pemeriksaan, rekam medis,
            konsumsi makanan, hingga kebutuhan kalori siswa.
          </p>
          <div class="text-center">
            <a href="#about" class="more-btn">
              <span>Pelajari Lebih Lanjut</span>
              <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- End Why Box -->

      <!-- Feature Boxes -->
      <div class="col-lg-8 d-flex align-items-stretch">
        <div class="d-flex flex-column justify-content-center">
          <div class="row gy-4">

            <div class="col-xl-4 d-flex align-items-stretch">
              <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                <i class="bi bi-clipboard-check"></i>
                <h4>Pemeriksaan Kesehatan</h4>
                <p>
                  Pencatatan pemeriksaan kesehatan siswa secara rutin dan terstruktur.
                </p>
              </div>
            </div>
            <!-- End Icon Box -->

            <div class="col-xl-4 d-flex align-items-stretch">
              <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                <i class="bi bi-heart-pulse"></i>
                <h4>Rekam Medis Siswa</h4>
                <p>
                  Riwayat kesehatan siswa tersimpan rapi dan mudah diakses oleh petugas UKS.
                </p>
              </div>
            </div>
            <!-- End Icon Box -->

            <div class="col-xl-4 d-flex align-items-stretch">
              <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                <i class="bi bi-egg-fried"></i>
                <h4>Gizi & Konsumsi</h4>
                <p>
                  Pemantauan konsumsi makanan dan kebutuhan kalori siswa.
                </p>
              </div>
            </div>
            <!-- End Icon Box -->

          </div>
        </div>
      </div>
      <!-- End Feature Boxes -->

    </div>
    <!-- End Content -->

  </div>

</section>
<!-- /Hero Section -->

<!-- About Section -->
<section id="about" class="about section">

  <div class="container">

    <div class="row gy-4 gx-5">

      <!-- Image -->
      <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
        <img src="{{ asset('assets/frontend/img/about.jpg') }}" class="img-fluid" alt="UKS Medischool">
        <!-- optional video, boleh dihapus -->
        <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
           class="glightbox pulsating-play-btn"></a>
      </div>

      <!-- Content -->
      <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
        <h3>Tentang Medischool</h3>
        <p>
          Medischool adalah sistem informasi UKS berbasis web yang dirancang
          untuk membantu sekolah dalam mengelola data kesehatan siswa secara
          efektif, terstruktur, dan aman.
        </p>

        <ul>
          <li>
            <i class="fa-solid fa-notes-medical"></i>
            <div>
              <h5>Manajemen Data Kesehatan</h5>
              <p>
                Pencatatan pemeriksaan kesehatan dan kondisi medis siswa
                dilakukan secara digital dan terdokumentasi dengan baik.
              </p>
            </div>
          </li>

          <li>
            <i class="fa-solid fa-user-nurse"></i>
            <div>
              <h5>Mendukung Petugas UKS</h5>
              <p>
                Membantu petugas UKS dalam memantau, mencatat, dan mengelola
                layanan kesehatan siswa secara efisien.
              </p>
            </div>
          </li>

          <li>
            <i class="fa-solid fa-apple-whole"></i>
            <div>
              <h5>Pemantauan Gizi & Konsumsi</h5>
              <p>
                Mendukung pemantauan konsumsi makanan dan kebutuhan kalori siswa
                untuk menunjang kesehatan dan tumbuh kembang.
              </p>
            </div>
          </li>
        </ul>
      </div>

    </div>

  </div>

</section>
<!-- /About Section -->

<!-- Stats Section -->
<section id="stats" class="stats section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

      <!-- Total Siswa -->
      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fa-solid fa-users"></i>
        <div class="stats-item">
          <span
            data-purecounter-start="0"
            data-purecounter-end="420"
            data-purecounter-duration="1"
            class="purecounter">
          </span>
          <p>Total Siswa</p>
        </div>
      </div><!-- End Stats Item -->

      <!-- Pemeriksaan Kesehatan -->
      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fa-solid fa-notes-medical"></i>
        <div class="stats-item">
          <span
            data-purecounter-start="0"
            data-purecounter-end="125"
            data-purecounter-duration="1"
            class="purecounter">
          </span>
          <p>Pemeriksaan Kesehatan</p>
        </div>
      </div><!-- End Stats Item -->

      <!-- Obat Tersedia -->
      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fa-solid fa-pills"></i>
        <div class="stats-item">
          <span
            data-purecounter-start="0"
            data-purecounter-end="35"
            data-purecounter-duration="1"
            class="purecounter">
          </span>
          <p>Jenis Obat</p>
        </div>
      </div><!-- End Stats Item -->

      <!-- Petugas UKS -->
      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fa-solid fa-user-nurse"></i>
        <div class="stats-item">
          <span
            data-purecounter-start="0"
            data-purecounter-end="4"
            data-purecounter-duration="1"
            class="purecounter">
          </span>
          <p>Petugas UKS</p>
        </div>
      </div><!-- End Stats Item -->

    </div>

  </div>

</section>
<!-- /Stats Section -->

<!-- Services Section -->
<section id="services" class="services section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Layanan UKS</h2>
    <p>Layanan kesehatan sekolah untuk mendukung siswa tetap sehat, aktif, dan produktif</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

      <!-- Pemeriksaan Kesehatan -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-stethoscope"></i>
          </div>
          <h3>Pemeriksaan Kesehatan</h3>
          <p>
            Pencatatan pemeriksaan kesehatan siswa seperti keluhan, tekanan darah, suhu tubuh,
            serta kondisi umum siswa.
          </p>
        </div>
      </div><!-- End Service Item -->

      <!-- Rekam Medis -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-notes-medical"></i>
          </div>
          <h3>Rekam Medis Siswa</h3>
          <p>
            Penyimpanan riwayat kesehatan siswa secara digital agar mudah dipantau oleh petugas UKS.
          </p>
        </div>
      </div><!-- End Service Item -->

      <!-- Manajemen Obat -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-pills"></i>
          </div>
          <h3>Manajemen Obat</h3>
          <p>
            Pengelolaan stok obat UKS, termasuk jenis obat, jumlah tersedia, dan pemakaian obat.
          </p>
        </div>
      </div><!-- End Service Item -->

      <!-- Pemeriksaan Gizi -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-apple-alt"></i>
          </div>
          <h3>Pemeriksaan Gizi</h3>
          <p>
            Pemantauan status gizi siswa berdasarkan tinggi badan, berat badan, dan indeks massa tubuh.
          </p>
        </div>
      </div><!-- End Service Item -->

      <!-- Konsumsi Makanan -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-utensils"></i>
          </div>
          <h3>Konsumsi Makanan</h3>
          <p>
            Pencatatan konsumsi makanan siswa untuk mendukung pola makan sehat di lingkungan sekolah.
          </p>
        </div>
      </div><!-- End Service Item -->

      <!-- Laporan & Monitoring -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <h3>Laporan & Monitoring</h3>
          <p>
            Laporan data kesehatan siswa yang dapat digunakan untuk evaluasi dan pengambilan keputusan.
          </p>
        </div>
      </div><!-- End Service Item -->

    </div>

  </div>

</section>
<!-- /Services Section -->

<!-- Appointment / CTA Section -->
<section id="appointment" class="appointment section light-background">

  <div class="container" data-aos="fade-up">

    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">

        <h2>Akses Layanan UKS Medischool</h2>
        <p class="mb-4">
          Sistem UKS Medischool membantu petugas UKS dalam mengelola data kesehatan,
          pemeriksaan, dan rekam medis siswa secara terpusat dan efisien.
        </p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">

          <!-- Login Siswa -->
          <a href="{{ route('siswa.login') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-person-check me-2"></i>
            Login Siswa
          </a>

          <!-- Info UKS -->
          <a href="#services" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-info-circle me-2"></i>
            Lihat Layanan UKS
          </a>

        </div>

      </div>
    </div>

  </div>

</section>
<!-- /Appointment / CTA Section -->

<!-- UKS Services Section -->
<section id="departments" class="departments section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Layanan UKS</h2>
    <p>Layanan kesehatan sekolah yang dikelola oleh petugas UKS Medischool</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row">
      <div class="col-lg-3">
        <ul class="nav nav-tabs flex-column">
          <li class="nav-item">
            <a class="nav-link active show" data-bs-toggle="tab" href="#uks-1">
              Pemeriksaan Kesehatan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#uks-2">
              Rekam Medis Siswa
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#uks-3">
              Konsumsi & Gizi
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#uks-4">
              Obat & Pertolongan Pertama
            </a>
          </li>
        </ul>
      </div>

      <div class="col-lg-9 mt-4 mt-lg-0">
        <div class="tab-content">

          <div class="tab-pane active show" id="uks-1">
            <h3>Pemeriksaan Kesehatan</h3>
            <p>
              Pencatatan hasil pemeriksaan rutin siswa seperti tinggi badan,
              berat badan, tekanan darah, dan kondisi kesehatan lainnya.
            </p>
          </div>

          <div class="tab-pane" id="uks-2">
            <h3>Rekam Medis Siswa</h3>
            <p>
              Penyimpanan riwayat kesehatan siswa secara digital untuk
              memudahkan pemantauan dan tindak lanjut medis.
            </p>
          </div>

          <div class="tab-pane" id="uks-3">
            <h3>Konsumsi & Gizi</h3>
            <p>
              Monitoring konsumsi makanan dan status gizi siswa guna
              mendukung pertumbuhan dan kesehatan optimal.
            </p>
          </div>

          <div class="tab-pane" id="uks-4">
            <h3>Obat & Pertolongan Pertama</h3>
            <p>
              Pengelolaan stok obat UKS serta pencatatan penggunaan obat
              dan tindakan pertolongan pertama.
            </p>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>
<!-- /UKS Services Section -->

<!-- UKS Staff Section -->
<section id="doctors" class="doctors section light-background">

  <div class="container section-title" data-aos="fade-up">
    <h2>Petugas UKS</h2>
    <p>Petugas yang bertanggung jawab dalam pengelolaan layanan UKS Medischool</p>
  </div>

  <div class="container">

    <div class="row gy-4 justify-content-center">

      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <div class="team-member d-flex align-items-start">
          <div class="pic">
            <img src="assets/frontend/img/team-1.jpg" class="img-fluid" alt="">
          </div>
          <div class="member-info">
            <h4>Petugas UKS</h4>
            <span>Pengelola UKS</span>
            <p>
              Bertugas melakukan pencatatan pemeriksaan, pengelolaan obat,
              serta pendampingan kesehatan siswa.
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <div class="team-member d-flex align-items-start">
          <div class="pic">
            <img src="assets/frontend/img/team-2.jpg" class="img-fluid" alt="">
          </div>
          <div class="member-info">
            <h4>Admin Sistem</h4>
            <span>Administrator</span>
            <p>
              Mengelola data pengguna, laporan UKS,
              serta memastikan sistem berjalan dengan baik.
            </p>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
<!-- /UKS Staff Section -->

<!-- FAQ Section -->
<section id="faq" class="faq section light-background">

  <div class="container section-title" data-aos="fade-up">
    <h2>FAQ UKS Medischool</h2>
    <p>Pertanyaan yang sering diajukan terkait layanan UKS dan sistem Medischool</p>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

        <div class="faq-container">

          <div class="faq-item faq-active">
            <h3>Siapa saja yang bisa menggunakan layanan UKS?</h3>
            <div class="faq-content">
              <p>
                Seluruh siswa Medischool dapat menggunakan layanan UKS
                untuk pemeriksaan kesehatan dan penanganan pertama.
              </p>
            </div>
            <i class="faq-toggle bi bi-chevron-right"></i>
          </div>

          <div class="faq-item">
            <h3>Apakah data kesehatan siswa disimpan dengan aman?</h3>
            <div class="faq-content">
              <p>
                Ya. Data rekam medis siswa disimpan secara digital
                dan hanya dapat diakses oleh petugas UKS dan admin.
              </p>
            </div>
            <i class="faq-toggle bi bi-chevron-right"></i>
          </div>

          <div class="faq-item">
            <h3>Apa saja layanan yang tersedia di UKS?</h3>
            <div class="faq-content">
              <p>
                Pemeriksaan kesehatan, pencatatan rekam medis,
                pengelolaan obat, serta pemantauan gizi siswa.
              </p>
            </div>
            <i class="faq-toggle bi bi-chevron-right"></i>
          </div>

          <div class="faq-item">
            <h3>Siapa yang mengelola sistem UKS Medischool?</h3>
            <div class="faq-content">
              <p>
                Sistem dikelola oleh petugas UKS dan administrator sekolah.
              </p>
            </div>
            <i class="faq-toggle bi bi-chevron-right"></i>
          </div>

        </div>

      </div>
    </div>
  </div>

</section>
<!-- /FAQ Section -->

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Testimoni</h2>
    <p>Pengalaman siswa dalam menggunakan layanan UKS Medischool</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="200">

    <div class="swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": { "delay": 5000 },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          }
        }
      </script>

      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="testimonial-item">
            <h3>Siswa Kelas X</h3>
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>
                Dengan adanya sistem UKS Medischool, pelayanan kesehatan
                di sekolah jadi lebih cepat dan tertata.
              </span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="testimonial-item">
            <h3>Siswa Kelas XI</h3>
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>
                Riwayat kesehatan jadi jelas dan mudah dicek oleh petugas UKS.
              </span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
          </div>
        </div>

      </div>

      <div class="swiper-pagination"></div>
    </div>

  </div>

</section>
<!-- /Testimonials Section -->

<!-- Gallery Section -->
<section id="gallery" class="gallery section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Galeri Kegiatan UKS</h2>
    <p>Dokumentasi kegiatan dan pelayanan UKS Medischool</p>
  </div>

  <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
    <div class="row g-0">

      <div class="col-lg-3 col-md-4">
        <div class="gallery-item">
          <img src="assets/frontend/img/gallery/gallery-1.jpg" class="img-fluid" alt="">
        </div>
      </div>

      <div class="col-lg-3 col-md-4">
        <div class="gallery-item">
          <img src="assets/frontend/img/gallery/gallery-2.jpg" class="img-fluid" alt="">
        </div>
      </div>

      <div class="col-lg-3 col-md-4">
        <div class="gallery-item">
          <img src="assets/frontend/img/gallery/gallery-3.jpg" class="img-fluid" alt="">
        </div>
      </div>

      <div class="col-lg-3 col-md-4">
        <div class="gallery-item">
          <img src="assets/frontend/img/gallery/gallery-4.jpg" class="img-fluid" alt="">
        </div>
      </div>

    </div>
  </div>

</section>
<!-- /Gallery Section -->

<!-- Contact Section -->
<section id="contact" class="contact section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Kontak UKS</h2>
    <p>Hubungi UKS Medischool untuk informasi lebih lanjut</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">

      <div class="col-lg-4">
        <div class="info-item d-flex">
          <i class="bi bi-geo-alt"></i>
          <div>
            <h3>Alamat Sekolah</h3>
            <p>Medischool, Indonesia</p>
          </div>
        </div>

        <div class="info-item d-flex">
          <i class="bi bi-telephone"></i>
          <div>
            <h3>Telepon</h3>
            <p>021-xxxxxxx</p>
          </div>
        </div>

        <div class="info-item d-flex">
          <i class="bi bi-envelope"></i>
          <div>
            <h3>Email</h3>
            <p>uks@medischool.sch.id</p>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <p>
          Untuk keperluan administrasi dan layanan kesehatan,
          silakan menghubungi petugas UKS melalui kontak di samping.
        </p>
      </div>

    </div>
  </div>

</section>
<!-- /Contact Section -->

@endsection
