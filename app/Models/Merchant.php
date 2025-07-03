<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'merchant_id';

    public function mobil()
    {
        return $this->hasMany(Mobil::class, 'merchant_id', 'merchant_id');
    }

    public function merchant_address()
    {
        return $this->hasMany(MerchantAddress::class, 'merchant_id', 'merchant_id');
    }
}
