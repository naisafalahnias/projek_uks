<!doctype html>
<html lang="id"
  class="layout-wide customizer-hide"
  data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Siswa | UKS</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/login-siswa/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/fonts/iconify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/libs/node-waves/node-waves.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/css/core.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/css/demo.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/css/pages/page-auth.css') }}">

  <!-- Helpers -->
  <script src="{{ asset('assets/frontend/login-siswa/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('assets/frontend/login-siswa/js/config.js') }}"></script>
</head>

<body>

<div class="authentication-wrapper authentication-basic container-p-y">
  <div class="authentication-inner py-6 mx-4">

    <div class="card p-sm-7 p-2">
      <div class="app-brand justify-content-center mt-5">
        <span class="app-brand-text fw-semibold">LOGIN SISWA UKS</span>
      </div>

      <div class="card-body mt-3">

        <h4 class="mb-1">Halo Siswa 👋</h4>
        <p class="mb-4">Silakan login untuk melihat data kesehatanmu</p>

        {{-- ERROR --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('siswa.login.post') }}">
          @csrf

          <div class="form-floating mb-4">
            <input
              type="email"
              class="form-control"
              name="email"
              placeholder="Email"
              required
            >
            <label>Email</label>
          </div>

          <div class="form-floating mb-4">
            <input
              type="password"
              class="form-control"
              name="password"
              placeholder="Password"
              required
            >
            <label>Password</label>
          </div>

          <div class="mb-4">
            <button class="btn btn-primary w-100" type="submit">
              Login
            </button>
          </div>
        </form>

        <p class="text-center mt-3">
          <a href="{{ route('landing') }}">← Kembali ke Beranda</a>
        </p>

      </div>
    </div>

  </div>
</div>

<!-- Core JS -->
<script src="{{ asset('assets/frontend/login-siswa/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/frontend/login-siswa/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/frontend/login-siswa/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('assets/frontend/login-siswa/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/frontend/login-siswa/vendor/js/menu.js') }}"></script>
<script src="{{ asset('assets/frontend/login-siswa/js/main.js') }}"></script>

</body>
</html>
