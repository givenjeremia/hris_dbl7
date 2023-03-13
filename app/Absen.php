<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absensi';
    protected $fillabel =[
        'lat',
        'lang',
        'id_pegawai',
        'id_client',
        'masuk',
        'pulang',
        'status',
        'keterangan',
        'created_at'
    ];
}
