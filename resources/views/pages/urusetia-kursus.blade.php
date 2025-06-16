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
    'resources/assets/js/urusetia-kursus.js'
  ])
@endsection

@section('content')
  <!-- Course List Table -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Senarai Kursus</h5>
      <button type="button" class="btn btn-label-danger clear-filter d-none">
      <i class="ti ti-trash me-0 me-sm-1 ti-xs"></i>
      <span class="d-none d-sm-inline-block">Padam</span>
      </button>
    </div>
    <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0">
      <div class="col-md-6 tarikh_kursus"></div>
      <div class="col-md-3 kategori_kursus"></div>
      <div class="col-md-3 status_kursus"></div>
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
        <th>STATUS</th>
        <th>AKTIVITI</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <!--/ Course List Table -->

  @include('_partials/_modals/modal-course')

@endsection