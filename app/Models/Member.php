<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'gym_members';

    protected $fillable = [
        'user_id',
        'member_code',
        'phone',
        'address',
        'emergency_contact',
        'emergency_phone',
        'join_date',
        'status',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(MemberSubscription::class, 'member_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'member_id');
    }
}
