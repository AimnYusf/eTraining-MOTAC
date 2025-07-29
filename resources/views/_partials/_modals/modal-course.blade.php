@php
  use Illuminate\Support\Facades\Auth;
@endphp

<!-- Edit User Modal -->
<div class="modal fade" id="viewRecord" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <form id="courseForm">
        @csrf
        <input type="hidden" id="kur_id" class="mb-6" name="kur_id"></input>
      </form>
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-6 gap-2">
          <div class="me-1">
            <h5 id="kur_nama" class="mb-0 text-uppercase"></h5>
            <span id="kur_kategori" class="badge bg-label-warning"></span>
          </div>
        </div>
        <div class="card academy-content shadow-none border">
          <div class="card-body pt-4">
            <h5>Maklumat Terperinci</h5>
            <div class="row mb-2">
              <div class="col-sm-4">
                <i class="ti ti-calendar-event me-2 align-top"></i>
                <span>Tarikh</span>
              </div>
              <div class="col-sm-8">
                <span id="kur_tarikh"></span>
              </div>
            </div>

            <!-- Dinamic input -->
            <div class="row mb-2">
              <div class="col-sm-4">
                <i class="ti ti-map-pin me-2 align-top"></i>
                <span>Tempat</span>
              </div>
              <div class="col-sm-8">
                <span id="kur_tempat"></span>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-sm-4">
                <i class="ti ti-users-group me-2 align-top"></i>
                <span>Bilangan Peserta</span>
              </div>
              <div class="col-sm-8">
                <span id="kur_bilpeserta"></span>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-sm-4">
                <i class="ti ti-user-check me-2 align-top"></i>
                <span>Kumpulan Sasaran</span>
              </div>
              <div class="col-sm-8">
                <span id="kur_kumpulan"></span>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-sm-4">
                <i class="ti ti-user-cog me-2 align-top"></i>
                <span>Urus Setia</span>
              </div>
              <div class="col-sm-8">
                <span id="kur_penganjur"></span>
              </div>
            </div>
            <!--/ Dinamic input -->

            <hr class="my-6">
            <h5>Objektif</h5>
            <p id="kur_objektif" class="mb-6"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer p-0">
        <div class="col-12 text-center">
          <div class="btn-apply-modal d-none">
            <button type="reset" class="btn btn-label-secondary me-2" data-bs-dismiss="modal" aria-label="Close"
              onclick="$('.btn-apply-modal').addClass('d-none')">Batal</button>
            <button type="button" class="btn btn-primary apply-record" aria-label="Close">Mohon</button>
          </div>
          <div class="btn-close-modal d-none">
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"
              onclick="$('.btn-close-modal').addClass('d-none')">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--/ Edit User Modal -->