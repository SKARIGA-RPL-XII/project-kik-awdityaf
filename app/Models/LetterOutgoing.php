<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterOutgoing extends Model
{
    use HasFactory;

    protected $table = 'letter_outgoing';

    protected $fillable = [
        'letterdate',
        'letternumber',
        'letterdestination',
        'lettersubject',
        'letterstatus',
        'letterdescription',
        'letterfile',
        'is_realis',
        'is_tindak',
        'information',
    ];

    protected $casts = [
        'letterdate' => 'date',
    ];
}