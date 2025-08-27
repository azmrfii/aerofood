@extends('adminlte::page')

@section('plugins.Sweetalert2', true)

@section('title', 'Barang')

@section('content_header')
    <h3>Menu/Barang</h1>
    @stop

    @section('content')
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahBarang">Tambah Barang
                </button>
            </div>
            <div class="card-body">
                <table id="barang-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga (Pcs)</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $barang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>Rp. {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td>{{ $barang->satuan }}</td>
                                <td>
                                    <div style="display: flex; gap: 4px; align-items: center;">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditBarang{{ $barang->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                            style="display:inline-block; margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus barang?')" title="Hapus">
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
        @include('barang.modal-add')
        @include('barang.modal-edit')
    @stop
    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                $('#barang-table').DataTable({
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
