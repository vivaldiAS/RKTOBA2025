<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks_warehouse';
    protected $primaryKey = 'stock_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stocks_id',
        'product_id',
        'merchant_id',
        'category_id',
        'jumlah_stok',
        'tanggal_masuk',
        'tanggal_keluar',
        'tanggal_expired',
    ];

    /**
     * Relationship with Product model.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    
    /**
     * Relationship with Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Relationship with Merchant model.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'merchant_id');
    }

    /**
     * Relationship with Transaksi model.
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'stock_id', 'stock_id');
    }
}
