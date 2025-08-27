<?php

namespace App\Http\Controllers;

use App\Models\EstimasiHariPembayaran;
use Illuminate\Http\Request;

class EstimasiHariPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estimasiHari = EstimasiHariPembayaran::all();
        return view('estimasi_hari_pembayaran.index', compact('estimasiHari'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_waktu' => 'required|integer',
        ]);

        EstimasiHariPembayaran::create($validated);

        return redirect()->route('estimasi_hari_pembayaran.index')->with('success', 'Estimasi Hari Pembayaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'periode_waktu' => 'required|numeric',
        ]);

        $estimasiHari = EstimasiHariPembayaran::findOrFail($id);
        $estimasiHari->update($validated);

        return redirect()->route('estimasi_hari_pembayaran.index')->with('success', 'Estimasi Hari Pembayaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estimasiHari = EstimasiHariPembayaran::findOrFail($id);
        $estimasiHari->delete();
        return redirect()->route('estimasi_hari_pembayaran.index')->with('success', 'Estimasi Hari Pembayaran berhasil dihapus');
    }
}
