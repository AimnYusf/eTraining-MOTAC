@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/flatpickr/flatpickr.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/urusetia-kehadiran-pegawai.js'
  ])
@endsection

@section('content')

  <div class="card mb-6">
    <div class="card-header d-flex flex-wrap justify-content-between gap-4 pb-0">
    <div class="card-title mb-0 me-1 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 flex-grow-1">Senarai Kehadiran</h5>
    </div>
    <a class="btn btn-primary me-1" data-bs-toggle="collapse" href="#crudCollapse" role="button" aria-expanded="false"
      aria-controls="crudCollapse">
      Rekod Baru
    </a>
    </div>
    <div class="card-body">
    <div class="collapse" id="crudCollapse">
      <form id="kehadiranForm">
      @csrf
      <input type="hidden" id="keh_idkursus" name="keh_idkursus" value="{{ $kursus->kur_id }}">

      <div class="card-header">
        <div class="row row-bordered g-0">

        <div class="col-md-8 d-flex justify-content-center align-items-center p-4">
          <div id="reader" style="width: 100%; max-width: 500px;"></div>
        </div>

        <div class="col-md-4 p-4">
          <div class="mb-4">
          <label for="keh_idusers" class="form-label">Nama Pegawai</label>
          <select id="keh_idusers" name="keh_idusers" class="form-select selectpicker w-100"
            data-style="btn-default" data-live-search="true" title="Pilih nama pegawai">
            @foreach ($permohonan as $item)
        <option value="{{ $item->per_idusers }}">{{ $item->eproPengguna->pen_nama }}
        </option>
        @endforeach
          </select>
          </div>

          <div class="mb-4">
          <label for="keh_tkhmasuk" class="form-label">Tarikh</label>
          <input type="text" id="keh_tkhmasuk" name="keh_tkhmasuk" class="form-control"
            value="{{ now()->format('d/m/Y') }}" placeholder="DD/MM/YYYY">
          </div>

          <div class="text-center mt-4">
          <button type="button" id="submit-form" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i> Simpan
          </button>
          </div>
        </div>

        </div>
      </div>
      </form>
    </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">

    <div class="d-flex align-items-start">
      <a href="/urusetia/kehadiran" class="btn btn-label-primary me-3" data-bs-toggle="tooltip" title="Kembali">
      <i class="ti ti-arrow-back-up"></i>
      </a>
      <h5 class="card-title mb-0">{{ $kursus->kur_nama }}</h5>
      <input type="hidden" id="kur_id" value="{{ $kursus->kur_id }}">
      <input type="hidden" id="kur_tkhmula" value="{{ $kursus->kur_tkhmula }}">
      <input type="hidden" id="kur_tkhtamat" value="{{ $kursus->kur_tkhtamat }}">
    </div>

    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover" id="attendanceTable">
      <thead class="border-top table-dark">
      <tr>
        <th>#</th>
        <th>Nama Pegawai</th>
        <th>Kumpulan</th>
        <th>Jantina</th>
        @php
      $startDate = new DateTime($kursus->kur_tkhmula);
      $endDate = new DateTime($kursus->kur_tkhtamat);
      for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
      echo '<th class="text-center">' . $date->format('d/m') . '</th>';
      }
    @endphp
      </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
  </div>
@endsection