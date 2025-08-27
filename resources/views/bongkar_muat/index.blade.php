@extends('adminlte::page')

@section('title', 'Bongkar Muat')

@section('content_header')
    <h3>Menu/Bongkar Muat</h1>
    @stop

    @section('content')
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahHargaBongkar">Tambah Harga
                    Bongkar</button>
            </div>
            <div class="card-body">
                <table id="persetanse-keuntungan-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Harga Bongkar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bongkarMuat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Rp. {{ number_format($item->harga_bongkar, 0, ',', '.') }}</td>
                                <td>
                                    <div style="display: flex; gap: 4px; align-items: center;">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditHargaBongkar{{ $item->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('bongkar_muat.destroy', $item->id) }}" method="POST"
                                            style="display:inline-block; margin:0;">
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
                            <div class="modal fade" id="modalEditHargaBongkar{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editHargaBongkarLabel{{ $item->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('bongkar_muat.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editHargaBongkarLabel{{ $item->id }}">Edit
                                                    Harga Bongkar</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Harga Bongkar</label>
                                                    <input type="number" name="harga_bongkar" class="form-control"
                                                        value="{{ $item->harga_bongkar }}" placeholder="250000" required>
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
        <div class="modal fade" id="modalTambahHargaBongkar" tabindex="-1" role="dialog"
            aria-labelledby="tambahPersentaseKeuntunganLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('bongkar_muat.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPersentaseKeuntunganLabel">Tambah Persentase Keuntungan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Harga Bongkar</label>
                                <input type="number" name="harga_bongkar" class="form-control" placeholder="250000" required>
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
