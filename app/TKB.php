<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TKB extends Model
{
    protected $table = "tkb";
    public $timestamps = false;

    protected $fillable = [
        'ho_ten',
        'msv',
        'lop',
        'hoc_ky',
        'tkb'
    ];
}
