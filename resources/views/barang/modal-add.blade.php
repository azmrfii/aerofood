<!-- Modal Tambah Barang -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="tambahBarangLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahBarangLabel">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" required>
          </div>
          <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga Barang" required>
          </div>
          <div class="form-group">
            <label>Satuan</label>
            <select name="satuan" class="form-control" required>
              <option value="kg">Kg</option>
              <option value="pcs">Pcs</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
