<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BongkarMuat;
use App\Models\EstimasiHariPembayaran;
use App\Models\PersentaseKeuntungan;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('barang')
            ->with('bongkar_muat')
            ->with('persentase_keuntungan')
            ->with('estimasi_hari_pembayaran')
            ->orderByDesc('tgl_po')
            ->get();

        $barangs = Barang::all();
        $bongkarMuats = BongkarMuat::all();
        $persentaseKeuntungans = PersentaseKeuntungan::all();
        $estimasiHariPembayarans = EstimasiHariPembayaran::all();

        return view('purchase_order.index', compact(
            'purchaseOrders',
            'barangs',
            'bongkarMuats',
            'persentaseKeuntungans',
            'estimasiHariPembayarans'
        ));
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
            'tgl_po' => 'required|date',
            'tgl_delivery' => 'nullable|date',
            'no_po' => 'required|string',
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required|integer',
            'jumlah' => 'required|numeric',
            'persentase_keuntungan_id' => 'required|exists:persentase_keuntungans,id',
            'estimasi_hari_pembayaran_id' => 'required|exists:estimasi_hari_pembayarans,id',
        ]);

        if (PurchaseOrder::where('no_po', $validated['no_po'])->exists()) {
            return back()->with('error', 'No PO sudah ada');
        }

        $barang = Barang::find($validated['barang_id']);
        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }
        $validated['harga_satuan'] = $barang->harga;

        PurchaseOrder::create($validated);

        return redirect()->route('purchase_order.index')->with('success', 'Purchase Order berhasil ditambahkan');
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
            'tgl_po' => 'required|date',
            'tgl_delivery' => 'nullable|date',
            'no_po' => 'required|string',
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required|integer',
            'jumlah' => 'required|numeric',
            'persentase_keuntungan_id' => 'required|exists:persentase_keuntungans,id',
            'estimasi_hari_pembayaran_id' => 'required|exists:estimasi_hari_pembayarans,id',
        ]);

        if (PurchaseOrder::where('no_po', $validated['no_po'])->where('id', '!=', $id)->exists()) {
            return back()->with('error', 'No PO sudah ada');
        }

        $barang = Barang::find($validated['barang_id']);
        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }
        $validated['harga_satuan'] = $barang->harga;

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->update($validated);

        return redirect()->route('purchase_order.index')->with('success', 'Purchase Order berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->delete();
        return redirect()->route('purchase_order.index')->with('success', 'Purchase Order berhasil dihapus');
    }

    public function form_beli(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'harga_beli' => 'required|numeric',
            'tgl_beli' => 'required|date',
            'bongkar_id' => 'required|exists:bongkar_muats,id',
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($validated['purchase_order_id']);
        $purchaseOrder->harga_beli = $validated['harga_beli'];
        $purchaseOrder->bongkar_muat_id = $validated['bongkar_id'];
        $purchaseOrder->tgl_beli = $validated['tgl_beli'];
        $purchaseOrder->save();

        return redirect()->route('purchase_order.index')->with('success', 'Data pembelian berhasil disimpan');
    }

    public function uang_masuk(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'uang_masuk' => 'required|numeric',
            'tgl_uang_masuk' => 'required|date',
            'note' => 'nullable',
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($validated['purchase_order_id']);
        $purchaseOrder->uang_masuk = $validated['uang_masuk'];
        $purchaseOrder->tgl_uang_masuk = $validated['tgl_uang_masuk'];

        // Hitung selisih hari dari tgl_delivery ke tgl_uang_masuk
        if ($purchaseOrder->tgl_delivery && $purchaseOrder->tgl_uang_masuk) {
            $tglDelivery = \Carbon\Carbon::parse($purchaseOrder->tgl_delivery);
            $tglUangMasuk = \Carbon\Carbon::parse($purchaseOrder->tgl_uang_masuk);
            $selisihHari = $tglDelivery->diffInDays($tglUangMasuk);

            // Cari estimasi hari pembayaran
            $estimasi = \App\Models\EstimasiHariPembayaran::where('periode_waktu', $selisihHari)->first();
            if (!$estimasi) {
                // Buat baru jika belum ada
                $estimasi = \App\Models\EstimasiHariPembayaran::create([
                    'periode_waktu' => $selisihHari
                ]);
            }
            $purchaseOrder->estimasi_hari_pembayaran_id = $estimasi->id;
        }

        $purchaseOrder->save();

        return redirect()->route('purchase_order.index')->with('success', 'Data Uang Masuk berhasil disimpan');
    }
}
