<div class="modal fade" id="manageRecord" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title">TINDAKAN PENYELIA</h5>
      </div>

      <form id="approvalFrom">
        @csrf
        <div class="modal-body">
          <input type="hidden" id="isy_id" name="isy_id">

          <section class="mb-8">
            <div class="divider text-start">
              <h5 class="divider-text m-0">MAKLUMAT KURSUS</h5>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Nama Kursus<span>:</span></div>
              <div id="isy_nama" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Tarikh Kursus<span>:</span></div>
              <div id="isy_tarikh" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Tempat Kursus<span>:</span></div>
              <div id="isy_tempat" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Anjuran<span>:</span></div>
              <div id="isy_anjuran" class="col-sm-9"></div>
            </div>
          </section>

          <section class="mb-8">
            <div class="divider text-start">
              <h5 class="divider-text m-0">MAKLUMAT PEMOHON</h5>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Nama<span>:</span></div>
              <div id="pen_nama" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">No. MyKad (Baru)<span>:</span></div>
              <div id="pen_nokp" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Jawatan / Gred<span>:</span></div>
              <div id="pen_jawatan" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Agensi<span>:</span></div>
              <div id="pen_agensi" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">Bahagian<span>:</span></div>
              <div id="pen_bahagian" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">No. Telefon (P)<span>:</span></div>
              <div id="pen_notel" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">No. Telefon (HP)<span>:</span></div>
              <div id="pen_nohp" class="col-sm-9"></div>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between">E-Mel Rasmi<span>:</span></div>
              <div id="pen_emel" class="col-sm-9"></div>
            </div>
          </section>

          <section>
            <div class="divider text-start">
              <h5 class="divider-text m-0">TINDAKAN PENYELIA</h5>
            </div>
            <div class="row ps-2 mb-2">
              <div class="col-sm-3 d-flex justify-content-between align-items-center">Status<span>:</span></div>
              <div class="col-sm-9">
                <select id="isy_status" name="isy_status" class="form-select w-50" data-style="btn-default">
                  <option value="1">Baru</option>
                  <option value="4">Berjaya</option>
                  <option value="5">Tidak Berjaya</option>
                </select>
              </div>
            </div>
          </section>
        </div>

        <div class="modal-footer justify-content-center">
          <button type="reset" class="btn btn-label-secondary me-2" data-bs-dismiss="modal"
            aria-label="Close">Batal</button>
          <button type="submit" class="btn btn-primary" aria-label="Close"><i
              class="ti ti-device-floppy me-2"></i>Kemaskini</button>
        </div>
      </form>
    </div>
  </div>
</div>