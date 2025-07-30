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
    <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start">
    <div class="d-flex me-6">
      <a href="/urusetia/kehadiran" class="btn btn-label-primary" data-bs-toggle="tooltip" title="Kembali">
      <i class="ti ti-arrow-back-up"></i>
      </a>
    </div>
    <div class="d-flex align-items-center mb-3 mb-sm-0 me-auto ">
      <h5 class="card-title mb-0">{{ $kursus->kur_nama }}</h5>
      {{-- Hidden inputs for course details --}}
      <input type="hidden" id="kur_id" value="{{ $kursus->kur_id }}">
      <input type="hidden" id="kur_tkhmula" value="{{ $kursus->kur_tkhmula }}">
      <input type="hidden" id="kur_tkhtamat" value="{{ $kursus->kur_tkhtamat }}">
    </div>
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
        <option value="{{ $item->per_idusers }}">{{ $item->etraPengguna->pen_nama }}</option>
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

  <div class="col-12">
    <div class="nav-align-top nav-tabs-shadow mb-6">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-show"
        aria-controls="navs-top-show" aria-selected="true">Papar Kehadiran</button>
      </li>
      <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-edit"
        aria-controls="navs-top-edit" aria-selected="false">Isi Kehadiran</button>
      </li>
    </ul>
    <div class="tab-content pt-0">

      <div class="tab-pane fade show active" id="navs-top-show" role="tabpanel">
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
        echo '<th class="text-center">' . $date->format('d/m/Y') . '</th>';
      }
      @endphp
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      </div>

      <div class="tab-pane fade" id="navs-top-edit" role="tabpanel">
      <form id="attendanceForm" action="{{ route('kehadiran.update') }}" method="POST">
        @csrf
        <input type="hidden" name="kursus_id" value="{{ $kursus->kur_id }}">
        <input type="hidden" id="courseName" value="{{ $kursus->kur_nama }}">

        <div class="d-flex justify-content-end my-6">
        <button type="submit" class="btn btn-primary me-2"><i class="ti ti-device-floppy me-1"></i>Simpan</button>
        <button type="reset" class="btn btn-label-secondary">Set Semula</button>
        </div>

        @php
      $startDate = \Carbon\Carbon::parse($kursus->kur_tkhmula);
      $endDate = \Carbon\Carbon::parse($kursus->kur_tkhtamat);
      $dates = [];
      for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
      $dates[] = $date->copy();
      }
    @endphp

        <table class="table table-hover">
        <thead class="border-top table-dark">
          <tr>
          <th class="text-center" style="width: 10%;"><small>Pilih Semua</small></th>
          <th class="text-center">Nama Pegawai</th>
          @foreach ($dates as $dateItem)
        <th class="text-center">{{ $dateItem->format('d/m/Y') }}</th>
      @endforeach
          </tr>
        </thead>
        <tbody>
          @forelse ($permohonan as $application)
        <tr>
        <td class="text-center cursor-pointer pilih-seluruh-ruangan"
          data-user-id="{{ $application->etraPengguna->pen_idusers }}">
          <input type="checkbox" class="form-check-input select-row-checkbox"
          data-user-id="{{ $application->etraPengguna->pen_idusers }}">
        </td>

        <td class="cursor-pointer pilih-seluruh-ruangan"
          data-user-id="{{ $application->etraPengguna->pen_idusers }}">
          {{ $application->etraPengguna->pen_nama }}
          <input type="hidden" class="participant-name" value="{{ $application->etraPengguna->pen_nama }}">
          <input type="hidden" class="participant-idusers"
          value="{{ $application->etraPengguna->pen_idusers }}">
        </td>

        @foreach ($dates as $dateItem)
        @php
        $hasAttended = $application->etraPengguna->etraKehadiran->contains(function ($keh) use ($application, $kursus, $dateItem) {
        return $keh->keh_idusers === $application->etraPengguna->pen_idusers &&
        $keh->keh_idkursus === $kursus->kur_id &&
        \Carbon\Carbon::parse($keh->keh_tkhmasuk)->isSameDay($dateItem);
        });
        @endphp
        <td class="text-center">
        <div class="form-check d-flex justify-content-center">
        <input type="hidden"
          name="attendance[{{ $application->etraPengguna->pen_idusers }}][{{ $dateItem->format('Y-m-d') }}]"
          value="0" class="hidden-attendance-input" />
        <input class="form-check-input attendance-checkbox" type="checkbox"
          data-user-id="{{ $application->etraPengguna->pen_idusers }}"
          data-date="{{ $dateItem->format('Y-m-d') }}"
          name="attendance[{{ $application->etraPengguna->pen_idusers }}][{{ $dateItem->format('Y-m-d') }}]"
          id="attendance_{{ $application->etraPengguna->pen_idusers }}_{{ $dateItem->format('Y_m_d') }}"
          value="1" {{ $hasAttended ? 'checked' : '' }} />
        </div>
        </td>
      @endforeach
        </tr>
      @empty
        <tr>
        <td colspan="{{ count($dates) + 2 }}" class="text-center">No successful applicants found.</td>
        </tr>
      @endforelse
        </tbody>
        </table>
      </form>
      </div>

    </div>
    </div>
  </div>
@endsection