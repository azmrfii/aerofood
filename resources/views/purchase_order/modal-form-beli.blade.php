<!-- resources/views/barang/modal_form_beli.blade.php -->

<div class="modal fade" id="modalFormBeli" tabindex="-1" role="dialog" aria-labelledby="formBeliLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase_order.form_beli') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="formBeliLabel">Form Beli</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="purchase_order_id" id="purchase_order_id">

                    <div class="form-group">
                        <label for="tgl_beli">Tanggal Beli</label>
                        <input type="date" name="tgl_beli" id="tgl_beli" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" min="0"
                            placeholder="1000" required>
                    </div>

                    <div class="form-group">
                        <label for="bongkar_id">Pilih Bongkar Muat</label>
                        <select name="bongkar_id" id="bongkar_id" class="form-control" required>
                            @foreach ($bongkarMuats as $bongkar)
                                <option value="{{ $bongkar->id }}">
                                    Rp {{ number_format($bongkar->harga_bongkar, 0, ',', '.') }}
                                </option>
                            @endforeach
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
