<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class potongan extends Model
{
    protected $table = 'potongans';
    protected $fillabel = [
        'data',
        'type',
        'role',
        
    ];
}
