@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

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
                                class="app-brand-logo demo mb-2" style="max-height: 100px; height: auto; width: auto;">
                            <h4 class="fw-bold">EPROGRAM</h4>
                        </div>
                        <!-- /Logo -->

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Emel</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                                    autofocus autocomplete="username"
                                    class="form-control @error('email') is-invalid @enderror" readonly>
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
                            <div class="mb-3 md-flex justify-content-between align-items-center">
                                <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    autocomplete="new-password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('login') }}" class="small text-decoration-underline">
                                    Log Masuk
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    Tukar Kata Laluan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>
@endsection