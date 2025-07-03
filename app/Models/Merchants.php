<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchants extends Model
{
    use HasFactory;

    protected $table = 'merchants'; // nama tabel

    protected $primaryKey = 'merchant_id';

    protected $fillable = [
        'merchant_id',
        'user_id',
        'nama_merchant',
        'deskripsi_toko',
        'kontak_toko',
        'foto_merchant',
        'is_verified',
        'on_vacation',
        'is_closed',
        'created_at',
        'updated_at'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'merchant_id');
    }

    public function address()
    {
        return $this->hasOne(MerchantAddress::class, 'merchant_id', 'merchant_id');
    }

    public function products()
{
    return $this->hasMany(Product::class, 'merchant_id', 'merchant_id');
}

}
