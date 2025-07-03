<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;

    protected $table = 'stock_opname';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'stock_id',
        'jumlah_barang',
        'tanggal_keluar',
        'created_at',
        'penanggung_jawab'
    ];

    public function stock() {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
