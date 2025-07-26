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
    'resources/assets/js/tetapan-jabatan.js'
  ])
@endsection

@section('content')
  <!-- List Table -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Senarai Jabatan</h5>
    </div>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
      <tr>
        <th>#</th>
        <th>Nama Jabatan</th>
        <th>Ringkasan</th>
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
        <h4 id="jab_tajuk" class="mb-2"></h4>
        <hr>
      </div>
      <form id="crudForm" class="row g-6">
        @csrf
        <input type="hidden" id="jab_id" name="jab_id">
        <div class="col-12">
        <label class="form-label" for="jab_ketpenu">Nama Jabatan</label>
        <input type="text" id="jab_ketpenu" name="jab_ketpenu" class="form-control" placeholder="Nama Jabatan" />
        </div>
        <div class="col-12">
        <label class="form-label" for="jab_ketring">Ringkasan</label>
        <input type="text" id="jab_ketring" name="jab_ketring" class="form-control" placeholder="Ringkasan" />
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