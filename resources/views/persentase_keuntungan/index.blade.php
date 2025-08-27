@extends('adminlte::page')

@section('title', 'Persentase Keuntungan')

@section('content_header')
    <h3>Menu/Persentase Keuntungan</h1>
    @stop

    @section('content')
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPersentaseKeuntungan">Tambah
                    Persentase Keuntungan</button>
            </div>
            <div class="card-body">
                <table id="persetanse-keuntungan-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Besaran Persen (Kita)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($besaranPersen as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->besaran_persen }}%</td>
                                <td>
                                    <div style="display: flex; gap: 4px; align-items: center;">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditPersentaseKeuntungan{{ $item->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('persentase_keuntungan.destroy', $item->id) }}"
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
                            <div class="modal fade" id="modalEditPersentaseKeuntungan{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editPersentaseKeuntunganLabel{{ $item->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('persentase_keuntungan.update', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editPersentaseKeuntunganLabel{{ $item->id }}">Edit Persentase
                                                    Keuntungan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Besaran Persen</label>
                                                    <input type="number" name="besaran_persen" class="form-control"
                                                        value="{{ $item->besaran_persen }}" placeholder="20" required>
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
        <div class="modal fade" id="modalTambahPersentaseKeuntungan" tabindex="-1" role="dialog"
            aria-labelledby="tambahPersentaseKeuntunganLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('persentase_keuntungan.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPersentaseKeuntunganLabel">Tambah Persentase Keuntungan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Besaran Persen</label>
                                <input type="number" name="besaran_persen" class="form-control" placeholder="20" required>
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
                $('#persetanse-keuntungan-table').DataTable({
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
