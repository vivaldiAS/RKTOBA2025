<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananTiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_pemesanan',
        'jumlah_anak',
        'jumlah_dewasa',
        'total_harga',
        'user_id',
        'tiket_experience_id'
    ];

    public function tiket_experience() {
        return $this->belongsTo(TiketExperience::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
