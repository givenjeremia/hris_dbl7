<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cutis extends Model
{
    public $timestamps = true;
    protected $table = 'cutis';
    protected $fillabel = [
        'nama',
        'mulai',
        'akhir',
        'keterangan',
        'status',
        'subjek',
        'id_pegawai',
        'created_at'
    ];
}
