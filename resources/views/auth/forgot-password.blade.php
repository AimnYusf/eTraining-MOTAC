@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary p-4">
                    Sila masukkan e-mel rasmi yang telah didaftarkan untuk penetapan semula kata laluan.
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success small">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Emel</label>
                        <input id="email" type="text" name="email" value="{{ old('email') }}" autofocus
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('login') }}" class="btn btn btn-label-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Emel Pautan Set Semula Kata Laluan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection