@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/apex-charts/apex-charts.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/rekod-kursus.js'
  ])
@endsection

@php
  use Carbon\Carbon;
@endphp

@section('content')
  <!-- Record List -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="card-title mb-0">Status Permohonan</h5>

      {{-- Select Tahun --}}
      <form method="GET" class="w-25">
      <select name="tahun" class="selectpicker w-100" data-style="btn-default" onchange="this.form.submit()">
        @foreach(range(2024, now()->year) as $year)
      <option value="{{ $year }}" {{ request('tahun', now()->year) == $year ? 'selected' : '' }}>
      Tahun {{ $year }}
      </option>
      @endforeach
      </select>
      </form>
    </div>
    </div>
    <div class="card-body">
    <table class="datatables table table-bordered">
      <thead class="border-top table-dark">
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
      @foreach($myRecord as $row)
      @php

      // Ensure 'hari' and 'jam' are treated as numbers
      $hari = (float) ($row['hari'] ?? 0);
      $jam = (float) ($row['jam'] ?? 0);
      $increment = $hari + $jam;
      $jumlah += $increment;

      // Apply rounding logic
      $decimal = $jumlah - floor($jumlah);
      if ($decimal >= 0.6) {
      $jumlah = $jumlah + 0.4;
      }
      @endphp
      <tr>
        <td class="align-top py-4">{{ $row['kursus'] }}</td>
        <td class="text-center align-top">{{ Carbon::parse($row['tkh_mula'])->format('d/m/Y') }}</td>
        <td class="text-center align-top">{{ Carbon::parse($row['tkh_tamat'])->format('d/m/Y') }}</td>
        <td class="align-top">{{ $row['tempat'] }}</td>
        <td class="align-top">{{ $row['penganjur'] }}</td>
        <td class="text-center align-top">{{ $row['hari'] ?? '-' }}</td>
        <td class="text-center align-top">{{ $row['jam'] ?? '-' }}</td>
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
  <!--/ Record List -->

  <div class="row mt-6">
    <!-- Course Reports -->
    <div class="col-lg-6 col-md-12 mb-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
      <div class="card-title mb-0">
        <h5 class="mb-1">Statistik Kursus</h5>
        <p class="card-subtitle">Jumlah kursus yang dihadiri 23.8k</p>
      </div>
      </div>
      <div class="card-body">
      <div class="tab-content p-0 ms-0 ms-sm-2">
        <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
        <div id="earningReportsTabsOrders"></div>
        </div>
      </div>
      </div>
    </div>
    </div>

    <!-- Vehicles Overview -->
    <div class="col-lg-6 col-md-12 mb-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
      <div class="card-title mb-0">
        <h5 class="m-0 me-2">Vehicles Overview</h5>
      </div>
      <div class="dropdown">
        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button"
        id="vehiclesOverview" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="ti ti-dots-vertical ti-md text-muted"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="vehiclesOverview">
        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
        <a class="dropdown-item" href="javascript:void(0);">Share</a>
        </div>
      </div>
      </div>
      <div class="card-body">
      <div class="d-none d-lg-flex vehicles-progress-labels mb-4">
        <div class="vehicles-progress-label on-the-way-text" style="width: 39.7%;">On the way</div>
        <div class="vehicles-progress-label unloading-text" style="width: 28.3%;">Unloading</div>
        <div class="vehicles-progress-label loading-text" style="width: 17.4%;">Loading</div>
        <div class="vehicles-progress-label waiting-text text-nowrap" style="width: 14.6%;">Waiting</div>
      </div>
      <div class="vehicles-overview-progress progress rounded-3 mb-4" style="height: 46px;">
        <div class="progress-bar fw-medium text-start bg-lighter text-dark px-4 rounded-0" role="progressbar"
        style="width: 39.7%" aria-valuenow="39.7" aria-valuemin="0" aria-valuemax="100">39.7%</div>
        <div class="progress-bar fw-medium text-start bg-primary px-4" role="progressbar" style="width: 28.3%"
        aria-valuenow="28.3" aria-valuemin="0" aria-valuemax="100">28.3%</div>
        <div class="progress-bar fw-medium text-start text-bg-info px-2 px-sm-4" role="progressbar"
        style="width: 17.4%" aria-valuenow="17.4" aria-valuemin="0" aria-valuemax="100">17.4%</div>
        <div class="progress-bar fw-medium text-start snackbar text-paper px-1 px-sm-3 rounded-0 px-lg-4"
        role="progressbar" style="width: 14.6%" aria-valuenow="14.6" aria-valuemin="0" aria-valuemax="100">14.6%
        </div>
      </div>
      <div class="table-responsive">
        <table class="table card-table">
        <tbody class="table-border-bottom-0">
          <tr>
          <td class="w-50 ps-0">
            <div class="d-flex justify-content-start align-items-center">
            <div class="me-2"><i class='ti ti-car ti-lg text-heading'></i></div>
            <h6 class="mb-0 fw-normal">On the way</h6>
            </div>
          </td>
          <td class="text-end pe-0 text-nowrap">
            <h6 class="mb-0">2hr 10min</h6>
          </td>
          <td class="text-end pe-0"><span>39.7%</span></td>
          </tr>
          <tr>
          <td class="w-50 ps-0">
            <div class="d-flex justify-content-start align-items-center">
            <div class="me-2"><i class='ti ti-circle-arrow-down ti-lg text-heading'></i></div>
            <h6 class="mb-0 fw-normal">Unloading</h6>
            </div>
          </td>
          <td class="text-end pe-0 text-nowrap">
            <h6 class="mb-0">3hr 15min</h6>
          </td>
          <td class="text-end pe-0"><span>28.3%</span></td>
          </tr>
          <tr>
          <td class="w-50 ps-0">
            <div class="d-flex justify-content-start align-items-center">
            <div class="me-2"><i class='ti ti-circle-arrow-up ti-lg text-heading'></i></div>
            <h6 class="mb-0 fw-normal">Loading</h6>
            </div>
          </td>
          <td class="text-end pe-0 text-nowrap">
            <h6 class="mb-0">1hr 24min</h6>
          </td>
          <td class="text-end pe-0"><span>17.4%</span></td>
          </tr>
          <tr>
          <td class="w-50 ps-0">
            <div class="d-flex justify-content-start align-items-center">
            <div class="me-2"><i class='ti ti-clock ti-lg text-heading'></i></div>
            <h6 class="mb-0 fw-normal">Waiting</h6>
            </div>
          </td>
          <td class="text-end pe-0 text-nowrap">
            <h6 class="mb-0">5hr 19min</h6>
          </td>
          <td class="text-end pe-0"><span>14.6%</span></td>
          </tr>
        </tbody>
        </table>
      </div>
      </div>
    </div>
    </div>
  </div>


  <script>
    window.data = @json($monthlyTotals);
  </script>

@endsection