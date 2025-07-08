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
    'resources/assets/js/urusetia-permohonan.js'
  ])
@endsection

@section('content')
  <!-- Course List Table -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Senarai Permohonan</h5>
      <button type="button" class="btn btn-label-danger clear-filter d-none">
      <i class="ti ti-trash me-0 me-sm-1 ti-xs"></i>
      <span class="d-none d-sm-inline-block">Padam</span>
      </button>
    </div>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
      <tr>
        <th>#</th>
        <th>NAMA KURSUS</th>
        <th>TEMPAT</th>
        <th>TARIKH MULA</th>
        <th>TARIKH TAMAT</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <!--/ Course List Table -->

  @include('_partials/_modals/modal-course')

  <script>
    const baseKursusUrl = "{{ route('urusetia-permohonan') }}";

    function getUrl(id) {
    return `${baseKursusUrl}?kid=${id}`;
    }
  </script>
@endsection