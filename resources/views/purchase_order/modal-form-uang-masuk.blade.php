<!-- resources/views/barang/modal_form_beli.blade.php -->

<div class="modal fade" id="modalFormUangMasuk" tabindex="-1" role="dialog" aria-labelledby="formUangMasukLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase_order.uang_masuk') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="formUangMasukLabel">Form Uang Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="purchase_order_id" id="purchase_order_id_uang_masuk">
                    <div class="form-group">
                        <label for="uang_masuk">Uang Masuk</label>
                        <input type="number" name="uang_masuk" id="uang_masuk" class="form-control" min="0"
                            placeholder="1000" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_uang_masuk">Tanggal Uang Masuk</label>
                        <input type="date" name="tgl_uang_masuk" id="tgl_uang_masuk" class="form-control" required
                            value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <input type="text" name="note" id="note" class="form-control">
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
