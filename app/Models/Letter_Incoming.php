<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterIncoming extends Model
{
    protected $table = 'letter_incomings';

    protected $fillable = [
        'letter_date',
        'letternumber',
        'letterorigin',
        'lettersubject',
        'letterstatus',
        'letterdescription',
        'letterfile',
    ];

    public $timestamps = false;
}