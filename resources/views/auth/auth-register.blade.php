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
        <div class="app-brand justify-content-center mb-6">
        <a href="{{ url('/') }}" class="app-brand-link">
          <span
          class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
          <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
        </a>
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