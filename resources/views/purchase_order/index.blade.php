@extends('adminlte::page')

@section('title', 'Purchase Order')

@section('content_header')
    <h3>Menu/Purchase Order</h1>
    @stop

    @section('content')
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPO">Tambah Purchase
                    Order</button>
            </div>
            <div class="card-body">
                <table id="purchase-order-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl PO</th>
                            <th>Tgl Delivery</th>
                            <th>No. PO</th>
                            <th>Jenis Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Tgl Beli</th>
                            <th>Status</th>
                            <th>Harga Beli</th>
                            <th>Harga Bongkar</th>
                            <th>Margin Keuntungan</th>
                            <th>Keuntungan (Owner)</th>
                            <th>Uang Masuk</th>
                            <th>Tgl Uang Masuk</th>
                            <th>Estimasi Hari</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrders as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_po)->format('d F Y') }}</td>
                                <td>
                                    {{ $item->tgl_delivery ? \Carbon\Carbon::parse($item->tgl_delivery)->format('d F Y') : '-' }}
                                </td>
                                <td>{{ $item->no_po }}</td>
                                <td>{{ $item->barang ? $item->barang->nama_barang : '-' }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>
                                    {{ $item->barang ? 'Rp. ' . number_format($item->barang->harga, 0, ',', '.') : '-' }}
                                    ({{ $item->barang ? Str::ucfirst($item->barang->satuan) : '-' }})
                                </td>
                                <td>{{ 'Rp. ' . number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    {{ $item->tgl_beli ? \Carbon\Carbon::parse($item->tgl_beli)->format('d F Y') : '-' }}
                                </td>
                                <td>
                                    @if (is_null($item->tgl_beli))
                                        <span class="badge badge-danger">Unpaid</span>
                                    @else
                                        <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                                @if (is_null($item->tgl_beli))
                                    <td>Rp. 0</td>
                                    <td>Rp. 0</td>
                                    <td>Rp. 0</td>
                                    <td>Rp. 0</td>
                                @else
                                    <td>{{ 'Rp. ' . number_format($item->harga_beli, 0, ',', '.') }}</td>
                                    <td>
                                        {{ $item->bongkar_muat ? 'Rp. ' . number_format($item->bongkar_muat->harga_bongkar, 0, ',', '.') : 'Rp. 0' }}
                                    </td>
                                    <td>
                                        {{ 'Rp. ' . number_format($item->jumlah - $item->harga_beli - ($item->bongkar_muat ? $item->bongkar_muat->harga_bongkar : 0), 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @php
                                            $harga_bongkar = $item->bongkar_muat
                                                ? $item->bongkar_muat->harga_bongkar
                                                : 0;
                                            $margin = $item->jumlah - $item->harga_beli - $harga_bongkar;
                                            $persen = $item->persentase_keuntungan
                                                ? $item->persentase_keuntungan->besaran_persen
                                                : 0;
                                            $keuntungan_owner = ($margin * $persen) / 100;
                                        @endphp
                                        {{ 'Rp. ' . number_format($keuntungan_owner, 0, ',', '.') }}
                                        ({{ $persen }}%)
                                    </td>
                                @endif
                                <td>{{ 'Rp. ' . number_format($item->uang_masuk, 0, ',', '.') }}</td>
                                <td>
                                    {{ $item->tgl_uang_masuk ? \Carbon\Carbon::parse($item->tgl_uang_masuk)->format('d F Y') : '-' }}
                                </td>
                                <td>{{ $item->estimasi_hari_pembayaran ? $item->estimasi_hari_pembayaran->periode_waktu : '-' }}
                                    Hari</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 4px;">
                                        <button class="btn btn-sm btn-warning" title="Edit" data-id="{{ $item->id }}"
                                            data-toggle="modal" data-target="#modalEditPO">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" title="Form Beli" data-id="{{ $item->id }}"
                                            data-toggle="modal" data-target="#modalFormBeli">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        @if ($item->tgl_delivery != null)
                                            <button class="btn btn-sm btn-success" title="Uang Masuk"
                                                data-id="{{ $item->id }}" data-toggle="modal"
                                                data-target="#modalFormUangMasuk">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </button>
                                        @endif
                                        <form action="{{ route('purchase_order.destroy', $item->id) }}" method="POST"
                                            style="margin:0;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('purchase_order.modal-add')
        @include('purchase_order.modal-edit')
        @include('purchase_order.modal-form-beli')
        @include('purchase_order.modal-form-uang-masuk')
    @stop

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Set barang_id ke input hidden saat tombol diklik
            $(document).on('click', '[data-target="#modalFormBeli"]', function() {
                let purchaseOrderId = $(this).data('id');
                $('#purchase_order_id').val(purchaseOrderId);
            });

            $(document).on('click', '[data-target="#modalFormUangMasuk"]', function() {
                let purchaseOrderId = $(this).data('id');
                $('#purchase_order_id_uang_masuk').val(purchaseOrderId);
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#purchase-order-table').DataTable({
                    responsive: true,
                    pageLength: 20,
                    lengthChange: false,
                    searching: true
                });
            });
        </script>
        @if (session('success'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            </script>
        @endif
    @stop
