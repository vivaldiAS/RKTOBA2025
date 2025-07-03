<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "nama",
        "lokasi",
        "jenis_tiket",
        "jam_operasional",
        "harga_anak",
        "harga_dewasa",
        "gambar",
        "merchant_id"
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'merchant_id');
    }

    public function pemesanan()
    {
        return $this->hasOne(PemesananTiket::class);
    }
}
