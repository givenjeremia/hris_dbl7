<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mastergaji extends Model
{
    protected $table = 'mastergajis';
    protected $fillable = [
        'data',
        'type',
        'role'
    ];
}
