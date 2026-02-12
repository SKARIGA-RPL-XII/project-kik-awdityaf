<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterOutgoing extends Model
{
    protected $table = 'letter_outgoings';

    protected $fillable = [
        'letter_date',
        'letternumber',
        'letterdestination',
        'lettersubject',
        'letterstatus',
        'letterdescriptions',
        'letterfile',
        'is_realis',
        'is_tindak',
        'information'
    ];
}