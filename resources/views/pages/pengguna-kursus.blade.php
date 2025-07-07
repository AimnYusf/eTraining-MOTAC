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
    'resources/assets/js/pengguna-kursus.js'
  ])
@endsection

@section('content')
  <!-- Course List Table -->
  <div class="card">

    <div class="card-header d-flex flex-wrap justify-content-between gap-4">
    <div class="card-title mb-0 me-1">
      <h5 class="mb-0">Katalog Kursus</h5>
      <p class="mb-0">Ilmu Baharu, Peluang Baharu!</p>
    </div>
    </div>
    <div class="card-body">
    <div id="no-data-message" class="text-center my-5" style="display: none;">
      <div class="alert alert-warning" role="alert">
      Tiada kursus tersedia buat masa ini.
      </div>
    </div>
    <div class="course-table">
      <table class="data-list table table-striped">
      <tbody class="row row-cols-3">
        <!-- DataTable rows will be populated here -->
      </tbody>
      </table>
    </div>

    </div>
  </div>
  <!--/ Course List Table -->

  @include('_partials/_modals/modal-course')

@endsection