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
<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Ringkasan Bahagian</h5>

      {{-- Select Tahun --}}
      <form method="GET" class="w-50 d-flex justify-content-end">
        <select name="tahun" class="selectpicker w-25" data-style="btn-default" onchange="this.form.submit()">
          @foreach(range(2024, now()->year) as $year)
          <option value="{{ $year }}" {{ request('tahun', now()->year) == $year ? 'selected' : '' }}>
            {{ $year }}
          </option>
          @endforeach
        </select>
      </form>

    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="table-dark table-bordered">
        <tr>
          <th class="text-center align-middle" rowspan="2" style="white-space: nowrap; width: 1%;">#</th>
          <th class="align-middle" rowspan="2">Kumpulan Perkhidmatan</th>
          <th class="text-center align-middle" rowspan="2">Pengisian</th>
          <th class="text-center" colspan="9">Hari</th>
        </tr>
        <tr>
          <th class="text-center px-4 py-3">0</th>
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
        $matched = collect($rekodKeseluruhan)->firstWhere('bahagian', $data->bah_ketpenu);
        @endphp
        <tr>
          <td class="text-center">{{ $index + 1 }}</td> {{-- Increment index for display --}}
          <td>{{ $data->bah_ketpenu }}</td>
          <td class="text-center py-5">{{ $matched['pengisian'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_0'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_1'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_2'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_3'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_4'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_5'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_6'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_7'] ?? 0}}</td>
          <td class="text-center py-5">{{ $matched['hari_8_keatas'] ?? 0}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<!--/Record List -->

@endsection