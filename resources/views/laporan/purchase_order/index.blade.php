@extends('adminlte::page')

@section('plugins.Sweetalert2', true)

@section('title', 'Laporan Purchase Order')

@section('content_header')
    <h3>Laporan/Purchase Order</h1>
    @stop

@section('js')
    <!-- DataTables & Buttons -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css"/>
    <script>
        $(document).ready(function() {
            var dtJatuhTempo = $('#table-jatuh-tempo table').DataTable({
                responsive: true,
                pageLength: 20,
                lengthChange: false,
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'PO Jatuh Tempo',
                        exportOptions: { columns: ':visible' }
                    }
                ]
            });
            var dtSudahBayar = $('#table-sudah-bayar table').DataTable({
                responsive: true,
                pageLength: 20,
                lengthChange: false,
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'PO Sudah Bayar',
                        exportOptions: { columns: ':visible' }
                    }
                ]
            });

            // Fix lebar kolom saat tab diaktifkan
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                if ($(e.target).attr('href') === '#sudah-bayar') {
                    dtSudahBayar.columns.adjust().responsive.recalc();
                }
                if ($(e.target).attr('href') === '#jatuh-tempo') {
                    dtJatuhTempo.columns.adjust().responsive.recalc();
                }
            });
        });
    </script>
@stop

    @section('content')
        <div class="card">
            <div class="card-header pb-0">
                <ul class="nav nav-tabs" id="poTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="jatuh-tempo-tab" data-toggle="tab" href="#jatuh-tempo" role="tab" aria-controls="jatuh-tempo" aria-selected="true">PO Jatuh Tempo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sudah-bayar-tab" data-toggle="tab" href="#sudah-bayar" role="tab" aria-controls="sudah-bayar" aria-selected="false">PO Sudah Bayar</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="poTabContent">
                    <div class="tab-pane fade show active" id="jatuh-tempo" role="tabpanel" aria-labelledby="jatuh-tempo-tab">
                        <!-- Tabel PO Jatuh Tempo -->
                        <div id="table-jatuh-tempo">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. PO</th>
                                            <th>Jenis Barang</th>
                                            <th>Tgl Delivery</th>
                                            <th>Estimasi Hari</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($poJatuhTempo as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->no_po }}</td>
                                                <td>{{ $item->barang ? $item->barang->nama_barang : '-' }}</td>
                                                <td>{{ $item->tgl_delivery ? \Carbon\Carbon::parse($item->tgl_delivery)->format('d F Y') : '-' }}</td>
                                                <td>{{ $item->estimasi_hari_pembayaran ? $item->estimasi_hari_pembayaran->periode_waktu : '-' }} hari</td>
                                                <td>
                                                    @php
                                                        $jatuhTempo = $item->tgl_delivery && $item->estimasi_hari_pembayaran ? \Carbon\Carbon::parse($item->tgl_delivery)->addDays($item->estimasi_hari_pembayaran->periode_waktu) : null;
                                                    @endphp
                                                    {{ $jatuhTempo ? $jatuhTempo->format('d F Y') : '-' }}
                                                </td>
                                                <td>{{ 'Rp. ' . number_format($item->jumlah, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sudah-bayar" role="tabpanel" aria-labelledby="sudah-bayar-tab">
                        <!-- Tabel PO Sudah Bayar -->
                        <div id="table-sudah-bayar">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. PO</th>
                                            <th>Jenis Barang</th>
                                            <th>Tgl Delivery</th>
                                            <th>Tgl Beli</th>
                                            <th>Jumlah</th>
                                            <th>Uang Masuk</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($poSudahBayar as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->no_po }}</td>
                                                <td>{{ $item->barang ? $item->barang->nama_barang : '-' }}</td>
                                                <td>{{ $item->tgl_delivery ? \Carbon\Carbon::parse($item->tgl_delivery)->format('d F Y') : '-' }}</td>
                                                <td>{{ $item->tgl_beli ? \Carbon\Carbon::parse($item->tgl_beli)->format('d F Y') : '-' }}</td>
                                                <td>{{ 'Rp. ' . number_format($item->jumlah, 0, ',', '.') }}</td>
                                                <td>{{ $item->uang_masuk ? 'Rp. ' . number_format($item->uang_masuk, 0, ',', '.') : '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
