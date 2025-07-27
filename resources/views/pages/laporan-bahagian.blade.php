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
<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h5 class="card-title mb-0">Ringkasan Bahagian</h5>

      <div class="d-flex align-items-center gap-2 flex-wrap">
        {{-- Select Tahun --}}
        <form method="GET" class="mb-0">
          <select name="tahun" class="selectpicker" data-style="btn-default" onchange="this.form.submit()">
            @foreach(range(2024, now()->year) as $year)
              <option value="{{ $year }}" {{ request('tahun', now()->year) == $year ? 'selected' : '' }}>
                {{ $year }}
              </option>
            @endforeach
          </select>
        </form>

        {{-- Export Button --}}
        <div class="dropdown">
          <button type="button" class="btn btn-label-primary dropdown-toggle waves-effect waves-light border-none" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ti ti-file-export ti-xs me-sm-1"></i>
            <span class="d-none d-sm-inline-block">Eksport</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="javascript:void(0);" id="printButton">
                <i class="ti ti-printer me-1"></i> Cetak
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0);" id="excelButton">
                <i class="ti ti-file-spreadsheet me-1"></i> Excel
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table id="datatables" class="datatables table table-hover">
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
        $matched = collect($rekodBahagian)->firstWhere('bahagian', $data->bah_ketpenu);
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