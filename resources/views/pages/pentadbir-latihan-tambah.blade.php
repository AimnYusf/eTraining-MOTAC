@extends('layouts/layoutMaster')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
])
@endsection

@section('page-script')
@vite([
'resources/assets/js/pentadbir-latihan-tambah.js'
])
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <form id="formAddRecord">
          @csrf
          <div class="col-12">
            <h5>Tambah Rekod Pegawai</h5>
            <hr class="mt-0" />
          </div>

          <div class="row mb-5">
            <label for="isy_idusers" class="col-md-3 col-form-label">Nama Pegawai <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <select id="isy_idusers" class="selectpicker w-100" name="isy_idusers" data-style="btn-default" data-live-search="true"
                title="Sila Pilih">
                @foreach ($pengguna as $data)
                <option value="{{ $data->pen_idusers }}">{{ $data->pen_nama }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-5">
            <label for="isy_nama" class="col-md-3 col-form-label">Nama Kursus <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="text" id="isy_nama" class="form-control" name="isy_nama"
                placeholder="Nama Kursus">
            </div>
          </div>

          <div class="row">
            <label class="col-md-3 col-form-label">Tarikh Mula / Tamat <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <div class="row g-2">
                <div class="col mb-5">
                  <input type="text" id="isy_tkhmula" class="form-control" name="isy_tkhmula"
                    placeholder="DD/MM/YYYY" />
                </div>
                <div class="col mb-5">
                  <input type="text" id="isy_tkhtamat" class="form-control" name="isy_tkhtamat"
                    placeholder="DD/MM/YYYY" />
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-5">
            <label for="isy_jam" class="col-md-3 col-form-label">Jumlah Jam <br><span class="small"><em>(Jika kursus tidak lebih 1 hari)</em></span></label>
            <div class="col-md-9">
              <input type="number" id="isy_jam" class="form-control" name="isy_jam"
                placeholder="Jumlah Jam">
            </div>
          </div>

          <div class="row mb-5">
            <label for="isy_tempat" class="col-md-3 col-form-label">Tempat <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="text" id="isy_tempat" class="form-control" name="isy_tempat"
                placeholder="Tempat">
            </div>
          </div>

          <div class="row mb-5">
            <label for="isy_anjuran" class="col-md-3 col-form-label">Anjuran <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="text" id="isy_anjuran" class="form-control" name="isy_anjuran"
                placeholder="Anjuran">
            </div>
          </div>

          <div class="pt-4">
            <div class="row justify-content-end">
              <div class="col-sm-9">
                <button type="submit" class="btn btn-primary me-2"><i
                    class="ti ti-device-floppy me-1"></i>Simpan</button>
                <a href="{{ route('urusetia-kursus') }}" class="btn btn-label-secondary"></i>Kembali</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection