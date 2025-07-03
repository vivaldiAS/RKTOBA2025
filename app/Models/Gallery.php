<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function merchant(){
        return $this->belongsTo(Merchant::class, 'merchant_id', 'merchant_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function transaction(){
        return $this->belongsToMany(Transaction::class, 'gallery_checkouts');
    }
}
