<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillabel = [
        'nama',
        'id',
    ];
    public function divisi()
    {
        return $this->belongsTo('App\devisi','divisi_id');
    }

}
