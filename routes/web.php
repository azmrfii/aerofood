<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BongkarMuatController;
use App\Http\Controllers\EstimasiHariPembayaranController;
use App\Http\Controllers\PersentaseKeuntunganController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\Laporan\PurchaseOrderController as LaporanPurchaseOrderController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
// Route::redirect('/dashboard', '/');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('menu')->group(function () {
    Route::resource('purchase_order', PurchaseOrderController::class);
    Route::post('purchase_order/form_beli', [PurchaseOrderController::class, 'form_beli'])->name('purchase_order.form_beli');
    Route::post('purchase_order/uang_masuk', [PurchaseOrderController::class, 'uang_masuk'])->name('purchase_order.uang_masuk');
    Route::resource('barang', BarangController::class);
    Route::resource('bongkar_muat', BongkarMuatController::class);
    Route::resource('persentase_keuntungan', PersentaseKeuntunganController::class);
    Route::resource('estimasi_hari_pembayaran', EstimasiHariPembayaranController::class);
});

Route::prefix('laporan')->group(function () {
    Route::get('purchase_order', [LaporanPurchaseOrderController::class, 'index'])->name('laporan.purchase_order.index');
});
