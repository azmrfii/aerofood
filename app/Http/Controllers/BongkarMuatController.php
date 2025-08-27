<?php

namespace App\Http\Controllers;

use App\Models\BongkarMuat;
use Illuminate\Http\Request;

class BongkarMuatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bongkarMuat = BongkarMuat::all();
        return view('bongkar_muat.index', compact('bongkarMuat'));
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
            'harga_bongkar' => 'required|numeric',
        ]);

        BongkarMuat::create($validated);

        return redirect()->route('bongkar_muat.index')->with('success', 'Bongkar Muat berhasil ditambahkan');
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
            'harga_bongkar' => 'required|numeric',
        ]);

        $bongkarMuat = BongkarMuat::findOrFail($id);
        $bongkarMuat->update($validated);

        return redirect()->route('bongkar_muat.index')->with('success', 'Bongkar Muat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bongkarMuat = BongkarMuat::findOrFail($id);
        $bongkarMuat->delete();
        return redirect()->route('bongkar_muat.index')->with('success', 'Bongkar Muat berhasil dihapus');
    }
}
