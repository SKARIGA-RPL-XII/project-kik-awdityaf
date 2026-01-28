<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymMember extends Model
{
    protected $table = 'gym_members';

    protected $fillable = [
        'user_id',
        'member_code',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}