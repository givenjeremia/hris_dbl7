<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class newshift extends Model
{ protected $table = 'new_jadwal_shifts';
    protected $guarded = ['_token'];
}
