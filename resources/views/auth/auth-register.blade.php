@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand flex-column justify-content-center align-items-center text-center">
            <img src="{{ asset('images/logo-kementerian.png') }}" alt="Logo"
              class="app-brand-logo demo mb-2"
              style="max-height: 100px; height: auto; width: auto;">
            <h4 class="fw-bold">EPROGRAM</h4>
          </div>
          <!-- /Logo -->

          <form id="formAuthentication" class="mb-6" action="{{ route('store') }}" method="POST">
            @csrf

            <div class="mb-6">
              <label for="name" class="form-label">Nama</label>
              <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}"
                placeholder="Nama Pengguna" required autofocus>
            </div>

            <div class="mb-6">
              <label for="email" class="form-label">Emel</label>
              <input type="email" id="email" class="form-control" name="email" placeholder="Emel Pengguna" required>
            </div>

            <div class="mb-6 form-password-toggle">
              <label for="password" class="form-label">Kata Laluan</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="************"
                  required>
              </div>
            </div>

            <div class="mb-6 form-password-toggle">
              <label for="confirm_password" class="form-label">Sahkan Kata Laluan</label>
              <div class="input-group input-group-merge">
                <input type="password" id="confirm_password" class="form-control" name="confirm_password"
                  placeholder="************" required>
              </div>
            </div>

            @error('email')
            <div class="alert alert-danger mb-6" role="alert">
              {{ $message }}
            </div>
            @enderror

            <button type="submit" class="btn btn-primary d-grid w-100">Daftar</button>
          </form>

          <p class="text-center">
            <span>Akaun telah wujud?</span>
            <a href="{{ url('/login') }}"><span>Log masuk</span></a>
          </p>
        </div>
      </div>
      <!-- /Register Card -->

    </div>
  </div>
</div>
@endsection