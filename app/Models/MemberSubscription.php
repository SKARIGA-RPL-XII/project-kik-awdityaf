<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSubscription extends Model
{
    protected $table = 'member_subscriptions';

    protected $fillable = [
        'member_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'amount_paid',
        'payment_status',
        'payment_method',
        'order_id',
        'snap_token',
        'transaction_status',
        'payment_date',
        'created_at'
    ];

    public $timestamps = false;

    public function member()
    {
        return $this->belongsTo(GymMember::class, 'member_id');
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }
}