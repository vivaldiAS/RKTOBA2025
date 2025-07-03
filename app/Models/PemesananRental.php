<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_pemesanan',
        'tanggal_mulai_sewa',
        'tanggal_akhir_sewa',
        'jumlah_hari_sewa',
        'user_id',
        'mobil_id',
        'total_harga'
    ];

    public function mobil() {
        return $this->belongsTo(Mobil::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
