<?php

namespace App;
use App\potongangaji;

use Illuminate\Database\Eloquent\Model;

class pendapatangaji extends Model
{
    protected $table = 'pendapatangajis';
    protected $fillable = [
        'id_user',
        'data',
        'type',
        'slug_id',
        'created_at',
        'updated_at'
        
    ];
    public function potongan()
    {
        return $this->hasMany('App\potongangaji','pendapatan_id','id');
    }
}
