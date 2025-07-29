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
@endsection