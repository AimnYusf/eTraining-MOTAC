@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/flatpickr/flatpickr.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/tetapan-kategori.js'
  ])
@endsection

@section('content')
  <!-- List Table -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Senarai Kategori</h5>
    </div>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
      <tr>
        <th>#</th>
        <th>Kategori</th>
        <th>Aktiviti</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <!--/ List Table -->

  <!-- Modal -->
  <div class="modal fade" id="crudModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
      <div class="text-center mb-6">
        <h4 id="kat_tajuk" class="mb-2"></h4>
        <hr>
      </div>
      <form id="crudForm" class="row g-6">
        @csrf
        <input type="hidden" id="kat_id" name="kat_id">
        <div class="col-12">
        <label class="form-label" for="kat_keterangan">Kategori</label>
        <input type="text" id="kat_keterangan" name="kat_keterangan" class="form-control" placeholder="Kategori" />
        </div>
        <div class="col-12 text-center">
        <button type="reset" class="btn btn-label-secondary me-3" data-bs-dismiss="modal"
          aria-label="Close">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
      </div>
    </div>
    </div>
  </div>
  <!--/ Modal -->
@endsection