<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lembur extends Model
{
    protected $table = 'lemburs';
    protected $fillable = [
        'date',
        'user_id',
        'start_time',
        'end_time',
        'keterangan',
        'status',
    ];
    use HasFactory;
}

