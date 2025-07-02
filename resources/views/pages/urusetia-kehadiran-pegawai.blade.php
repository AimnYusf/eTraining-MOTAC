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
'resources/assets/js/urusetia-kehadiran-pegawai.js'
])
@endsection

@section('content')
<!-- Attendance List Table -->
<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between">
      <h5 class="card-title text-uppercase">{{ $kursus->kur_nama }}</h5>
      <input type="hidden" id="kur_id" value="{{ $kursus->kur_id }}">
      <input type="hidden" id="kur_tkhmula" value="{{ $kursus->kur_tkhmula }}">
      <input type="hidden" id="kur_tkhtamat" value="{{ $kursus->kur_tkhtamat }}">
    </div>
    <div class="">
      <form id="kehadiranForm">
        @csrf
        <input type="number" id="keh_idusers" name="keh_idusers" placeholder="ID">
        <input type="text" id="keh_idkursus" name="keh_idkursus" value="{{ $kursus->kur_id }}" readonly>
        <input type="text" id="keh_tkhmasuk" name="keh_tkhmasuk" placeholder="Tarikh">
        <button type="button" id="submit-form">Submit</button>
      </form>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables table table-hover">
      <thead class="border-top table-dark">
        <tr>
          <th>#</th>
          <th>NAMA PEGAWAI</th>
          @php
          $startDate = new DateTime($kursus->kur_tkhmula);
          $endDate = new DateTime($kursus->kur_tkhtamat);
          $endDate->modify('+1 day');

          for ($date = $startDate; $date < $endDate; $date->modify('+1 day')) {
            echo '<th class="text-center"></th>';
            }
            @endphp
        </tr>
      </thead>
    </table>
  </div>
</div>
<!--/ Attendance List Table -->

<script>
  $('#submit-form').on('click', function() {
    const formData = $('#kehadiranForm').serialize();
    $.ajax({
      data: formData,
      url: 'kehadiran',
      type: 'POST',
    });
  })
</script>
@endsection