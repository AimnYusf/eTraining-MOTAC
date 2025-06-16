@extends('layouts/layoutMaster')

@section('title', 'eCommerce Product Add - Apps')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/quill/typography.scss',
    'resources/assets/vendor/libs/quill/katex.scss',
    'resources/assets/vendor/libs/quill/editor.scss',
    'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/quill/katex.js',
    'resources/assets/vendor/libs/quill/quill.js',
    'resources/assets/vendor/libs/flatpickr/flatpickr.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'

  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/urusetia-kursus-tambah.js'
  ])
@endsection

@section('content')
  <div>
    <form id="formAuthentication">
    @csrf
    <input type="hidden" id="kur_id" name="kur_id" value="{{ $kursus->kur_id ?? '' }}">
    @php
    // Start from 12:00 AM and go to 11:30 PM
    $times = [];
    for ($hour = 0; $hour < 24; $hour++) {
      for ($minute = 0; $minute < 60; $minute += 30) {
      $time = sprintf('%02d:%02d %s', $hour % 12 ?: 12, $minute, $hour < 12 ? 'AM' : 'PM');
      $times[] = $time;
      }
    }
    @endphp

    <!-- Title -->
    <div
      class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
      <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-0">Senarai Kursus</h4>
      <p class="mb-0">{{ $tajuk }}</p>
      </div>

      <div class="d-flex align-content-center flex-wrap gap-4">
      <div class="d-flex gap-4">
        <a href="{{ route('urusetia-kursus') }}" class="btn btn-label-secondary">
        Batal
        </a>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      </div>

    </div>

    <div class="row">

      <!-- First column-->
      <div class="col-12 col-lg-8">
      <!-- Maklumat Kursus -->
      <div class="card mb-6">
        <div class="card-header">
        <h5 class="card-tile mb-0">Maklumat Kursus</h5>
        </div>
        <div class="card-body">

        <div class="mb-6">
          <label class="form-label" for="kur_nama">Nama Kursus</label>
          <input type="text" id="kur_nama" class="form-control" name="kur_nama"
          value="{{ $kursus->kur_nama ?? '' }}" placeholder="Nama Kursus">
        </div>
        <div class="row ">
          <div class="col mb-6"><label class="form-label" for="kur_tkhmula">Tarikh Mula</label>
          <input type="text" id="kur_tkhmula" class="form-control" name="kur_tkhmula"
            value="{{ $kursus->kur_tkhmula ?? '' }}" placeholder="DD/MM/YYYY" />
          </div>
          <div class="col mb-6"><label class="form-label" for="kur_msamula">Masa Mula</label>
          <select id="kur_msamula" name="kur_msamula" class="selectpicker w-100" data-style="btn-default"
            title="Sila Pilih">
            @foreach($times as $time)
        <option value="{{ $time }}" {{ ($kursus->kur_msamula ?? '') == $time ? 'selected' : '' }}>
        {{ $time }}
        </option>
        @endforeach
          </select>
          </div>
        </div>
        <div class="row ">
          <div class="col mb-6"><label class="form-label" for="kur_tkhtamat">Tarikh Tamat</label>
          <input type="text" id="kur_tkhtamat" class="form-control" name="kur_tkhtamat" placeholder="DD/MM/YYYY"
            value="{{ $kursus->kur_tkhtamat ?? '' }}" />
          </div>
          <div class="col mb-6"><label class="form-label" for="kur_msatamat">Masa Tamat</label>
          <select id="kur_msatamat" name="kur_msatamat" class="selectpicker w-100" data-style="btn-default"
            title="Sila Pilih">
            @foreach($times as $time)
        <option value="{{ $time }}" {{ ($kursus->kur_msatamat ?? '') == $time ? 'selected' : '' }}>
        {{ $time }}
        </option>
        @endforeach
          </select>
          </div>
        </div>

        <div class="mb-6">
          <label class="form-label" for="kur_idtempat">Tempat Kursus</label>
          <select id="kur_idtempat" class="selectpicker w-100" name="kur_idtempat" data-style="btn-default"
          title="Sila Pilih">
          @foreach ($tempat as $data)
        <option value="{{ $data->tem_id }}" {{ isset($kursus) && $data->tem_id == $kursus->kur_idtempat ? 'selected' : '' }}>
        {{ $data->tem_keterangan }}
        </option>
      @endforeach
          </select>
        </div>

        <!-- Objektif -->
        <div>
          <label class="mb-1">Objektif Kursus</label>
          <div class="form-control p-0">
          <div class="objektif-toolbar border-0 border-bottom">
            <div class="d-flex justify-content-start">
            <span class="ql-formats me-0">
              <button class="ql-bold"></button>
              <button class="ql-italic"></button>
              <button class="ql-underline"></button>
              <button class="ql-list" value="ordered"></button>
              <button class="ql-list" value="bullet"></button>
            </span>
            </div>
          </div>
          <div id="kur_objektif" class="objektif-editor border-0 pb-6"></div>
          <input type="hidden" name="kur_objektif" id="kur_objektif_input"
            value="{{ $kursus->kur_objektif ?? '' }}" />
          </div>
        </div>
        <div id="objektifError" class="alert alert-danger mt-2 m-0 d-none" role="alert">
          Sila masukkan objektif kursus.
        </div>
        </div>
      </div>
      <!-- /Maklumat Kursus -->
      </div>
      <!-- /First column -->


      <!-- Second column -->
      <div class="col-12 col-lg-4">

      <!-- Lain lain -->
      <div class="card mb-6">
        <div class="card-body">
        <div class="mb-6">
          <label class="form-label" for="kur_bilhari">Bilangan Hari</label>
          <input type="number" id="kur_bilhari" class="form-control" name="kur_bilhari"
          value="{{ $kursus->kur_bilhari ?? '' }}" placeholder="Bilangan Hari">
        </div>
        <div class="mb-6">
          <label class="form-label" for="kur_bilpeserta">Bilangan Peserta</label>
          <input type="number" id="kur_bilpeserta" class="form-control" name="kur_bilpeserta"
          value="{{ $kursus->kur_bilpeserta ?? '' }}" placeholder="Bilangan Peserta">
        </div>
        <hr>
        <div class="mb-6">
          <label class="form-label" for="kur_idkategori">Kategori Kursus</label>
          <select id="kur_idkategori" class="selectpicker w-100" name="kur_idkategori" data-style="btn-default"
          title="Sila Pilih">
          @foreach ($kategori as $data)
        <option value="{{ $data->kat_id }}" {{ isset($kursus) && $data->kat_id == $kursus->kur_idkategori ? 'selected' : '' }}>
        {{ $data->kat_keterangan }}
        </option>
      @endforeach
          </select>
        </div>
        <div class="mb-6">
          <label class="form-label" for="kur_idpenganjur">Penganjur</label>
          <select id="kur_idpenganjur" name="kur_idpenganjur" class="selectpicker w-100" data-style="btn-default"
          title="Sila Pilih">
          @foreach ($penganjur as $data)
        <option value="{{ $data->pjr_id }}" {{ isset($kursus) && $data->pjr_id == $kursus->kur_idpenganjur ? 'selected' : '' }}>
        {{ $data->pjr_keterangan }}
        </option>
      @endforeach
          </select>
        </div>
        <div class="mb-6">
          <label class="form-label" for="kur_idkumpulan">Kumpulan Pegawai</label>
          <select id="kur_idkumpulan" name="kur_idkumpulan" class="selectpicker w-100" data-style="btn-default"
          title="Sila Pilih">
          @foreach ($kumpulan as $data)
        <option value="{{ $data->kum_id }}" {{ isset($kursus) && $data->kum_id == $kursus->kur_idkumpulan ? 'selected' : '' }}>
        {{ $data->kum_keterangan }}
        </option>
      @endforeach
          </select>
        </div>
        </div>
      </div>
      <!-- /Lain lain -->

      <!-- Tetapan -->
      <div class="card mb-6">
        <div class="card-header">
        <h5 class="card-title mb-0">Tetapan</h5>
        </div>
        <div class="card-body">
        <div class="mb-6">
          <label class="form-label" for="kur_tkhbuka">Tarikh Buka Permohonan</label>
          <input type="text" id="kur_tkhbuka" class="form-control" name="kur_tkhbuka"
          value="{{ $kursus->kur_tkhbuka ?? '' }}" placeholder="DD/MM/YYYY" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="kur_tkhtutup">Tarikh Tutup Permohonan</label>
          <input type="text" id="kur_tkhtutup" class="form-control" name="kur_tkhtutup"
          value="{{ $kursus->kur_tkhtutup ?? '' }}" placeholder="DD/MM/YYYY" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="kur_status">Status</label>
          <select id="kur_status" name="kur_status" class="selectpicker w-100" data-style="btn-default"
          title="Sila Pilih">
          <option value="1" {{($kursus->kur_status ?? '') == '1' ? 'selected' : '' }}>Aktif
          </option>
          <option value="0" {{($kursus->kur_status ?? '') == '0' ? 'selected' : '' }}>Tidak Aktif
          </option>
          </select>
        </div>
        </div>
      </div>
      <!-- /Tetapan -->
      </div>
      <!-- /Second column -->
    </div>
    </form>
  </div>
@endsection