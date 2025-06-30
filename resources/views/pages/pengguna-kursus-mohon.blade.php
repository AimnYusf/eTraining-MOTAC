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
        <h5 class="text-uppercase">{{ $kursus->kur_nama }}</h5>
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
    <div class="card">
      <div class="card-body">
        <div class="card-body pt-4">
          <div class="mb-6">
            <h5 class="mb-2"><i class="ti ti-calendar-event me-2"></i>Tarikh</h5>
            <span>{{ Carbon::parse($kursus->kur_tkhmula)->format('d/m/Y') }} <strong>hingga</strong> {{ Carbon::parse($kursus->kur_tkhtamat)->format('d/m/Y') }}</span>
          </div>
          <div class="mb-6">
            <h5 class="mb-2"><i class="ti ti-map-pin me-2"></i>Tempat</h5>
            <span>{{ $kursus->eproTempat->tem_keterangan }}</span>
          </div>
          <div class="mb-6">
            <h5 class="mb-2"><i class="ti ti-users-group me-2"></i>Bilangan Peserta</h5>
            <span>{{ $kursus->kur_bilpeserta }}</span>
          </div>
          <div class="mb-6">
            <h5 class="mb-2"><i class="ti ti-user-check me-2"></i>Kumpulan Sasaran</h5>
            <span>{{ $kursus->eproKumpulan->kum_keterangan }}</span>
          </div>
          <div class="mb-6">
            <h5 class="mb-2"><i class="ti ti-user-cog me-2"></i>Urusetia</h5>
            <span>{{ $kursus->eproPenganjur->pjr_keterangan }}</span>
          </div>
          <hr class="my-6">
          <h5>Objektif</h5>
          {!! $kursus->kur_objektif !!}
          <hr class="my-6">
          <div class="col-12 text-center">
            <div class="btn-apply-modal">
              <a href="/kursus" class="btn btn-label-secondary me-2">Kembali</a>
              <button type="button" class="btn btn-primary apply-record" data-id="{{ $kursus->kur_id }}">Mohon</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection