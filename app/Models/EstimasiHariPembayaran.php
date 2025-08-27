<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimasiHariPembayaran extends Model
{
    use HasFactory;

    protected $table = 'estimasi_hari_pembayarans';

    protected $fillable = [
        'periode_waktu',
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
