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
      <h5 class="mb-0 flex-grow-1">Rekod Keseluruhan</h5>
    </div>
    </div>
    <div class="card-body">
    <form method="GET" class="mb-4">
      <div class="d-flex align-items-center">

      {{-- Select Tahun --}}
      <select name="tahun" class="selectpicker w-25" data-style="btn-default" onchange="this.form.submit()">
        <option value="">Semua Tahun</option>
        @foreach(range(2020, now()->year) as $year)
      <option value="{{ $year }}" {{ request('tahun', now()->year) == $year ? 'selected' : '' }}>
      {{ $year }}
      </option>
      @endforeach
      </select>

      {{-- Select Bahagian --}}
      <select class="selectpicker w-75 ms-3 me-3" name="bahagian" data-style="btn-default"
        onchange="this.form.submit()">
        <option value="">Semua Bahagian</option>
        @foreach ($bahagian as $item)
      <option value="{{ $item->bah_id }}" {{ request('bahagian', $dataPengguna->pen_idbahagian) == $item->bah_id ? 'selected' : '' }}>
      {{ $item->bah_ketpenu }}
      </option>
      @endforeach
      </select>
      </div>
    </form>

    <hr>

  <!-- Dinamic Table -->
        <table class="table table-bordered mb-4">
      <thead class="table-dark">
      <tr>
      <th class="text-center">#</th>
      <th class="text-center">Nama</th>
      <th class="text-center">Jawatan</th>
      <th class="text-center">Gred</th>
      <th class="text-center">Kumpulan</th>
      <th class="text-center">Jumlah Hari</th>
      </tr>
      </thead>
      <tbody>
        @php $number = 1; @endphp
        @foreach ($rekodKeseluruhan as $rekod)
          <tr>
            <td class="align-top text-center ">{{ $number }}</td>
            <td class="align-top text-uppercase ">{{ $rekod['nama'] }}</td>
            <td class="align-top text-center ">{{ $rekod['jawatan'] }}</td>
            <td class="align-top text-center ">{{ $rekod['gred'] }}</td>
            <td class="align-top text-center ">
              {{
                $rekod['kumpulan'] === 'Pelaksana' ? 'P' :
                ($rekod['kumpulan'] === 'Pengurusan & Profesional' ? 'P&P' : $rekod['kumpulan'])
              }}
            </td>            
            <td class="align-top text-center ">{{ $rekod['jumlah_hari'] ?? '-' }}</td> {{-- Use ?? '-' to handle null --}}
          </tr>
          @php $number++; @endphp
        @endforeach
      </tbody>
    </table>
    </div>
  </div>
  <!--/ Record List -->

@endsection