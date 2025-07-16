@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  ])
@endsection

@section('vendor-script')
  @vite([
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
        @foreach(range(2024, now()->year) as $year)
      <option value="{{ $year }}" {{ request('tahun', now()->year) == $year ? 'selected' : '' }}>
      {{ $year }}
      </option>
      @endforeach
      </select>
      </div>
    </form>

    <hr>

    <!-- Dinamic Table -->
    <table class="table table-hover mb-4">
      <thead class="table-dark table-bordered">
      <tr>
        <th class="text-center align-middle" rowspan="2" style="white-space: nowrap; width: 1%;">#</th>
        <th class="align-middle" rowspan="2">Kumpulan Perkhidmatan</th>
        <th class="text-center align-middle" rowspan="2">Pengisian</th>
        <th class="text-center" colspan="8">Hari</th>
      </tr>
      <tr>
        <th class="text-center px-4 py-3">1</th>
        <th class="text-center px-4 py-3">2</th>
        <th class="text-center px-4 py-3">3</th>
        <th class="text-center px-4 py-3">4</th>
        <th class="text-center px-4 py-3">5</th>
        <th class="text-center px-4 py-3">6</th>
        <th class="text-center px-4 py-3">7</th>
        <th class="text-center px-4 py-3">≥8</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($bahagian as $index => $data) {{-- Use $index for row numbering --}}
      @php
      $matched = collect($rekodKeseluruhan)->firstWhere('id_bahagian', $data->bah_id);
      @endphp
      <tr>
        <td class="text-center">{{ $index + 1 }}</td> {{-- Increment index for display --}}
        <td>{{ $data->bah_ketpenu }}</td>
        <td class="text-center">{{ $index + 1 }}</td> {{-- Increment index for display --}}
        @if ($matched)
      <td class="text-center">{{ $matched['hari_1'] }}</td>
      <td class="text-center">{{ $matched['hari_2'] }}</td>
      <td class="text-center">{{ $matched['hari_3'] }}</td>
      <td class="text-center">{{ $matched['hari_4'] }}</td>
      <td class="text-center">{{ $matched['hari_5'] }}</td>
      <td class="text-center">{{ $matched['hari_6'] }}</td>
      <td class="text-center">{{ $matched['hari_7'] }}</td>
      <td class="text-center">{{ $matched['hari_8_keatas'] }}</td>
      @else
      <td class="text-center">0</td>
      <td class="text-center">0</td>
      <td class="text-center">0</td>
      <td class="text-center">0</td>
      <td class="text-center">0</td>
      <td class="text-center">0</td>
      <td class="text-center">0</td>
      <td class="text-center">0</td>
      @endif
      </tr>
    @endforeach
      </tbody>
    </table>

    </div>
  </div>
  <!--/ Record List -->

@endsection