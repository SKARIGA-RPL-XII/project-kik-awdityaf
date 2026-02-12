<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterIncoming extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_number',
        'letter_date',
        'sender',
        'subject',
        'description',
        'file_path',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}