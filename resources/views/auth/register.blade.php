@extends('layouts.auth') {{-- Layout khusus auth --}}

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                {{-- (Logo SVG kalau mau ditaruh bisa di sini) --}}
              </span>
              <span class="app-brand-text demo text-body fw-bolder">SiSehat</span>
            </a>
          </div>
          <!-- /Logo -->

          <h4 class="mb-2">Adventure starts here 🚀</h4>
          <p class="mb-4">Make your app management easy and fun!</p>

          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Username -->
            <div class="mb-3">
              <label for="name" class="form-label">Username</label>
              <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
              />
              @error('name')
              <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
              />
              @error('email')
              <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  class="form-control @error('password') is-invalid @enderror"
                  name="password"
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

            <!-- Confirm Password -->
            <div class="mb-3">
              <label class="form-label" for="password-confirm">Confirm Password</label>
              <input
                type="password"
                id="password-confirm"
                class="form-control"
                name="password_confirmation"
                required
              />
            </div>

            <!-- Terms -->
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" required />
                <label class="form-check-label" for="terms">
                  I agree to <a href="#">privacy policy & terms</a>
                </label>
              </div>
            </div>

            <!-- Submit -->
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign up</button>
            </div>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">
              <span>Sign in instead</span>
            </a>
          </p>
        </div>
      </div>
      <!-- /Register Card -->
    </div>
  </div>
</div>
@endsection
