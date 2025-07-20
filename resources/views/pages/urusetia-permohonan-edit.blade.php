@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/flatpickr/flatpickr.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/urusetia-permohonan-edit.js'
  ])
@endsection

@section('content')
  <!-- Course List Table -->
  <div class="card">

    <div class="card-header">
    <div class="d-flex align-items-center">
      <a href="/urusetia/permohonan" class="btn btn-label-primary me-4" data-bs-toggle="tooltip" title="Kembali"><i
        class="ti ti-arrow-back-up"></i></a>
      <h5 class="card-title mb-0">{{ $kursus->kur_nama }}</h5>
      <input type="hidden" id="kur_id" value="{{ $kursus->kur_id }}">
    </div>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
      <tr>
        <th><input type="checkbox" id="selectAllCheckboxes" class="form-check-input"></th>
        <th>#</th>
        <th>NAMA PEMOHON</th>
        <th>JAWATAN</th>
        <th>AGENSI</th>
        <th>NO. KAD PENGENALAN</th>
        <th>EMEL</th>
        <th>TARIKH PERMOHONAN</th>
        <th>STATUS</th>
        <th>KELULUSAN</th>
      </tr>
      </thead>
    </table>
    </div>
    {{-- Add buttons to process selected items --}}
    <div class="card-footer d-flex justify-content-end gap-2">
    <button id="approveSelected" class="btn btn-success">Approve Selected</button>
    <button id="rejectSelected" class="btn btn-danger">Reject Selected</button>
    </div>
  </div>
  <!--/ Course List Table -->

  @include('_partials/_modals/modal-application')

@endsection