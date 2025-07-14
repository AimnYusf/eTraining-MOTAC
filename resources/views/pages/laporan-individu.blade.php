@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
  ])
@endsection

@php
  use Carbon\Carbon;
@endphp

@section('content')
  <!-- Record List -->
  <div class="card mb-8">

    <div class="card-header d-flex flex-wrap justify-content-between gap-4">
    <div class="card-title mb-0 me-1 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 flex-grow-1">Rekod Individu</h5>
    </div>
    </div>
    <div class="card-body">
    <form method="GET" class="mb-4">
      <div class="d-flex align-items-center">

      {{-- Select Tahun --}}
      <select name="tahun" class="selectpicker w-25" data-style="btn-default" onchange="this.form.submit()">
        @foreach(range(2025, now()->year) as $year)
      <option value="{{ $year }}" {{ request('tahun', now()->year) == $year ? 'selected' : '' }}>
      {{ $year }}
      </option>
      @endforeach
      </select>

      {{-- Select Bahagian --}}
      <select class="selectpicker w-75 ms-3 me-3" name="bahagian" data-style="btn-default"
        onchange="this.form.submit()">
        @foreach ($bahagian as $item)
      <option value="{{ $item->bah_id }}" {{ request('bahagian', $dataPengguna->pen_idbahagian) == $item->bah_id ? 'selected' : '' }}>
      {{ $item->bah_ketpenu }}
      </option>
      @endforeach
      </select>

      </div>
    </form>
    </div>
  </div>
  <!--/ Record List -->

  <!-- Dinamic Table -->
  @foreach($rekodIndividu as $userId => $attendances)
    <div class="card mb-8">

    <!-- User Information -->
    <div class="card-header">
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Nama Pegawai<span>:</span></div>
      <div class="col-sm-10 text-uppercase">{{ $attendances->first()['nama'] }}</div>
    </div>
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Jawatan<span>:</span></div>
      <div class="col-sm-10">{{ $attendances->first()['jawatan'] }}</div>
    </div>
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Gred<span>:</span></div>
      <div class="col-sm-10">{{ $attendances->first()['gred'] }}</div>
    </div>
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Kumpulan<span>:</span></div>
      <div class="col-sm-10">{{ $attendances->first()['kumpulan'] }}</div>
    </div>
    </div>

    <!-- User Course Application -->
    <div class="card-body">
    <table class="table table-bordered mb-4">
      <thead class="table-dark">
      <tr>
      <th class="text-center">Kursus</th>
      <th class="text-center">T/Mula</th>
      <th class="text-center">T/Tamat</th>
      <th class="text-center">Tempat</th>
      <th class="text-center">Anjuran</th>
      <th class="text-center">Hari</th>
      <th class="text-center">Jam</th>
      <th class="text-center">Jumlah</th>
      </tr>
      </thead>
      <tbody>

      @php $jumlah = 0; @endphp
      @foreach($attendances as $row)
      @php

      // Ensure 'hari' and 'jam' are treated as numbers
      $bilangan_hari = (float) ($row['bilangan_hari'] ?? 0);
      $bilangan_jam = (float) ($row['bilangan_jam'] ?? 0);
      $jumlah += $bilangan_hari + $bilangan_jam;

      // Apply rounding logic
      $decimal = $jumlah - floor($jumlah);
      if ($decimal >= 0.6) {
      $jumlah = $jumlah + 0.4;
      }
      @endphp
      <tr>
        <td class="align-top py-4">{{ $row['nama_kursus'] }}</td>
        <td class="text-center align-top">{{ Carbon::parse($row['tarikh_mula'])->format('d/m/Y') }}</td>
        <td class="text-center align-top">{{ Carbon::parse($row['tarikh_tamat'])->format('d/m/Y') }}</td>
        <td class="align-top">{{ $row['tempat'] }}</td>
        <td class="align-top">{{ $row['penganjur'] }}</td>
        <td class="text-center align-top">{{ $row['bilangan_hari'] ?? '-' }}</td>
        <td class="text-center align-top">{{ $row['bilangan_jam'] ?? '-' }}</td>
        <td class="text-center align-top">{{ number_format($jumlah, 1) }}</td>
      </tr>
    @endforeach
      </tbody>
      <tfoot>
      <tr>
      <th colspan="7" class="text-right fw-bold">Jumlah Keseluruhan:</th>
      <th class="text-center py-4">{{ number_format($jumlah, 1) }}</th>
      </tr>
      </tfoot>
    </table>
    </div>
    </div>
  @endforeach
  <!-- /Dinamic Table -->

@endsection