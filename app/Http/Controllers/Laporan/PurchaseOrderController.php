<?php

namespace App\Http\Controllers\Laporan;

use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $poJatuhTempo = PurchaseOrder::with(['barang', 'estimasi_hari_pembayaran'])
            ->whereNull('tgl_beli')
            ->whereHas('estimasi_hari_pembayaran')
            ->where(function($q) use ($today) {
                $q->whereRaw('DATE(tgl_delivery, "+" || (SELECT periode_waktu FROM estimasi_hari_pembayarans WHERE id = purchase_orders.estimasi_hari_pembayaran_id) || " day") < ?', [$today->toDateString()]);
            })
            ->get();

        $poSudahBayar = PurchaseOrder::with(['barang', 'estimasi_hari_pembayaran'])
            ->whereNotNull('tgl_beli')
            ->get();

        return view('laporan.purchase_order.index', [
            'poJatuhTempo' => $poJatuhTempo,
            'poSudahBayar' => $poSudahBayar,
        ]);
    }
}
