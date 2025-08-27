<!-- Modal Edit Barang -->
@foreach($barangs as $barang)
<div class="modal fade" id="modalEditBarang{{ $barang->id }}" tabindex="-1" role="dialog" aria-labelledby="editBarangLabel{{ $barang->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editBarangLabel{{ $barang->id }}">Edit Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
          </div>
          <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $barang->harga }}" required>
          </div>
          <div class="form-group">
            <label>Satuan</label>
            <select name="satuan" class="form-control" required>
              <option value="kg" {{ $barang->satuan == 'kg' ? 'selected' : '' }}>Kg</option>
              <option value="pcs" {{ $barang->satuan == 'pcs' ? 'selected' : '' }}>Pcs</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
