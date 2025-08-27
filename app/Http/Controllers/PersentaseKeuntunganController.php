<?php

namespace App\Http\Controllers;

use App\Models\PersentaseKeuntungan;
use Illuminate\Http\Request;

class PersentaseKeuntunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $besaranPersen = PersentaseKeuntungan::all();
        return view('persentase_keuntungan.index', compact('besaranPersen'));
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
            'besaran_persen' => 'required|integer',
        ]);

        PersentaseKeuntungan::create($validated);

        return redirect()->route('persentase_keuntungan.index')->with('success', 'Persentase Keuntungan berhasil ditambahkan');
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
            'besaran_persen' => 'required|integer',
        ]);

        $besaranPersen = PersentaseKeuntungan::findOrFail($id);
        $besaranPersen->update($validated);

        return redirect()->route('persentase_keuntungan.index')->with('success', 'Persetanse Keuntungan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $besaranPersen = PersentaseKeuntungan::findOrFail($id);
        $besaranPersen->delete();
        return redirect()->route('persentase_keuntungan.index')->with('success', 'Persetanse Keuntungan berhasil dihapus');
    }
}
