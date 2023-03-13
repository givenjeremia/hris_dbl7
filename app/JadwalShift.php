<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalShift extends Model
{
    protected $table = 'jadwal_shifts';
    protected $fillabel = [
        'id_pegawai',
        'date',
        'Ids',
        'shift',
        'month',
        'keterangan'
    ];
}
