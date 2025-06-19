@php
  $configData = Helper::appClasses();
  $isNavbar = false;
  $isMenu = false;
@endphp

@extends('layouts/layoutMaster')

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
  @vite(['resources/assets/js/penyokong-kursus.js'])
@endsection

@section('content')
<div class="card">
  <div class="card-header pb-2 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <div class="app-brand-logo demo">
        @include('_partials.macros', ["height" => 22, "withbg" => ''])
      </div>
      <span class="app-brand-text fw-bold fs-4 ms-1">
        {{ config('variables.templateName') }}
      </span>
    </div>
    <span class="badge bg-label-success fs-5" style="white-space: normal;">
      {{ $permohonan->per_tkhmohon }}
    </span>
  </div>

    <div class="card-body">
      {{-- Maklumat Kursus --}}
      <section class="mb-8">
        <div class="divider text-start">
          <h5 class="divider-text m-0">MAKLUMAT KURSUS</h5>
        </div>

        <div class="row ps-2 mb-3">
          <div class="col-sm-3 d-flex justify-content-between">Nama Kursus<span>:</span></div>
          <div class="col-sm-9">
            <span>{{ $permohonan->eproKursus->kur_nama }}</span>
          </div>
        </div>

        <div class="row ps-2 mb-3">
          <div class="col-sm-3 d-flex justify-content-between">Tarikh Kursus<span>:</span></div>
          <div class="col-sm-9">
            <span>{{ $permohonan->eproKursus->kur_tkhmula }} hingga {{ $permohonan->eproKursus->kur_tkhtamat }}</span>
          </div>
        </div>

        <div class="row ps-2 mb-3">
          <div class="col-sm-3 d-flex justify-content-between">Tempat Kursus<span>:</span></div>
          <div class="col-sm-9">
            <span>{{ $permohonan->eproKursus->eproTempat->tem_keterangan }}</span>
          </div>
        </div>
      </section>

      {{-- Maklumat Pemohon --}}
      <section class="mb-8">
        <div class="divider text-start">
          <h5 class="divider-text m-0">MAKLUMAT PEMOHON</h5>
        </div>

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
          <div class="row ps-2 mb-3">
            <div class="col-sm-3 d-flex justify-content-between">{{ $label }}<span>:</span></div>
            <div class="col-sm-9">
              <span>{{ $value }}</span>
            </div>
          </div>
        @endforeach
      </section>


      {{-- Tindakan Urusetia --}}
      <section>
        <div class="divider text-start">
          <h5 class="divider-text m-0">TINDAKAN URUSETIA</h5>
        </div>

        <div class="row ps-2 mb-3">
          <div class="col-sm-3 d-flex justify-content-between">Nama<span>:</span></div>
          <div class="col-sm-9">
            <span>{{ $pengguna->pen_ppnama }}</span>
          </div>
        </div>

        <div class="row ps-2 mb-3">
          <div class="col-sm-3 d-flex justify-content-between">E-Mel<span>:</span></div>
          <div class="col-sm-9">
            <span>{{ $pengguna->pen_ppemel }}</span>
          </div>
        </div>

  <form id="formAuthentication">
    @csrf
        <input type="hidden" id="per_id" name="per_id" value="{{ $permohonan->per_id }}">
        <div class="row ps-2 mb-3">
          <div class="col-sm-3 d-flex justify-content-between align-items-center">Status Sokongan<span>:</span></div>
          <div class="col-sm-9">
            <select id="per_status" name="per_status" class="selectpicker w-50" data-style="btn-default" title="Sila Pilih" required>
              <option value="2">Diluluskan</option>
              <option value="3">Tidak Diluluskan</option>
            </select>
          </div>
        </div>
      </section>
    </div>

    <div class="card-footer text-center">
      <button type="submit" class="btn btn-primary">Hantar</button>
    </div>
  </form>
</div>
@endsection
