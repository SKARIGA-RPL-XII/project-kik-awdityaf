<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterOutgoing extends Model
{
    protected $table = 'letter_outgoings';

    protected $fillable = [
        'letterdate',
        'is_tindak',
        'is_realis',
    ];

    public $timestamps = false;
}