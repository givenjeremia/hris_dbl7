<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bpjs extends Model
{
    protected $table = 'bpjs';
    protected $fillabel = [
        'bpjs_tk',
        'bpjs_kes',
        'bpjs_ht'
    ];
}
