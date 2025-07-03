<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products'; // sesuaikan dengan nama tabel yang sesuai

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'category_id',
        'merchant_id',
        'product_name',
        'on_warehouse',
        'is_deleted',
        'description',
    ];

    protected $primaryKey = 'product_id';

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function productImages()
{
    return $this->hasMany(ProductImages::class, 'product_id');
}

}
