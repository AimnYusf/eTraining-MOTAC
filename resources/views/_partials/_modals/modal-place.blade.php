<!-- Place Modal -->
<div class="modal fade" id="manageRecord" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 id="tem_tajuk" class="mb-2">Edit User Information</h4>
          <hr>
        </div>
        <form id="courseLocationForm" class="row g-6">
          @csrf
          <input type="hidden" id="tem_id" name="tem_id">
          <div class="col-12">
            <label class="form-label" for="tem_keterangan">Nama Tempat</label>
            <input type="text" id="tem_keterangan" name="tem_keterangan" class="form-control"
              placeholder="Nama Tempat" />
          </div>
          <div class="col-12">
            <label class="form-label" for="tem_alamat">Alamat</label>
            <textarea id="tem_alamat" class="form-control" name="tem_alamat" placeholder="Alamat" rows="3"></textarea>
          </div>
          <div class="col-12">
            <label class="form-label" for="tem_gmaps">Google Maps Embed</label>
            <textarea id="tem_gmaps" class="form-control" name="tem_gmaps" placeholder="Google Maps Embed"
              rows="3"></textarea>
          </div>
          <div class="col-12 text-center">
            <button type="reset" class="btn btn-label-secondary me-3" data-bs-dismiss="modal"
              aria-label="Close">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Place Modal -->