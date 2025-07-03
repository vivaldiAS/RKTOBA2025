<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $primaryKey = 'transaksi_id';
    
    protected $fillable = [
        'stock_id',
        'jumlah_barang_keluar',
        'tanggal_keluar',
        'created_at',
        'penanggung_jawab'
    ];

    public function stock() {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
