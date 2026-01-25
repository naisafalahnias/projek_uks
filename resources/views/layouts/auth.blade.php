<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
  data-assets-path="{{ asset('assets/backend') }}/" data-template="vertical-menu-template-free">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/backend/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/backend/vendor/fonts/boxicons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/backend/css/demo.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/page-auth.css') }}" />

  <!-- Helpers -->
  <script src="{{ asset('assets/backend/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('assets/backend/js/config.js') }}"></script>
</head>

<body>

  @yield('content')

  <!-- Core JS -->
  <script src="{{ asset('assets/backend/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assets/backend/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/backend/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/backend/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('assets/backend/js/main.js') }}"></script>

</body>
</html>
