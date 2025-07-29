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
    'resources/assets/js/pentadbir-latihan-pengesahan.js'
  ])
@endsection

@section('content')
  <!-- Course List Table -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Senarai Menunggu Pengesahan</h5>
    </div>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
      <tr>
        <th>#</th>
        <th>Nama Pemohon</th>
        <th>Nama Kursus</th>
        <th>Tarikh Mula</th>
        <th>Tarikh Tamat</th>
        <th>Status</th>
        <th>Pengesahan</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <!--/ Course List Table -->

  @include('_partials/_modals/modal-approval')

  <script>
    window.statusData = @json($status);
  </script>

@endsection