@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-secondary p-4">
                    <strong>Makluman: Pengaktifan E-mel Pendaftaran Sistem [Nama Sistem]</strong>
                    <br><br>
                    YBhg. Datuk / Dato’ / YBrs. Dr. / Ts. / Tuan / Puan,
                    <br><br>
                    Dimaklumkan bahawa bagi melengkapkan proses pendaftaran dalam sistem ini, YBhg. Datuk / Dato’ / YBrs.
                    Dr. / Ts. / Tuan / Puan dikehendaki untuk mengaktifkan e-mel yang telah didaftarkan.
                    <br><br>
                    Satu e-mel pengaktifan telah dihantar secara automatik ke alamat e-mel tersebut. Kegagalan untuk
                    mengaktifkan e-mel ini mungkin akan menjejaskan akses YBhg. Datuk / Dato’ / YBrs. Dr. / Ts. / Tuan /
                    Puan ke sistem.
                    <br><br>
                    Segala kerjasama yang diberikan dalam perkara ini amat dihargai dan didahului dengan ucapan terima
                    kasih.
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