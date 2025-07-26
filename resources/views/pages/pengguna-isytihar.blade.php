@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/flatpickr/flatpickr.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/pengguna-isytihar.js'
  ])
@endsection

@section('content')
  <!-- Course List Table -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Isytihar Kursus</h5>
    </div>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
      <tr>
        <th>#</th>
        <th>NAMA KURSUS</th>
        <th>TARIKH MULA</th>
        <th>TARIKH TAMAT</th>
        <th style="width:15%">Status</th>
        <th>AKTIVITI</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <!--/ Course List Table -->
  @include('_partials/_modals/modal-declaration')
    <script>
    window.statusData = @json($status);
    </script>

@endsection