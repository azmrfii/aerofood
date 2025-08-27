<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_po',
        'tgl_delivery',
        'no_po',
        'barang_id',
        'qty',
        'harga_satuan',
        'jumlah',
        'persentase_keuntungan_id',
        'tgl_beli',
        'uang_masuk',
        'tgl_uang_masuk',
        'bongkar_muat_id',
        'note',
        'estimasi_hari_pembayaran_id',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function persentase_keuntungan()
    {
        return $this->belongsTo(PersentaseKeuntungan::class);
    }

    public function bongkar_muat()
    {
        return $this->belongsTo(BongkarMuat::class);
    }

    public function estimasi_hari_pembayaran()
    {
        return $this->belongsTo(EstimasiHariPembayaran::class);
    }
}
