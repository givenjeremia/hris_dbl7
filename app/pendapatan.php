<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pendapatan extends Model
{
    protected $table = 'pendapatans';
    protected $fillable = [
        'data',
        'type',
        'role',
        
    ];
    public function nama()
    {
        return $this->hasOne('App\jabatan','id','role');
    }
}
