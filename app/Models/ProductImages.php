<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'product_images'; // nama tabel
    protected $primaryKey = 'product_image_id'; // primary key

    public $timestamps = false; // kalau tabel tidak punya created_at & updated_at

    protected $fillable = [
        'product_id',
        'product_image_name',
    ];
}
