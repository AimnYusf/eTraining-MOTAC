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
  <script>
    window.rekodBulananPengguna = @json($rekodBulananPengguna);
  </script>

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
    <div class="d-flex align-items-center mb-5">
      <a href="/rekod-pegawai" class="btn btn-label-primary me-3" data-bs-toggle="tooltip" title="Kembali">
      <i class="ti ti-arrow-back-up"></i>
      </a>
      <h5 class="card-title mb-0">Rekod Kursus</h5>
    </div>
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Nama Pegawai<span>:</span></div>
      <div class="col-sm-10 text-uppercase">{{ $pengguna->pen_nama }}</div>
    </div>
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Jawatan<span>:</span></div>
      <div class="col-sm-10">{{ $pengguna->pen_jawatan }}</div>
    </div>
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Gred<span>:</span></div>
      <div class="col-sm-10">{{ $pengguna->pen_gred }}</div>
    </div>
    <div class="row ps-2 mb-1">
      <div class="col-sm-2 d-flex justify-content-between fw-bold">Kumpulan<span>:</span></div>
      <div class="col-sm-10">{{ $pengguna->etraKumpulan->kum_ketpenu }}</div>
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
      @foreach($rekodPengguna as $row)
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
  <!--/ Record List -->

  <div class="row mt-6">
    <!-- Course Reports -->
    <div class="col-lg-6 col-md-12 mb-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
      <div class="card-title mb-0">
        <h5 class="mb-1">Statistik Kursus</h5>
        <p class="card-subtitle">Jumlah kursus yang dihadiri</p>
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

    <!-- Statistik Permohonan -->
    <div class="col-lg-6 col-md-12 mb-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content
    -           between">
      <div class="card-title mb-0">
        <h5 class="m-0 me-2">Statistik Permohonan</h5>
        <p class="card-subtitle">Jumlah keseluruhan permohonan adalah
        <strong>{{ $jumlahPermohonanPengguna->jumlah }}</strong>.
        </p>
      </div>
      </div>
      @php
    if (empty($jumlahPermohonanPengguna->jumlah)) {
      $peratusDalamProses = 0;
      $peratusBerjaya = 0;
      $peratusTidakBerjaya = 0;
    } else {
      $peratusDalamProses = ($jumlahPermohonanPengguna->dalam_proses / $jumlahPermohonanPengguna->jumlah) * 100;
      $peratusBerjaya = ($jumlahPermohonanPengguna->berjaya / $jumlahPermohonanPengguna->jumlah) * 100;
      $peratusTidakBerjaya = ($jumlahPermohonanPengguna->tidak_berjaya / $jumlahPermohonanPengguna->jumlah) * 100;
    }
    @endphp
      <div class="card-body">

      <div class="d-none d-lg-flex vehicles-progress-labels mb-4">
        @if($peratusDalamProses > 0)
      <div class="vehicles-progress-label on-the-way-text" style="width: {{ $peratusDalamProses }}%;">Dalam Proses
      </div>
      @endif
        @if($peratusBerjaya > 0)
      <div class="vehicles-progress-label berjaya-text" style="width: {{ $peratusBerjaya }}%;">Berjaya</div>
      @endif
        @if($peratusTidakBerjaya > 0)
      <div class="vehicles-progress-label tidak_berjaya-text text-nowrap"
      style="width: {{ $peratusTidakBerjaya }}%;">Tidak Berjaya</div>
      @endif
      </div>

      <div class="vehicles-overview-progress progress rounded-3 mb-4" style="height: 46px;">

        @if($peratusDalamProses > 0)
      <div class="progress-bar fw-medium text-start bg-lighter text-dark px-4 rounded-0" role="progressbar"
      style="width: {{ $peratusDalamProses }}%;" aria-valuenow="{{ $peratusDalamProses }}" aria-valuemin="0"
      aria-valuemax="100">{{ round($peratusDalamProses) }}%</div>
      @endif

        @if($peratusBerjaya > 0)
      <div class="progress-bar fw-medium text-start text-bg-success px-2 px-sm-4 rounded-0" role="progressbar"
      style="width: {{ $peratusBerjaya }}%;" aria-valuenow="{{ $peratusBerjaya }}" aria-valuemin="0"
      aria-valuemax="100">{{ round($peratusBerjaya) }}%</div>
      @endif

        @if($peratusTidakBerjaya > 0)
      <div class="progress-bar fw-medium text-start text-bg-danger text-paper px-1 px-sm-3 rounded-0 px-lg-4"
      role="progressbar" style="width: {{ $peratusTidakBerjaya }}%;" aria-valuenow="{{ $peratusTidakBerjaya }}"
      aria-valuemin="0" aria-valuemax="100">{{ round($peratusTidakBerjaya) }}%</div>
      @endif
      </div>

      <div class="table-responsive">
        <table class="table card-table">
        <tbody class="table-border-bottom-0">
          <tr>
          <td class="w-50">
            <div class="d-flex justify-content-start align-items-center">
            <div class="me-2"><i class='ti ti-clock ti-lg text-heading'></i></div>
            <h6 class="mb-0 fw-normal">Dalam Proses</h6>
            </div>
          </td>
          <td class="text-end"><span>{{ round($peratusDalamProses) }}%</span></td>
          </tr>
          <tr class="bg-label-success">
          <td class="w-50">
            <div class="d-flex justify-content-start align-items-center">
            <div class="me-2"><i class='ti ti-circle-check ti-lg text-heading'></i></div>
            <h6 class="mb-0 fw-normal">Permohonan Berjaya</h6>
            </div>
          </td>
          <td class="text-end"><span>{{ round($peratusBerjaya) }}%</span></td>
          </tr>
          <tr class="bg-label-danger">
          <td class="w-50">
            <div class="d-flex justify-content-start align-items-center">
            <div class="me-2"><i class='ti ti-alert-circle ti-lg text-heading'></i></div>
            <h6 class="mb-0 fw-normal">Permohonan Tidak Berjaya</h6>
            </div>
          </td>
          <td class="text-end"><span>{{ round($peratusTidakBerjaya) }}%</span></td>
          </tr>
        </tbody>
        </table>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- /Statistik Permohonan -->

  </div>
@endsection