@extends('layouts/layoutMaster')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
])
@endsection

@section('page-script')
@vite('resources/assets/js/pengguna-kursus-mohon.js')
@endsection

@php
use Carbon\Carbon;
@endphp

@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="card academy-content shadow-none border">
          <div class="p-2">
            <img class="img-fluid w-100 h-100 object-fit-cover"
              src="{{ $kursus->kur_poster }}" alt="tutor image 1" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card h-100 shadow-lg border-0 rounded-3">
      <div class="card-header bg-gradient-primary text-white text-uppercase py-3 px-4">
        <h5 class="mb-0 text-white">{{ $kursus->kur_nama }}</h5>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mb-0 mt-6">
          <li class="mb-5 d-flex align-items-center">
            <div class="badge bg-label-info text-body p-3 me-4 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="ti ti-calendar-event ti-md"></i>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1 text-primary">Tarikh</h5>
              <span class="text-dark">
                  @if (Carbon::parse($kursus->kur_tkhmula)->format('Y-m-d') == Carbon::parse($kursus->kur_tkhtamat)->format('Y-m-d'))
                      {{ Carbon::parse($kursus->kur_tkhmula)->format('d/m/Y') }}
                  @else
                      {{ Carbon::parse($kursus->kur_tkhmula)->format('d/m/Y') }} <strong class="text-muted">hingga</strong> {{ Carbon::parse($kursus->kur_tkhtamat)->format('d/m/Y') }}
                  @endif
              </span>
            </div>
          </li>
          <li class="mb-5 d-flex align-items-center">
            <div class="badge bg-label-success text-body p-3 me-4 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="ti ti-map-pin ti-md"></i>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1 text-primary">Tempat</h5>
              <span class="text-dark">{{ $kursus->eproTempat->tem_keterangan }}</span>
            </div>
          </li>
          <li class="mb-5 d-flex align-items-center">
            <div class="badge bg-label-warning text-body p-3 me-4 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="ti ti-calendar-plus ti-md"></i>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1 text-primary">Tarikh Buka Permohonan</h5>
              <span class="text-dark">{{ Carbon::parse($kursus->kur_tkhbuka)->format('d/m/Y') }}</span>
            </div>
          </li>
          <li class="mb-5 d-flex align-items-center">
            <div class="badge bg-label-danger text-body p-3 me-4 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="ti ti-calendar-minus ti-md"></i>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1 text-primary">Tarikh Tutup Permohonan</h5>
              <span class="text-dark">{{ Carbon::parse($kursus->kur_tkhtutup)->format('d/m/Y') }}</span>
            </div>
          </li>
          <li class="mb-5 d-flex align-items-center">
            <div class="badge bg-label-primary text-body p-3 me-4 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="ti ti-user-check ti-md"></i>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1 text-primary">Kumpulan Sasaran</h5>
              <span class="text-dark">{{ $kursus->eproKumpulan->kum_ketpenu }}</span>
            </div>
          </li>
          <li class="mb-5 d-flex align-items-center">
            <div class="badge bg-label-secondary text-body p-3 me-4 rounded-circle d-flex align-items-start justify-content-center flex-shrink-0">
              <i class="ti ti-user-cog ti-md"></i>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1 text-primary">Penganjur</h5>
              <span class="text-dark">{{ $kursus->eproPenganjur->pjr_keterangan }}</span>
            </div>
          </li>
        </ul>

        @if (!is_null($kursus->kur_urusetia))
        <hr class="my-6 border-top border-light">
        <h5 class="mb-3 text-primary">Urusetia Program</h5>
        <div class="text-muted">
          @php
          $selectedIds = (array) $kursus->kur_urusetia;
          $urusetia = $urusetia->whereIn('pic_id', $selectedIds);
          @endphp

          @foreach ($urusetia as $data)
          <div class="mb-5">
            <p class="mb-1 text-dark text-uppercase fw-bold"><i class="ti ti-user me-2 text-primary"></i>{{ $data->pic_nama }}</p>
            <p class="mb-1 text-dark"><i class="ti ti-phone-call me-2 text-success"></i>{{ $data->pic_notel }}</p>
            <p class="mb-0 text-dark"><i class="ti ti-mail me-2 text-info"></i><span class="text-lowercase">{{ $data->pic_emel ?? 'Tiada emel' }}</span></p>
          </div>
          @endforeach
        </div>
        @endif

        <hr class="my-6 border-top border-light">

        <h5 class="mb-3 text-primary">Objektif</h5>
        <div class="text-muted text-justify">
          {!! $kursus->kur_objektif !!}
        </div>
      </div>
      <div class="card-footer">
        <div class="col-12 text-center">
          <div class="btn-apply-modal">
            <a href="/kursus" class="btn btn-label-secondary me-2">Kembali</a>
              @if (now()->between($kursus->kur_tkhbuka, $kursus->kur_tkhtutup) && !isset($permohonan))
                  <button type="button" class="btn btn-primary apply-record" data-id="{{ $kursus->kur_id }}">Mohon</button>
              @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection