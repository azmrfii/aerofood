<!-- Modal Edit Purchase Order -->
<div class="modal fade" id="modalEditPO" tabindex="-1" role="dialog" aria-labelledby="editPOLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditPO" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editPOLabel">Edit Purchase Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal PO</label>
                                    <input type="date" name="tgl_po" id="edit_tgl_po" class="form-control"
                                        max="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Delivery</label>
                                    <input type="date" name="tgl_delivery" id="edit_tgl_delivery"
                                        class="form-control" max="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. PO</label>
                                    <input type="text" name="no_po" id="edit_no_po" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Barang</label>
                                    <select name="barang_id" id="edit_barang_id" class="form-control" required>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}">
                                                {{ $barang->nama_barang }} (Rp.
                                                {{ number_format($barang->harga, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" name="qty" id="edit_qty" class="form-control"
                                        min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah" id="edit_jumlah" class="form-control" readonly
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Persentase Keuntungan</label>
                                    <select name="persentase_keuntungan_id" id="edit_persentase_keuntungan_id"
                                        class="form-control" required>
                                        @foreach ($persentaseKeuntungans as $persentase)
                                            <option value="{{ $persentase->id }}">{{ $persentase->besaran_persen }}%
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estimasi Hari Pembayaran</label>
                                    <select name="estimasi_hari_pembayaran_id" id="edit_estimasi_hari_pembayaran_id"
                                        class="form-control" required>
                                        @foreach ($estimasiHariPembayarans as $estimasiHari)
                                            <option value="{{ $estimasiHari->id }}">{{ $estimasiHari->periode_waktu }}
                                                Hari</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('edit_barang_id');
        const qtyInput = document.getElementById('edit_qty');
        const jumlahInput = document.getElementById('edit_jumlah');

        function updateJumlah() {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const qty = parseFloat(qtyInput.value) || 0;
            jumlahInput.value = harga * qty;
        }

        barangSelect.addEventListener('change', updateJumlah);
        qtyInput.addEventListener('input', updateJumlah);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit-po');
        const form = document.getElementById('formEditPO');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                form.action = "{{ route('purchase_order.update', ':id') }}".replace(':id', id);

                // isi input
                document.getElementById('edit_tgl_po').value = this.getAttribute('data-tgl_po');
                document.getElementById('edit_tgl_delivery').value = this.getAttribute(
                    'data-tgl_delivery');
                document.getElementById('edit_no_po').value = this.getAttribute('data-no_po');
                document.getElementById('edit_barang_id').value = this.getAttribute(
                    'data-barang_id');
                document.getElementById('edit_qty').value = this.getAttribute('data-qty');
                document.getElementById('edit_jumlah').value = this.getAttribute('data-jumlah');
                document.getElementById('edit_persentase_keuntungan_id').value = this
                    .getAttribute('data-persentase_keuntungan_id');
                document.getElementById('edit_estimasi_hari_pembayaran_id').value = this
                    .getAttribute('data-estimasi_hari_pembayaran_id');
            });
        });
    });
</script>
