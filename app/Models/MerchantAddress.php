<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantAddress extends Model
{
    use HasFactory;

    protected $table = 'merchant_address';

    protected $fillable = [
        'subdistrict_name'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'merchant_id');
    }
}
