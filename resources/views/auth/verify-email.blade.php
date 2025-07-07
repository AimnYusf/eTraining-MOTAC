@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary small">
                    Terima kasih kerana mendaftar! Sebelum anda mula, sila sahkan alamat emel anda dengan mengklik pautan
                    yang telah kami hantar kepada anda. Jika anda tidak menerima emel tersebut, kami sedia menghantarnya
                    semula.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success small">
                        Pautan pengesahan yang baharu telah dihantar ke alamat emel yang anda berikan semasa pendaftaran.
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <!-- Resend Verification Form -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Hantar Semula Emel Pengesahan
                        </button>
                    </form>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-underline p-0">
                            Log Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection