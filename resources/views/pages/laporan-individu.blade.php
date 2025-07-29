@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  ])
  {{-- Styles for printing --}}
  <style>
    @media print {

    /* Hide the filter form and print button when printing */
    .no-print {
      display: none !important;
    }

    /* Make cards look clean on print */
    .card {
      border: none !important;
      box-shadow: none !important;
      margin-bottom: 1.5rem !important;
    }

    /* Style the table for printing */
    table {
      width: 100% !important;
      /* Make table fit page width */
      table-layout: fixed !important;
      /* Helps columns fit */
      border-collapse: collapse !important;
      margin-bottom: 0.5rem !important;
    }

    /* Style table cells for printing */
    th,
    td {
      border: 1px solid #ddd !important;
      padding: 4px 6px !important;
      font-size: 9pt !important;
      /* Smaller text for more content */
      word-wrap: break-word !important;
      /* Break long words */
      overflow-wrap: break-word !important;
    }

    /* Adjust column widths for better fit on print */
    table th:nth-child(1),
    table td:nth-child(1) {
      width: 30% !important;
    }

    /* Kursus */
    table th:nth-child(2),
    table td:nth-child(2),
    /* T/Mula */
    table th:nth-child(3),
    table td:nth-child(3) {
      width: 12% !important;
    }

    /* T/Tamat */
    table th:nth-child(4),
    table td:nth-child(4) {
      width: 15% !important;
    }

    /* Tempat */
    table th:nth-child(5),
    table td:nth-child(5) {
      width: 15% !important;
    }

    /* Anjuran */
    table th:nth-child(6),
    table td:nth-child(6),
    /* Hari */
    table th:nth-child(7),
    table td:nth-child(7),
    /* Jam */
    table th:nth-child(8),
    table td:nth-child(8) {
      width: 8% !important;
    }

    /* Jumlah */

    /* Keep table parts and cards from splitting across pages badly */
    table,
    .card-body {
      page-break-inside: avoid;
    }
    }
  </style>
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
  <div class="card mb-8">

    <div class="card-header d-flex flex-wrap justify-content-between gap-4">
    <div class="card-title mb-0 me-1 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 flex-grow-1">Rekod Individu</h5>
    </div>
    {{-- Print Button --}}
    <div class="d-flex align-items-center no-print">
      <button type="button" class="btn bg-label-primary" onclick="window.print()">
      <i class="ti ti-printer me-1"></i> Cetak
      </button>
    </div>
    </div>
    <div class="card-body">
    <form method="GET" class="mb-4 no-print">
      <div class="d-flex align-items-center">

      {{-- Select Tahun --}}
      <select name="tahun" class="selectpicker w-25" data-style="btn-default" onchange="this.form.submit()">
        @foreach(range(2024, now()->year) as $year)
      <option value="{{ $year }}" {{ request('tahun', now()->year) == $year ? 'selected' : '' }}>
      {{ $year }}
      </option>
      @endforeach
      </select>

      {{-- Select Bahagian --}}
      <select class="selectpicker w-75 ms-3" name="bahagian" data-style="btn-default" onchange="this.form.submit()">
        @foreach ($bahagian as $item)
      <option value="{{ $item->bah_id }}" {{ request('bahagian', $pengguna->pen_idbahagian) == $item->bah_id ? 'selected' : '' }}>
      {{ $item->bah_ketpenu }}
      </option>
      @endforeach
      </select>

      </div>
    </form>
    </div>
  </div>
  @foreach($rekodIndividu as $userId => $attendances)
    <div class="card mb-8">

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
      $bilangan_hari = (float) ($row['bilangan_hari'] ?? 0);
      $bilangan_jam = (float) ($row['bilangan_jam'] ?? 0);
      $jumlah += $bilangan_hari + $bilangan_jam;

      $decimal = $jumlah - floor($jumlah);
      if ($decimal >= 0.6) {
      $jumlah = $jumlah + 0.4;
      }
      @endphp
      @if ($row['nama_kursus'] != null)
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
      @endif
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
@endsection