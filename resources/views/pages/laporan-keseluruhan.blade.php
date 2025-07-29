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

  <div class="card-header">
    <div class="card-title mb-0 me-1">
      <div class="d-flex justify-content-between align-items-center w-100">
        <h5 class="mb-0">Rekod Keseluruhan</h5>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-label-primary waves-effect waves-light" id="excelButton">
            <i class="ti ti-file-spreadsheet me-1"></i> Excel
          </button>
          <button type="button" class="btn btn-icon btn-label-primary waves-effect waves-light" id="printButton" data-bs-toggle="tooltip" data-placement="top" title="Cetak">
            <i class="ti ti-printer"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="card-body">
    <form method="GET" class="mb-4">
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
        <select class="selectpicker w-75 ms-3" name="bahagian" data-style="btn-default"
          onchange="this.form.submit()">
          @foreach ($bahagian as $item)
          <option value="{{ $item->bah_id }}" {{ request('bahagian', $pengguna->pen_idbahagian) == $item->bah_id ? 'selected' : '' }}>
            {{ $item->bah_ketpenu }}
          </option>
          @endforeach
        </select>
      </div>
    </form>

    <hr>

    <!-- Dinamic Table -->
    <table id="datatables" class="table table-bordered mb-4">
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
        @foreach ($rekodKeseluruhan as $index => $rekod)
        <tr>
          <td class="align-top text-center ">{{ $index + 1 }}</td> {{-- DataTables handles numbering, but keeping for initial render --}}
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
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<!--/ Record List -->

@endsection

@section('page-script')
<script>
  $(document).ready(function() {
    // Initialize DataTables
    var table = $('#datatables').DataTable({
      dom:
        '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"f>>' +
        '<"table-responsive"t>' ,
      responsive: true,
      // Disable default DataTables buttons as we are using custom ones
      buttons: [
        {
          extend: 'print',
          text: '<i class="ti ti-printer me-1"></i>Print',
          className: 'd-none', // Hide this button, we will trigger it via custom button
          title: '<h4 class="text-uppercase fw-bold" style="text-align: center;">Rekod Keseluruhan</h4>',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'excel',
          text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
          className: 'd-none', // Hide this button, we will trigger it via custom button
          exportOptions: {
            columns: ':visible'
          }
        }
      ],
      // Optional: Disable searching, ordering, and pagination if not needed
      searching: false,
      ordering: false,
      paging: false
    });

    // Trigger DataTables print button when custom print button is clicked
    $('#printButton').on('click', function() {
      table.button('.buttons-print').trigger();
    });

    // Trigger DataTables excel button when custom excel button is clicked
    $('#excelButton').on('click', function() {
      table.button('.buttons-excel').trigger();
    });
  });
</script>
@endsection
