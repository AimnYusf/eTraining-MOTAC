<!-- Manage Modal -->
<div class="modal fade" id="manageRecord" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center mb-6">
          <h4 id="isy_tajuk" class="mb-2">Tajuk</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

          <hr>
        </div>
        <form id="courseForm" class="row g-6">
          @csrf
          <input type="hidden" id="isy_id" name="isy_id" />
          <div class="col-12 validate">
            <label class="form-label" for="tem_keterangan">Nama Kursus</label>
            <input type="text" id="isy_nama" class="form-control" name="isy_nama" placeholder="Nama Kursus" />
          </div>
          <div class="col-6 validate">
            <label class="form-label" for="isy_tkhmula">Tarikh Mula</label>
            <input type="text" id="isy_tkhmula" class="form-control" name="isy_tkhmula" placeholder="DD/MM/YYYY" />
          </div>
          <div class="col-6 validate">
            <label class="form-label" for="isy_tkhtamat">Tarikh Tamat</label>
            <input type="text" id="isy_tkhtamat" class="form-control" name="isy_tkhtamat" placeholder="DD/MM/YYYY" />
          </div>
          <div class="col-12">
            <label class="form-label" for="isy_jam">Jumlah Jam (Jika kursus tidak lebih 1 hari)</label>
            <input type="number" id="isy_jam" class="form-control" name="isy_jam" placeholder="Jumlah Jam" />
          </div>
          <div class="col-12 validate">
            <label class="form-label" for="isy_tempat">Tempat</label>
            <input type="text" id="isy_tempat" class="form-control" name="isy_tempat" placeholder="Tempat" />
          </div>
          <div class="col-12 validate">
            <label class="form-label" for="isy_anjuran">Anjuran</label>
            <input type="text" id="isy_anjuran" class="form-control" name="isy_anjuran" placeholder="Anjuran" />
          </div>
          <div id="message">
            <div class="alert alert-info small" role="alert">
              <strong>Perhatian</strong>
              <ol>
                <li>Pegawai dikehendaki mendapatkan pengesahan penyelia salinan sijil/dokumen
                  kursus/bengkel/seminar/taklimat yang telah dihadiri; dan</li>
                <li>Sijil/dokumen yang telah disahkan penyelia diserahkan kepada Pentadbir Latihan Bahagian
                  masing-masing untuk tujuan pengesahan di dalam sistem eTraining</li>
              </ol>
            </div>
          </div>
          <div class="col-12 text-center validate">
            <button type="reset" class="close-btn btn btn-label-secondary" data-bs-dismiss="modal"
              aria-label="Close">Tutup</button>
            <div class="submit-btn">
              <button type="submit" class="btn btn-label-primary me-3" name="isy_status" value="6"><i
                  class="ti ti-device-floppy me-1"></i>Simpan</button>
              <button type="submit" class="btn btn-primary" name="isy_status" value="7">Hantar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/Manage Modal -->