<?php

namespace App;

use App\Shift;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class newshift extends Model
{ 
    
    protected $table = 'new_jadwal_shifts';
    protected $guarded = ['_token'];

    public function shift(){
        return $this->belongsTo(Shift::class,'shift_id');

    }


}
