@extends('adminlte::page')

@section('title', 'Estimasi Hari Pembayaran')

@section('content_header')
    <h3>Menu/Estimasi Hari Pembayaran</h1>
    @stop

    @section('content')
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPeriodeWaktu">Tambah Periode
                    Hari</button>
            </div>
            <div class="card-body">
                <table id="estimasi-hari-keuntungan-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estimasiHari as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->periode_waktu }} hari</td>
                                <td>
                                    <div style="display: flex; gap: 4px; align-items: center;">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditPeriodeWaktu{{ $item->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('estimasi_hari_pembayaran.destroy', $item->id) }}"
                                            method="POST" style="display:inline-block; margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Edit Barang -->
                            <div class="modal fade" id="modalEditPeriodeWaktu{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editPeriodeWaktuLabel{{ $item->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('estimasi_hari_pembayaran.update', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPeriodeWaktuLabel{{ $item->id }}">Edit
                                                    Periode Waktu</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Estimasi Hari</label>
                                                    <input type="number" name="periode_waktu" min="1"
                                                        class="form-control" value="{{ $item->periode_waktu }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Tambah PersentaseKeuntungan -->
        <div class="modal fade" id="modalTambahPeriodeWaktu" tabindex="-1" role="dialog"
            aria-labelledby="tambahPeriodeWaktuLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('estimasi_hari_pembayaran.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPeriodeWaktuLabel">Tambah Periode Waktu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Estimasi Hari</label>
                                <input type="number" min="1" placeholder="1" name="periode_waktu"
                                    class="form-control" required>
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
    @stop

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                $('#estimasi-hari-keuntungan-table').DataTable({
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
