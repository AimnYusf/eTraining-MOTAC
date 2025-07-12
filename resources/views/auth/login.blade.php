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

@php
use Illuminate\Support\Facades\Route;
@endphp

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6">
            <!-- Login -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand flex-column justify-content-center align-items-center text-center">
                        <img src="{{ asset('images/logo-kementerian.png') }}" alt="Logo"
                            class="app-brand-logo demo mb-2"
                            style="max-height: 100px; height: auto; width: auto;">
                        <h4 class="fw-bold mb-0">{{ config('app.name') }}</h4>
                        <p><em>Sistem Pengurusan Latihan MOTAC</em></p>
                    </div>
                    <!-- /Logo -->

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Emel</label>
                            <input type="text" name="email" id="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" autofocus autocomplete="username">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">Kata Laluan</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" autocomplete="current-password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <!-- <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember_me" class="form-check-input">
                            <label class="form-check-label" for="remember_me">Ingat saya</label>
                        </div> -->

                        <div class="d-flex justify-content-between align-items-center">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-underline">
                                Lupa Kata Laluan?
                            </a>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                Log Masuk
                            </button>
                        </div>
                    </form>

                    <p class="text-center mt-4">
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