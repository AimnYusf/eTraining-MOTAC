@extends('layouts/layoutMaster')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',

])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
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
      <h5 class="mb-0">Rekod Individu</h5>
    </div>
  </div>
  <hr>
  <div class="card-body">
    <div id="no-data-message" class="text-center my-5">

      <form method="GET" class="mb-4">
        <div class="input-group" style="max-width: 400px;">
          <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
          <button type="submit" class="btn btn-primary">Cari</button>
        </div>
      </form>

      @foreach($groupedAttendance as $userId => $attendances)
      @php
      $penNama = $attendances->first()['pen_nama'];
      @endphp

      <h5>{{ $penNama }}</h5>
      <table class="table table-bordered mb-4">
        <thead>
          <tr>
            <th>Kursus</th>
            <th>Total Kehadiran</th>
            <th>Isytihar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($attendances as $row)
          <tr>
            <td>{{ $row['kursus'] ?? '-' }}</td>
            <td>{{ $row['total_kehadiran'] ?? '-' }}</td>
            <td>{{ $row['isytihar'] ?? '-' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endforeach


    </div>
  </div>
</div>
<!--/ Course List Table -->

@endsection