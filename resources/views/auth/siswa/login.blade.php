<!doctype html>
<html lang="id" class="layout-wide customizer-hide">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Siswa | MediSchool UKS</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/login-siswa/img/favicon/favicon.ico') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/css/core.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/frontend/login-siswa/vendor/css/pages/page-auth.css') }}">
  
  <style>
    :root {
      --primary-blue: #2B6CB0; 
      --bg-light: #F7FAFC;
    }

    body {
      background-color: var(--bg-light) !important;
      font-family: 'Inter', sans-serif;
      overflow: hidden;
      /* Background gradasi halus agar tidak sepi */
      background: radial-gradient(circle at 50% 50%, #ffffff 0%, #e2e8f0 100%) !important;
    }

    .authentication-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      border: none;
      border-top: 5px solid var(--primary-blue);
      border-radius: 16px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
      width: 100%;
      max-width: 400px;
    }

    .btn-primary {
      background-color: var(--primary-blue) !important;
      border: none;
      font-weight: 600;
      padding: 12px;
    }

    .app-brand-logo svg {
      fill: var(--primary-blue);
    }
  </style>
</head>

<body>

<div class="authentication-wrapper p-4">
  <div class="card p-4">
    <div class="card-body">
      
      <div class="text-center mb-5">
          <div class="d-flex align-items-center justify-content-center gap-2">
              <svg width="35" height="35" viewBox="0 0 24 24" fill="none">
                  <path d="M19 11H13V5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5V11H5C4.44772 11 4 11.4477 4 12C4 12.5523 4.44772 13 5 13H11V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13H19C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11Z" fill="#2B6CB0"/>
              </svg>
              <h3 class="fw-bold mb-0" style="color: var(--primary-blue); letter-spacing: -0.5px; line-height: 1;">MediSchool</h3>
          </div>
          <p class="text-muted small mt-1">Portal Kesehatan Siswa</p>
      </div>

      <h4 class="text-center fw-bold mb-4">Halo Siswa! 👋</h4>

      <form action="{{ route('siswa.login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label small fw-bold">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Masukkan email siswa" required autofocus>
        </div>
        
        <div class="mb-4">
          <div class="d-flex justify-content-between">
            <label class="form-label small fw-bold">Password</label>
          </div>
          <input type="password" class="form-control" name="password" placeholder="••••••••" required>
        </div>

        <button class="btn btn-primary w-100 btn-lg mb-3" type="submit">LOGIN SEKARANG</button>
      </form>

      <div class="text-center border-top pt-4">
        <p class="mb-0 small text-muted">Aplikasi UKS Digital &copy; 2026</p>
        <a href="#" class="small fw-bold" style="color: var(--primary-blue);">Hubungi Admin UKS</a>
      </div>

    </div>
  </div>
</div>

</body>
</html>