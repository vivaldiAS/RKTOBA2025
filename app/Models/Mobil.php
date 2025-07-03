<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        "merchant_id",
        "nama",
        "nomor_polisi",
        "warna",
        "mode_transmisi",
        "tipe_driver",
        "lokasi",
        "kapasitas_penumpang",
        "harga_sewa_per_hari",
        "gambar",
        "stok"
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'merchant_id');
    }
}
