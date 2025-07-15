@extends('layouts.auth') {{-- Layout kosong tanpa navbar/sidebar, khusus auth --}}

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <!-- Login Card -->
      <div class="card">
        <div class="card-body">

          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/backend/img/logo.png') }}" alt="Logo UKS" width="50" height="50" />
              </span>
              <span class="app-brand-text demo text-body fw-bolder">SiSehat</span>
            </a>
          </div>
          <!-- /Logo -->

          <h4 class="mb-2">Selamat Datang!👋</h4>
          <p class="mb-4">Silakan masuk untuk melanjutkan</p>

          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Input -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter your email"
                value="{{ old('email') }}"
                required
                autofocus
              />
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                  <small>Lupa Password?</small>
                </a>
                @endif
              </div>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="form-control @error('password') is-invalid @enderror"
                  placeholder="••••••••"
                  required
                />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @error('password')
              <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                  {{ old('remember') ? 'checked' : '' }} />
                <label class="form-check-label" for="remember">Ingatkan Saya</label>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /Login Card -->

    </div>
  </div>
</div>
@endsection
