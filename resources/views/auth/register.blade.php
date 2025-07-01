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

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus autocomplete="name"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Emel</label>
                            <input id="email" type="text" name="email" value="{{ old('email') }}" autocomplete="username"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Laluan</label>
                            <input id="password" type="password" name="password" autocomplete="new-password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                                class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Footer: Link & Submit -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-underline small">
                                Sudah Mendaftar?
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Daftar Akaun
                            </button>
                        </div>
                    </form>

                    <!-- <p class="text-center">
                        <span>Akaun telah wujud?</span>
                        <a href="{{ url('/login') }}"><span>Log masuk</span></a>
                    </p> -->
                </div>
            </div>
            <!-- /Register Card -->

        </div>
    </div>
</div>
@endsection