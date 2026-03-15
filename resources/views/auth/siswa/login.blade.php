<!doctype html>
<html lang="id" class="layout-wide customizer-hide" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Siswa | MediSchool UKS</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/login-siswa/img/favicon/favicon.ico') }}" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/fonts/iconify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/libs/node-waves/node-waves.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/css/core.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/css/demo.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/css/pages/page-auth.css') }}">

  <script src="https://unpkg.com/@lottiefiles/lottie-player@2.0.4/dist/lottie-player.js"></script>

  <style>
    :root {
      --primary-blue: #2B6CB0; 
      --hover-blue: #1A4373;
      --bg-light: #F0F4F8;
    }

    body {
      background-color: var(--bg-light) !important;
      overflow: hidden; 
    }

    .authentication-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      position: relative;
    }

    /* Memastikan Card Login di depan animasi */
    .authentication-inner {
      position: relative;
      z-index: 10;
    }

    .card {
      border-top: 6px solid var(--primary-blue);
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }

    /* Kontainer Animasi */
    .lottie-container-left {
      position: absolute;
      bottom: -30px;
      left: -20px;
      z-index: 1;
      pointer-events: none; /* Supaya gak bisa diklik/ngeblokir form */
    }

    .lottie-container-right {
      position: absolute;
      top: 10%;
      right: 2%;
      z-index: 1;
      pointer-events: none;
    }

    .btn-primary {
      background-color: var(--primary-blue) !important;
      border-color: var(--primary-blue) !important;
      font-weight: 600;
    }

    .app-brand-text {
      color: var(--primary-blue) !important;
      font-family: 'Inter', sans-serif;
    }

    @media (max-width: 992px) {
      .lottie-container-left, .lottie-container-right { display: none; }
      body { overflow: auto; }
    }
  </style>
</head>

<body>

<div class="authentication-wrapper authentication-basic">
  
  <div class="lottie-container-left d-none d-lg-block">
    <lottie-player 
      src="https://assets8.lottiefiles.com/packages/lf20_5njp9vgg.json" 
      background="transparent" 
      speed="1" 
      style="width: 450px; height: 450px;" 
      loop 
      autoplay>
    </lottie-player>
  </div>

  <div class="lottie-container-right d-none d-lg-block">
    <lottie-player 
      src="https://assets10.lottiefiles.com/packages/lf20_tutun0v0.json" 
      background="transparent" 
      speed="1" 
      style="width: 250px; height: 250px;" 
      loop 
      autoplay>
    </lottie-player>
  </div>

  <div class="authentication-inner py-6 mx-4">
    <div class="card p-sm-7 p-2">
      <div class="card-body">
        
        <div class="app-brand justify-content-center mb-6">
          <a href="#" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
              <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 11H13V5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5V11H5C4.44772 11 4 11.4477 4 12C4 12.5523 4.44772 13 5 13H11V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13H19C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11Z" fill="#2B6CB0"/>
              </svg>
            </span>
            <span class="app-brand-text demo text-heading fw-bold" style="text-transform: uppercase; font-size: 1.6rem;">MediSchool</span>
          </a>
        </div>

        <h4 class="mb-1 text-center fw-bold">Halo Siswa! 👋</h4>
        <p class="mb-5 text-center text-muted small">Silakan masuk ke portal kesehatan sekolah</p>

        <form id="formAuthentication" class="mb-4" action="{{ route('siswa.login.post') }}" method="POST">
          @csrf
          <div class="form-floating form-floating-outline mb-4">
            <input type="email" class="form-control" id="email" name="email" placeholder="nama@sekolah.id" autofocus required>
            <label for="email">Email / NISN</label>
          </div>
          
          <div class="mb-5">
            <div class="form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password" class="form-control" name="password" placeholder="············" required />
                  <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer" id="togglePassword">
                  <i class="mdi mdi-eye-off-outline"></i>
                </span>
              </div>
            </div>
          </div>

          <div class="mb-5 d-flex justify-content-between align-items-center">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember-me">
              <label class="form-check-label" for="remember-me"> Ingat Saya </label>
            </div>
            <a href="#" class="small fw-semibold" style="color: var(--primary-blue);">Lupa Password?</a>
          </div>

          <button class="btn btn-primary d-grid w-100 btn-lg shadow-sm" type="submit">LOGIN SEKARANG</button>
        </form>

        <div class="text-center">
          <p class="mb-1 small text-muted">Aplikasi UKS Digital &copy; 2026</p>
          <a href="#" class="small fw-semibold" style="color: var(--primary-blue);">Hubungi Admin UKS</a>
        </div>
      </div>
    </div>
  </div>

  <img 
    src="{{ asset('assets/frontend/login-siswa/img/illustrations/auth-basic-mask-light.png') }}" 
    class="authentication-image" 
    style="position: absolute; bottom: 0; left: 0; z-index: 0; width: 100%; filter: hue-rotate(180deg); opacity: 0.3;"
  />
</div>

<script src="{{ asset('assets/frontend/login-siswa/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/frontend/login-siswa/vendor/js/bootstrap.js') }}"></script>
<script>
  $(document).ready(function() {
    // Fungsi Toggle Mata Password
    $('#togglePassword').on('click', function() {
      const passwordField = $('#password');
      const icon = $(this).find('i');
      const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
      passwordField.attr('type', type);
      icon.toggleClass('mdi-eye-off-outline mdi-eye-outline');
    });
  });
</script>

</body>
</html>