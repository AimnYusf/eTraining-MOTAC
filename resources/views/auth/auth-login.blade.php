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
      <!-- Login -->
      <div class="card">
      <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center mb-6">
        <span
          class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
        <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
        </div>
        <!-- /Logo -->

        <form id="formAuthentication" action="{{ route('authenticate') }}" method="POST">
        @csrf
        <div class="mb-6">
          <label for="email" class="form-label">Emel</label>
          <input type="email" id="email" class="form-control" name="email" placeholder="Emel Pengguna" required
          autofocus value="{{ old('email') }}">
        </div>
        <div class="mb-6 form-password-toggle">
          <label class="form-label" for="password">Kata Laluan</label>
          <div class="input-group input-group-merge">
          <input type="password" id="password" class="form-control" name="password" placeholder="************"
            required>
          </div>
        </div>
        @error('validation')
      <div class="alert alert-danger mb-6" role="alert">
        {{ $message }}
      </div>
      @enderror
        <div class="mb-6">
          <button type="submit" class="btn btn-primary d-grid w-100">Login</button>
        </div>
        </form>

        <p class="text-center">
        <span>Pengguna baru?</span>
        <a href="{{ url('/register') }}">
          <span>Daftar akaun</span>
        </a>
        </p>
      </div>
      </div>
      <!-- /Login -->
    </div>
    </div>
  </div>
@endsection