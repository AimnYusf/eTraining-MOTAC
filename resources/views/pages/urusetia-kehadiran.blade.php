@extends('layouts/layoutMaster')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
])
@endsection

@section('page-script')
@vite([
'resources/assets/js/urusetia-kehadiran.js'
])
@endsection

@section('content')
<!-- Attendance List Table -->
<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Senarai Kehadiran</h5>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
        <tr>
          <th>#</th>
          <th>NAMA KURSUS</th>
          <th style="width:15%">KATEGORI</th>
          <th>TARIKH MULA</th>
          <th>TARIKH TAMAT</th>
          <th>AKTIVITI</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<!--/ Attendance List Table -->
@endsection