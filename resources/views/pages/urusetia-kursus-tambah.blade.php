@extends('layouts/layoutMaster')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/quill/typography.scss',
'resources/assets/vendor/libs/quill/katex.scss',
'resources/assets/vendor/libs/quill/editor.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
'resources/assets/vendor/libs/jquery-timepicker/jquery-timepicker.scss',
'resources/assets/vendor/libs/dropzone/dropzone.scss',
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/quill/katex.js',
'resources/assets/vendor/libs/quill/quill.js',
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
'resources/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js',
'resources/assets/vendor/libs/dropzone/dropzone.js',
])
@endsection

@section('page-script')
@vite([
'resources/assets/js/urusetia-kursus-tambah.js'
])
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <form id="formAuthentication">
          @csrf
          <input type="hidden" id="kur_id" name="kur_id" value="{{ $kursus->kur_id ?? '' }}">

          <div class="col-12">
            <h5>SENARAI KURSUS</h5>
            <hr class="mt-0" />
          </div>

          <div class="row mb-4">
            <label for="kur_nama" class="col-md-3 col-form-label">Nama Kursus <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="text" id="kur_nama" class="form-control" name="kur_nama"
                value="{{ $kursus->kur_nama ?? '' }}" placeholder="Nama Kursus">
            </div>
          </div>

          <div class="row mb-4">
            <label class="col-md-3 col-form-label">Objektif Kursus <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <div id="objektifError" class="alert alert-danger mb-2 m-0 d-none" role="alert">
                Sila masukkan objektif kursus.
              </div>
              <div class="form-control p-0">
                <div class="objektif-toolbar border-0 border-bottom">
                  <div class="d-flex justify-content-start">
                    <span class="ql-formats me-0">
                      <button class="ql-bold"></button>
                      <button class="ql-italic"></button>
                      <button class="ql-underline"></button>
                      <button class="ql-list" value="ordered"></button>
                      <button class="ql-list" value="bullet"></button>
                    </span>
                  </div>
                </div>
                <div id="kur_objektif" class="objektif-editor border-0 pb-6"></div>
                <input type="hidden" name="kur_objektif" id="kur_objektif_input"
                  value="{{ $kursus->kur_objektif ?? '' }}" />
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <label for="kur_poster" class="col-md-3 col-form-label">Poster Kursus <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="file" id="kur_poster" class="form-control" name="kur_poster" accept="image/png, image/jpeg">
            </div>
          </div>

          <div class="row mb-4">
            <label for="kur_idkategori" class="col-md-3 col-form-label">Kategori Kursus <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <select id="kur_idkategori" class="selectpicker w-100" name="kur_idkategori" data-style="btn-default"
                title="Sila Pilih">
                @foreach ($kategori as $data)
                <option value="{{ $data->kat_id }}" {{ isset($kursus) && $data->kat_id == $kursus->kur_idkategori ?
        'selected' : '' }}>
                  {{ $data->kat_keterangan }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <label class="col-md-3 col-form-label">Tarikh / Masa Mula <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <div class="row g-2">
                <div class="col mb-4">
                  <input type="text" id="kur_tkhmula" class="form-control" name="kur_tkhmula"
                    value="{{ isset($kursus->kur_tkhmula) ? \Carbon\Carbon::parse($kursus->kur_tkhmula)->format('d/m/Y') : '' }}" placeholder="DD/MM/YYYY" />
                </div>
                <div class="col mb-4">
                  <input type="text" id="kur_msamula" class="form-control" name="kur_msamula" placeholder="HH:MMam"
                    value="{{ $kursus->kur_msamula ?? '' }}" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <label class="col-md-3 col-form-label">Tarikh / Masa Tamat <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <div class="row g-2">
                <div class="col mb-4">
                  <input type="text" id="kur_tkhtamat" class="form-control" name="kur_tkhtamat" placeholder="DD/MM/YYYY"
                    value="{{ isset($kursus->kur_tkhtamat) ? \Carbon\Carbon::parse($kursus->kur_tkhtamat)->format('d/m/Y') : '' }}" />
                </div>
                <div class="col mb-4">
                  <input type="text" id="kur_msatamat" class="form-control" name="kur_msatamat" placeholder="HH:MMam"
                    value="{{ $kursus->kur_msatamat ?? '' }}" />
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <label for="pen_nama" class="col-md-3 col-form-label">Bilangan hari <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="number" id="kur_bilhari" class="form-control" name="kur_bilhari"
                value="{{ $kursus->kur_bilhari ?? '' }}" placeholder="Bilangan Hari">
            </div>
          </div>

          <div class="row mb-4">
            <label for="pen_nama" class="col-md-3 col-form-label">Tempat <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <select id="kur_idtempat" class="selectpicker w-100" name="kur_idtempat" data-style="btn-default"
                title="Sila Pilih">
                @foreach ($tempat as $data)
                <option value="{{ $data->tem_id }}" {{ isset($kursus) && $data->tem_id == $kursus->kur_idtempat ?
        'selected' : '' }}>
                  {{ $data->tem_keterangan }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-4">
            <label for="pen_nama_1" class="col-md-3 col-form-label">Tarikh Buka Permohonan <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="text" id="kur_tkhbuka" class="form-control" name="kur_tkhbuka"
                value="{{ isset($kursus->kur_tkhbuka) ? \Carbon\Carbon::parse($kursus->kur_tkhbuka)->format('d/m/Y') : '' }}" placeholder="DD/MM/YYYY" />
            </div>
          </div>

          <div class="row mb-4">
            <label for="pen_nama" class="col-md-3 col-form-label">Tarikh Tutup Permohonan <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="text" id="kur_tkhtutup" class="form-control" name="kur_tkhtutup"
                value="{{ isset($kursus->kur_tkhtutup) ? \Carbon\Carbon::parse($kursus->kur_tkhtutup)->format('d/m/Y') : '' }}" placeholder="DD/MM/YYYY" />
            </div>
          </div>

          <div class="row mb-4">
            <label for="pen_nama" class="col-md-3 col-form-label">Bilangan Peserta <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <input type="number" id="kur_bilpeserta" class="form-control" name="kur_bilpeserta"
                value="{{ $kursus->kur_bilpeserta ?? '' }}" placeholder="Bilangan Peserta">
            </div>
          </div>

          <div class="row mb-4">
            <label for="pen_nama" class="col-md-3 col-form-label">Kumpulan Sasaran <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <select id="kur_idkumpulan" name="kur_idkumpulan" class="selectpicker w-100" data-style="btn-default"
                title="Sila Pilih">
                @foreach ($kumpulan as $data)
                <option value="{{ $data->kum_id }}" {{ isset($kursus) && $data->kum_id == $kursus->kur_idkumpulan ?
        'selected' : '' }}>
                  {{ $data->kum_ketpenu }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-4">
            <label for="kur_idpenganjur" class="col-md-3 col-form-label">Penganjur <span class="text-danger">*</span></select></label>
            <div class="col-md-9">
              <select id="kur_idpenganjur" name="kur_idpenganjur" class="selectpicker w-100" data-style="btn-default"
                title="Sila Pilih">
                @foreach ($penganjur as $data)
                <option value="{{ $data->pjr_id }}" {{ isset($kursus) && $data->pjr_id == $kursus->kur_idpenganjur ?
        'selected' : '' }}>
                  {{ $data->pjr_keterangan }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          @php
          $selectedIds = $kursus->kur_urusetia ?? []; // Ensure it's an array
          @endphp

          <div class="row mb-4">
            <label for="kur_urusetia" class="col-md-3 col-form-label">Urus Setia</label>
            <div class="col-md-9">
              <select id="kur_urusetia" class="selectpicker w-100" name="kur_urusetia[]" data-style="btn-default" multiple data-icon-base="ti" data-tick-icon="ti-check text-white" title="Sila Pilih">
                @foreach ($urusetia as $data)
                <option value="{{ $data->pic_id }}" {{ in_array((string) $data->pic_id, array_map('strval', $selectedIds)) ? 'selected' : '' }}>
                  {{ $data->pic_nama }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-4">
            <label for="pen_nama" class="col-md-3 col-form-label">Status <span class="text-danger">*</span></label>
            <div class="col-md-9">
              <select id="kur_status" name="kur_status" class="selectpicker w-100" data-style="btn-default"
                title="Sila Pilih">
                <option value="1" {{($kursus->kur_status ?? '') == '1' ? 'selected' : '' }}>Aktif
                </option>
                <option value="0" {{($kursus->kur_status ?? '') == '0' ? 'selected' : '' }}>Tidak Aktif
                </option>
              </select>
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