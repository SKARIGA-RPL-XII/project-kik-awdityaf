<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'member_id',
        'plan_id',
        'amount',
        'status',
        'payment_method',
        'snap_token'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'plan_id');
    }
}
