<!-- Modal Tambah Purchase Order -->
<div class="modal fade" id="modalTambahPO" tabindex="-1" role="dialog" aria-labelledby="tambahPOLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase_order.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPOLabel">Tambah Purchase Order</h5>
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
                                    <input type="date" name="tgl_po" class="form-control" required
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Delivery</label>
                                    <input type="date" name="tgl_delivery" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. PO</label>
                                    <input type="text" name="no_po" class="form-control" placeholder="123"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Barang</label>
                                    <select name="barang_id" id="barang_id" class="form-control" required>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}">
                                                {{ $barang->nama_barang }} (Rp.
                                                {{ number_format($barang->harga, 0, ',', '.') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" name="qty" id="qty" class="form-control"
                                        min="1" placeholder="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" readonly
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Persentase Keuntungan</label>
                                    <select name="persentase_keuntungan_id" id="persentase_keuntungan_id"
                                        class="form-control" required>
                                        @foreach ($persentaseKeuntungans as $persentase)
                                            <option value="{{ $persentase->id }}">
                                                {{ $persentase->besaran_persen }}%</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estimasi Hari Pembayaran</label>
                                    <select name="estimasi_hari_pembayaran_id" id="estimasi_hari_pembayaran_id"
                                        class="form-control" required>
                                        @foreach ($estimasiHariPembayarans as $estimasiHari)
                                            <option value="{{ $estimasiHari->id }}">
                                                {{ $estimasiHari->periode_waktu }} Hari</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('barang_id');
        const qtyInput = document.getElementById('qty');
        const jumlahInput = document.getElementById('jumlah');

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
