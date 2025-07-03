<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchHistory extends Model
{
    use HasFactory;

    protected $table = 'search_history';

    protected $fillable = ['keyword', 'searched_at']; 


    public $timestamps = false; // karena kita pakai `searched_at` manual, bukan `created_at` / `updated_at`

    // Relasi: Histori pencarian milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
