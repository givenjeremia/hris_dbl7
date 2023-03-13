<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    protected $table = 'client';
    protected $fillabel = [
        'nama',
        'kontrak',
        'email',
        'alamat',
        'lokasi',
        'lat',
        'long'
    ];
}
