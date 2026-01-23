<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsLetterCategory extends Model
{
    protected $table = 'ms_lettercategory';

    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}