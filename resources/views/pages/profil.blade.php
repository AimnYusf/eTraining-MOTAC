@extends('layouts/layoutMaster')

<!-- Vendor Styles -->
@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
  ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
  ])
@endsection

<!-- Page Scripts -->
@section('page-script')
  @vite(['resources/assets/js/profil.js'])
@endsection

@php
  use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
  <div class="row">
    <div class="col-12">
    <div class="card">
      <div class="card-body">
      <form id="formAuthentication">
        @csrf
        <div class="col-12">
        <h6>1. MAKLUMAT PERIBADI</h6>
        <hr class="mt-0" />
        </div>

        <div class="row mb-5">
        <label for="pen_nama" class="col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_nama" class="form-control" name="pen_nama" value="{{ Auth::user()->name }}"
          placeholder="Nama" readonly />
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_nokp" class="col-md-3 col-form-label">No. Kad Pengenalan <span
          class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_nokp" class="form-control" name="pen_nokp"
          value="{{ $pengguna->pen_nokp ?? ''}}" placeholder="No. Kad Pengenalan (Tanpa -)" />
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_jantina" class="col-md-3 col-form-label">Jantina <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <select id="pen_jantina" class="selectpicker w-100" name="pen_jantina" data-style="btn-default"
          title="Sila Pilih">
          <option value="1" {{ isset($pengguna) && $pengguna->pen_jantina == '1' ? 'selected' : '' }}>Lelaki
          </option>
          <option value="2" {{ isset($pengguna) && $pengguna->pen_jantina == '2' ? 'selected' : '' }}>Perempuan
          </option>
          </select>
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_emel" class="col-md-3 col-form-label">E-Mel <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_emel" class="form-control" name="pen_emel" value="{{ Auth::user()->email }}"
          placeholder="E-Mel" readonly />
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_notel" class="col-md-3 col-form-label">No. Telefon Pejabat <span
          class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_notel" class="form-control" name="pen_notel"
          value="{{ $pengguna->pen_notel ?? ''}}" placeholder="No. Telefon" />
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_nohp" class="col-md-3 col-form-label">No. Telefon Bimbit <span
          class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_nohp" class="form-control" name="pen_nohp"
          value="{{ $pengguna->pen_nohp ?? ''}}" placeholder="No. Telefon Bimbit" />
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_idbahagian" class="col-md-3 col-form-label">Bahagian <span
          class="text-danger">*</span></label>
        <div class="col-md-9">
          <select id="pen_idbahagian" class="selectpicker w-100" name="pen_idbahagian" data-style="btn-default"
          data-live-search="true" title="Sila Pilih">
          @foreach ($bahagian as $item)
        <option value="{{ $item->bah_id }}" {{ isset($pengguna->pen_idbahagian) && $pengguna->pen_idbahagian == $item->bah_id ? 'selected' : '' }}>{{ $item->bah_ketpenu }}</option>
      @endforeach
          </select>
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_jawatan" class="col-md-3 col-form-label">Jawatan <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_jawatan" class="form-control" name="pen_jawatan"
          value="{{ $pengguna->pen_jawatan ?? ''}}" placeholder="Jawatan" />
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_gred" class="col-md-3 col-form-label">Gred <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_gred" class="form-control" name="pen_gred"
          value="{{ $pengguna->pen_gred ?? ''}}" placeholder="Gred" />
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_idkumpulan" class="col-md-3 col-form-label">Kumpulan Pegawai <span
          class="text-danger">*</span></label>
        <div class="col-md-9">
          <select id="pen_idkumpulan" class="selectpicker w-100" name="pen_idkumpulan" data-style="btn-default"
          title="Sila Pilih">
          @foreach ($kumpulan as $item)
          @if ($item->kum_keterangan != 'Terbuka')
        <option value="{{ $item->kum_id }}" {{ isset($pengguna->pen_idkumpulan) && $pengguna->pen_idkumpulan == $item->kum_id ? 'selected' : '' }}>{{ $item->kum_keterangan }}</option>
        @endif
      @endforeach
          </select>
        </div>
        </div>
        <div class="row mb-5">
        <label for="pen_idjabatan" class="col-md-3 col-form-label">Kementerian <span
          class="text-danger">*</span></label>
        <div class="col-md-9">
          <select id="pen_idjabatan" class="selectpicker w-100" name="pen_idjabatan" data-style="btn-default"
          title="Sila Pilih">
          @foreach ($jabatan as $item)
        <option value="{{ $item->jab_id }}" {{ isset($pengguna->pen_idjabatan) && $pengguna->pen_idjabatan == $item->jab_id ? 'selected' : '' }}>{{ $item->jab_ketpenu }}</option>
      @endforeach
          </select>
        </div>
        </div>

        <div class="col-12">
        <h6 class="mt-10 mb-1">2. MAKLUMAT PEGAWAI PENYOKONG</h6>
        <label class="mb-4 text-danger small">
          <em>* Perhatian: Permohonan hendaklah <strong>DISOKONG oleh
            Pegawai sekurang-kurangnya Gred 9 dan ke atas SAHAJA.</strong></em>
        </label>
        <hr class="mt-0" />
        </div>

        <div class="row mb-5">
        <label for="pen_ppnama" class="col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_ppnama" class="form-control" name="pen_ppnama"
          value="{{ $pengguna->pen_ppnama ?? ''}}" placeholder="Nama Pegawai Penyelia" />
        </div>
        </div>

        <div class="row mb-5">
        <label for="pen_ppemel" class="col-md-3 col-form-label">E-Mel <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" id="pen_ppemel" class="form-control" name="pen_ppemel"
          value="{{ $pengguna->pen_ppemel ?? ''}}" placeholder="E-Mel Pegawai Penyelia" />
        </div>
        </div>

        @php
      $gredOptions = ['Turus III', 'Jusa A', 'Jusa B', 'Jusa C', '14', '13', '12', '10', '9'];
      $selectedGred = $pengguna->pen_ppgred ?? '';
    @endphp

        <div class="row mb-5">
        <label for="pen_ppgred" class="col-md-3 col-form-label">
          Gred <span class="text-danger">*</span>
        </label>
        <div class="col-md-9">
          <select id="pen_ppgred" class="selectpicker w-100" name="pen_ppgred" data-style="btn-default"
          title="Sila Pilih">
          @foreach ($gredOptions as $gred)
        <option value="{{ $gred }}" {{ $selectedGred == $gred ? 'selected' : '' }}>
        {{ $gred }}
        </option>
      @endforeach
          </select>
        </div>
        </div>

        <div class="pt-4">
        <div class="row justify-content-end">
          <div class="col-sm-9">
          <button type="submit" class="btn btn-primary me-2"><i
            class="ti ti-device-floppy me-1"></i>Kemaskini</button>
          <button type="button" class="btn btn-label-secondary"><i class="ti ti-lock-cog me-1"></i>Tukar Kata
            Laluan</button>
          </div>
        </div>
        </div>
      </form>
      </div>
    </div>
    </div>
  </div>
@endsection