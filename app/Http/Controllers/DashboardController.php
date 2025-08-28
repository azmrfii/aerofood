<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dummy data
        $totalUangDiluar = 12000000; // Rp12 jt
        $jumlahPODiluar = 8;

        $totalUangMasuk = 25000000; // Rp25 jt
        $jumlahPOMasuk = 15;

        $totalKeuntungan = 7000000; // Rp7 jt
        $jumlahPO = 23;

        // Dummy chart data
        $poByBarang = collect([
            (object)['nama_barang' => 'Laptop', 'total' => 5],
            (object)['nama_barang' => 'Printer', 'total' => 3],
            (object)['nama_barang' => 'Monitor', 'total' => 7],
            (object)['nama_barang' => 'Scanner', 'total' => 2],
        ]);

        return view('dashboard', compact(
            'totalUangDiluar',
            'jumlahPODiluar',
            'totalUangMasuk',
            'jumlahPOMasuk',
            'totalKeuntungan',
            'jumlahPO',
            'poByBarang'
        ));
    }
}
