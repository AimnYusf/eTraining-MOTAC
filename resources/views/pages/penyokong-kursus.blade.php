@extends('layouts/blankLayout')

@section('page-style')

    @vite([
        'resources/assets/vendor/scss/pages/app-invoice.scss',
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
    ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/penyokong-kursus.js',
    ])
@endsection

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
    <div class="row invoice-preview m-4 justify-content-center">
        <!-- Invoice -->
        <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
            <div class="card invoice-preview-card p-sm-12 p-6">
                <div class="card-body invoice-preview-header rounded p-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-heading">
                            <div class="d-flex svg-illustration gap-2 align-items-center">
                                <div class="app-brand-logo demo">
                                    @include('_partials.macros', ["height" => 22, "withbg" => ''])
                                </div>
                                <span class="app-brand-text fw-bold fs-4 ms-50">
                                    {{ config('variables.templateName') }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <a href="/" class="btn btn-primary d-grid w-100 text-decoration-none">
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="ti {{ Auth::check() ? 'ti-home-2' : 'ti-login-2' }} ti-xs me-2"></i>
                                    {{ Auth::check() ? 'Laman Utama' : 'Log Masuk' }}
                                </span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3 d-flex justify-content-between">
                            <h6 class="m-0"><strong>Nama Kursus</strong></h6>
                            <h6 class="m-0"><strong>:</strong></h6>
                        </div>
                        <div class="col-sm-9">
                            <span>{{ $permohonan->eproKursus->kur_nama }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 d-flex justify-content-between">
                            <h6 class="m-0"><strong>Tarikh Kursus</strong></h6>
                            <h6 class="m-0"><strong>:</strong></h6>
                        </div>
                        <div class="col-sm-9">
                            <span>{{ $permohonan->eproKursus->kur_tkhmula }} hingga
                                {{ $permohonan->eproKursus->kur_tkhtamat }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 d-flex justify-content-between">
                            <h6 class="m-0"><strong>Tempat Kursus</strong></h6>
                            <h6 class="m-0"><strong>:</strong></h6>
                        </div>
                        <div class="col-sm-9">
                            <span>{{ $permohonan->eproKursus->eproTempat->tem_keterangan }}</span>
                        </div>
                    </div>
                </div>

                <!-- Maklumat Pemohon -->
                <div class="card-header pb-2">
                    <h5 class="mb-0">MAKLUMAT PEMOHON</h5>
                    <hr class="border-3 my-2">
                </div>
                <div class="card-body">
                    @php
                        $pemohon = [
                            'Nama' => $pengguna->pen_nama,
                            'No. MyKad (Baru)' => $pengguna->pen_nokp,
                            'Jawatan / Gred' => $pengguna->pen_jawatan . ' / ' . $pengguna->pen_gred,
                            'Agensi' => $pengguna->eproJabatan->jab_ketpenu,
                            'Bahagian' => $pengguna->eproBahagian->bah_ketpenu,
                            'No. Telefon (P)' => $pengguna->pen_notel,
                            'No. Telefon (HP)' => $pengguna->pen_nohp,
                            'No. Faks' => $pengguna->pen_nofaks,
                            'E-Mel Rasmi' => $pengguna->pen_emel,
                            'Tarikh Mohon' => $permohonan->per_tkhmohon,
                        ];
                    @endphp

                    @foreach ($pemohon as $label => $value)
                        <div class="row mb-3">
                            <div class="col-sm-3 d-flex justify-content-between">
                                <h6 class="m-0"><strong>{{ $label }}</strong></h6>
                                <h6 class="m-0"><strong>:</strong></h6>
                            </div>
                            <div class="col-sm-9">
                                <span>{{ $value }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Maklumat Sokongan -->
                <div class="card-header pb-2">
                    <h5 class="mb-0">MAKLUMAT SOKONGAN</h5>
                    <hr class="border-3 my-2">
                </div>
                <div class="card-body pb-0">
                    <div class="row mb-3">
                        <div class="col-sm-3 d-flex justify-content-between">
                            <h6 class="m-0"><strong>Nama</strong></h6>
                            <h6 class="m-0"><strong>:</strong></h6>
                        </div>
                        <div class="col-sm-9">
                            <span>{{ $pengguna->pen_ppnama }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 d-flex justify-content-between">
                            <h6 class="m-0"><strong>E-Mel</strong></h6>
                            <h6 class="m-0"><strong>:</strong></h6>
                        </div>
                        <div class="col-sm-9">
                            <span>{{ $pengguna->pen_ppemel }}</span>
                        </div>
                    </div>
                    <form id="formAuthentication">
                        @csrf
                        <input type="hidden" id="per_id" name="per_id" value="{{ $permohonan->per_id }}">
                        <div class="row mb-3">
                            <div class="col-sm-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0"><strong>Status Sokongan</strong></h6>
                                <h6 class="m-0"><strong>:</strong></h6>
                            </div>
                            <div class="col-sm-9">
                                <div class="d-flex gap-2">
                                    <select id="per_status" class="selectpicker w-50" name="per_status"
                                        data-style="btn-default" title="Sila Pilih" required>
                                        <option value="2">Diluluskan</option>
                                        <option value="3">Tidak Diluluskan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-7">
                            <button type="submit" class="btn btn-primary">Hantar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas -->
    @include('_partials._offcanvas.offcanvas-send-invoice')
    @include('_partials._offcanvas.offcanvas-add-payment')
    <!-- /Offcanvas -->
@endsection