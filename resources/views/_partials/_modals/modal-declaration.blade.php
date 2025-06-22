<!-- Manage Modal -->
<div class="modal fade" id="manageRecord" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center mb-6">
          <h4 id="isy_tajuk" class="mb-2">Tajuk</h4>
          <hr>
        </div>
        <form id="courseForm" class="row g-6">
          @csrf
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
          <div class="col-12 validate">
            <label class="form-label" for="isy_kos">Kos (RM)</label>
            <input type="number" id="isy_kos" class="form-control" name="isy_kos" placeholder="Kos (RM)" />
          </div>
          <div class="col-12 text-center validate">
            <button type="reset" class="close-btn btn btn-label-secondary me-3" data-bs-dismiss="modal"
              aria-label="Close">Batal</button>
            <button type="submit" class="submit-btn btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/Manage Modal -->