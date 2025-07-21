@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
    <style>
        body {
            /* Background Image with Overlay */
            background-image: url("{{ asset('images/background.png') }}");
            /* Make sure this image exists */
            background-size: cover;
            /* Covers the entire viewport */
            background-position: center center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents image from repeating */
            background-attachment: fixed;
            /* Keeps image fixed when scrolling */
            /* Add a semi-transparent dark overlay for better text contrast */
            background-color: rgba(0, 0, 0, 0.7);
            /* Darker overlay color */
            background-blend-mode: overlay;
            /* Blends the color with the image */
        }

        /* Adjust card background for better contrast and a modern feel */
        .authentication-inner .card {
            background-color: rgba(255, 255, 255, 0.92);
            /* Slightly transparent white for a subtle effect */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            /* More pronounced shadow for depth */
            border-radius: 12px;
            /* Slightly rounded corners */
        }

        /* Adjust logo container for better spacing and centering */
        .app-brand {
            padding-top: 1.5rem;
            /* Add some padding at the top */
            padding-bottom: 1rem;
            /* Add some padding at the bottom */
        }

        .app-brand-logo.demo {
            max-height: 120px;
            /* Slightly larger logo */
        }

        .app-brand h4 {
            font-size: 1.8rem;
            /* Larger title */
            margin-bottom: 0.25rem !important;
            /* Adjust spacing */
        }

        .app-brand p {
            font-size: 1rem;
            /* Slightly larger slogan */
            color: #6c757d;
            /* Muted color for the slogan */
        }
    </style>
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
                                class="app-brand-logo demo mb-2" style="max-height: 100px; height: auto; width: auto;">
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
                                    class="form-control @error('email') is-invalid @enderror" autofocus
                                    autocomplete="username">
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
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Captcha -->
                            <div class="mt-4 mb-4">
                                <!-- "I'm not a robot" checkbox -->
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="robotCheck" name="robot_check"
                                        onchange="toggleCaptcha()" {{ old('robot_check') ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="robotCheck">
                                        Saya bukan robot
                                    </label>
                                </div>

                                <!-- CAPTCHA container - hidden by default -->
                                <div id="captcha-container" style="display: none;">
                                    <div class="flex flex-column space-y-2 mt-1">
                                        <img src="{{ captcha_src('flat') }}" alt="captcha" id="captcha-img" class="w-100">
                                        <button type="button" onclick="refreshCaptcha()"
                                            class="btn btn-secondary btn-sm w-100">↻ Muat semula Captcha</button>
                                    </div>
                                    <input id="captcha" type="text" name="captcha"
                                        class="form-control mt-2 @error('captcha') is-invalid @enderror">
                                    @error('captcha')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <script>
                                function refreshCaptcha() {
                                    document.getElementById('captcha-img').src = '/captcha/default?' + Math.random();
                                }

                                function toggleCaptcha() {
                                    const checkbox = document.getElementById('robotCheck');
                                    const captchaContainer = document.getElementById('captcha-container');
                                    captchaContainer.style.display = checkbox.checked ? 'block' : 'none';
                                }

                                // Automatically show CAPTCHA on page load if checkbox is checked (e.g., after validation error)
                                window.addEventListener('DOMContentLoaded', function () {
                                    toggleCaptcha();
                                });
                            </script>


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