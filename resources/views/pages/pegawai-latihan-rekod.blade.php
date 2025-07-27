@extends('layouts/layoutMaster')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/pegawai-latihan-rekod.js'
  ])
@endsection

@section('content')
  <!-- Record Table -->
  <div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title">Rekod Pegawai</h5>
    </div>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
      <tr>
        <th>#</th>
        <th>Nama Pegawai</th>
        <th>Jawatan</th>
        <th>Gred</th>
        <th>Kumpulan</th>
        <th>Jumlah Hari</th>
        <th>%5 Hari</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <!--/ Record Table -->

  <!-- Modal -->
  <div class="modal fade" id="viewRecord" tabindex="-1" role="dialog" aria-labelledby="viewRecordLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="viewRecordLabel">Maklumat Kursus</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="modalContent">
        <div class="card-header">
        <div class="row ps-2 mb-1">
          <div class="col-sm-2 d-flex justify-content-between fw-bold">Nama Pegawai<span>:</span></div>
          <div class="col-sm-10 text-uppercase" id="pen_nama"></div>
        </div>
        <div class="row ps-2 mb-1">
          <div class="col-sm-2 d-flex justify-content-between fw-bold">Jawatan<span>:</span></div>
          <div class="col-sm-10" id="pen_jawatan"></div>
        </div>
        <div class="row ps-2 mb-1">
          <div class="col-sm-2 d-flex justify-content-between fw-bold">Gred<span>:</span></div>
          <div class="col-sm-10" id="pen_gred"></div>
        </div>
        <div class="row ps-2 mb-1">
          <div class="col-sm-2 d-flex justify-content-between fw-bold">Kumpulan<span>:</span></div>
          <div class="col-sm-10" id="pen_kumpulan"></div>
        </div>
        </div>

        <div class="card-body">
        <table class="table table-bordered mb-4">
          <thead class="table-dark">
          <tr>
            <th class="text-center">Kursus</th>
            <th class="text-center">T/Mula</th>
            <th class="text-center">T/Tamat</th>
            <th class="text-center">Tempat</th>
            <th class="text-center">Anjuran</th>
            <th class="text-center">Hari</th>
            <th class="text-center">Jam</th>
            <th class="text-center">Jumlah</th>
          </tr>
          </thead>
          <tbody id="modalBody">
          </tbody>
          <tfoot>
          <tr>
            <th colspan="7" class="text-right fw-bold">Jumlah Keseluruhan:</th>
            <th class="text-center py-4" id="pen_jumlah"></th>
          </tr>
          </tfoot>
        </table>
        </div>
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
  </div>
  <!--/ Modal -->
@endsection