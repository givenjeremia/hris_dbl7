<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class terlambat extends Model
{
    protected $table = 'terlambat';
    protected $fillabel =[
        'id_pegawai',
        'masuk',
        'pulang',
        'date',
        'created_at'
    ];
}
