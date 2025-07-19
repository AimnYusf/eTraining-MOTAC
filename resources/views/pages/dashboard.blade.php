@extends('layouts/layoutMaster')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/apex-charts/apex-charts.scss'
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/apex-charts/apexcharts.js',
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/apex-charts/apexcharts.js'
])
@endsection

@section('page-script')
@vite(['resources/assets/js/dashboard.js'])

<script>
    window.rekodBulananPengguna = @json($rekodBulananPengguna);
</script>


@endsection

@php
use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<!-- Guest -->
@if (Auth::user()->role === 'guest')
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="alert alert-warning alert-dismissible d-flex m-0 p-4" role="alert">
                <span class="alert-icon rounded">
                    <i class="ti ti-info-circle"></i>
                </span>
                <div class="d-flex flex-column ps-1">
                    <h5 class="alert-heading mb-2"><strong>Peringatan</strong></h5>
                    <p class="mb-0">Sila kemaskini Profil Pengguna anda sebelum membuat permohonan kursus.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorModalEl = document.getElementById('errorModal');
        var errorModal = new bootstrap.Modal(errorModalEl);
        errorModal.show();

        errorModalEl.addEventListener('hidden.bs.modal', function() {
            window.location.href = "{{ route('profil') }}";
        });
    });
</script>

@else
<div class="row g-6">
    <!-- Card Border -->
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i
                                class='ti ti-clipboard-list ti-28px'></i></span>
                    </div>
                    <h4 class="mb-0">{{ $jumlahPermohonanPengguna->jumlah ?? 0}}</h4>
                </div>
                <p class="mb-1">Jumlah Permohonan</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-info h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-info"><i
                                class='ti ti-file-plus ti-28px'></i></span>
                    </div>
                    <h4 class="mb-0">{{ $jumlahPermohonanPengguna->dalam_proses ?? 0}}</h4>
                </div>
                <p class="mb-1">Permohonan Baru</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-success h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-success"><i
                                class='ti ti-circle-check ti-28px'></i></span>
                    </div>
                    <h4 class="mb-0">{{ $jumlahPermohonanPengguna->berjaya ?? 0}}</h4>
                </div>
                <p class="mb-1">Permohonan Berjaya</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-danger"><i
                                class='ti ti-alert-circle ti-28px'></i></span>
                    </div>
                    <h4 class="mb-0">{{ $jumlahPermohonanPengguna->tidak_berjaya ?? 0}}</h4>
                </div>
                <p class="mb-1">Permohonan Gagal</p>
            </div>
        </div>
    </div>
    <!--/ Card Border -->

    <!-- Welcome -->
    <div class="col-lg-4 col-md-12">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="bg-label-primary rounded p-3 mb-3">
                    <img src="{{ asset('images/logo-motac.png') }}" alt="Logo MOTAC" class="img-fluid w-50" />
                </div>

                <h5 class="mb-0">
                    Selamat Datang ke <span class="h4 fw-bold">{{ config('app.name') }}</span>
                </h5>
                <p class="text-muted mb-3 fst-italic">Sistem Pengurusan Latihan MOTAC</p>
                <hr class="my-3">
                <p class="card-text mb-4">
                    Sistem eTraining merupakan sebuah platform digital yang dibangunkan bagi menyelaras, merekod dan
                    memantau pelaksanaan program latihan dan kursus secara lebih sistematik,
                    cekap dan telus.
                </p>
            </div>
        </div>
    </div>
    <!--/ Welcome -->

    <!-- Course Reports Tabs -->
    <div class="col-lg-8 col-md-12">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Statistik Kursus {{ now()->year }}</h5>
                    <p class="card-subtitle">Jumlah kursus yang dihadiri</p>
                </div>
                <a href="/rekod/kursus" class="btn btn-primary">Laporan Lengkap</a>
            </div>
            <div class="card-body d-flex flex-column">
                <div class="tab-content p-0 ms-0 ms-sm-2 mt-auto">
                    <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
                        <div id="statistikKursus"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection