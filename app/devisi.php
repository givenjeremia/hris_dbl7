<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class devisi extends Model
{
    protected $table = 'divisi';
    protected $fillabel = [
        'nama',
        'id',
    ];
}
