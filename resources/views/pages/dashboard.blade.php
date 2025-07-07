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
    @vite(['resources/assets/js/dashboards.js'])
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
            document.addEventListener('DOMContentLoaded', function () {
                var errorModalEl = document.getElementById('errorModal');
                var errorModal = new bootstrap.Modal(errorModalEl);
                errorModal.show();

                errorModalEl.addEventListener('hidden.bs.modal', function () {
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
                            <h4 class="mb-0">42</h4>
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
                            <h4 class="mb-0">13</h4>
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
                            <h4 class="mb-0">8</h4>
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
                            <h4 class="mb-0">27</h4>
                        </div>
                        <p class="mb-1">Permohonan Gagal</p>
                    </div>
                </div>
            </div>
            <!--/ Card Border -->

            <!-- Upcoming Webinar -->
            <div class="col-lg-4 col-md-12">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="bg-label-primary rounded">
                            <img src="{{ asset('images/logo-motac.png') }}" alt="Logo MOTAC" class="img-fluid w-50 py-2" />
                        </div>

                        <h5 class="my-2">
                            Selamat Datang ke <span class="h4">eProgram 👋🏻</span>
                        </h5>

                        <p class="small">
                            Sistem ini dibangunkan untuk memudahkan penjawat awam membuat permohonan kursus dan menyemak status
                            permohonan dengan lebih efisien.
                        </p>

                        @if(Auth::user()->role === 'guest')
                            <a href="/profil" class="btn btn-primary w-100 mt-4">Lengkapkan Profil</a>
                        @elseif(Auth::user()->role === 'user')
                            <a href="#" class="btn btn-primary w-100 mt-4">Lihat Kursus</a>
                        @endif
                    </div>
                </div>
            </div>
            <!--/ Upcoming Webinar -->

            <!-- Course Reports Tabs -->
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1">Statistik Kursus 2025</h5>
                            <p class="card-subtitle">Jumlah kursus yang dihadiri 23.8k</p>
                        </div>
                        <a href="#" class="btn btn-primary">Laporan Lengkap</a>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0 ms-0 ms-sm-2">
                            <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
                                <div id="earningReportsTabsOrders"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection