@extends('layouts/layoutMaster')

@section('title', 'Logistics Dashboard - Apps')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/apex-charts/apexcharts.js',
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
    ])
@endsection

@section('page-script')
    @vite('')
@endsection

@section('content')
    <div class="row g-6">
        <!-- Card Border Shadow -->
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
        <!--/ Card Border Shadow -->

        <!-- Vehicles overview -->
        <div class="col-xxl-6">
            <div class="card h-100">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-6">
                    <div class="app-academy-md-25 card-body py-0 pt-6 ps-12">
                    </div>
                    <div
                        class="app-academy-md-50 card-body d-flex align-items-md-center flex-column text-md-center mb-6 py-6">
                        <span class="card-title mb-4 lh-lg px-md-12 h4 text-heading">
                            Selamat Datang ke<br>
                            <span class="text-primary text-nowrap">eProgram MOTAC</span>.
                        </span>
                        <p class="mb-4 px-0 px-md-2">
                            Sistem ini dibangunkan berdasarkan Pekeliling Perkhidmatan Bil.6 Tahun 2005 yang bertujuan untuk
                            memudahkan penjawat awam membuat permohonan kursus dan menyemak status permohonan kursus dengan
                            lebih efisien.
                        </p>
                    </div>
                    <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                        <img src="{{asset('assets/img/illustrations/pencil-rocket.png')}}" alt="pencil rocket" height="188"
                            class="scaleX-n1-rtl" />
                    </div>
                </div>
            </div>
        </div>
        <!--/ Vehicles overview -->


    </div>

@endsection