<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class potongangaji extends Model
{
    protected $table = 'potongangajis';
    protected $fillable = [
        'data',
        'type',
        'slug_id',
        'id_user',
        'pendapatan_id'
        
    ];
}
