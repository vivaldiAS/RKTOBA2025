<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile_id',   
        'name',    
        'no_hp',    
        'birthday',    
        'gender', 
        'user_id', 
    ];

    
}
