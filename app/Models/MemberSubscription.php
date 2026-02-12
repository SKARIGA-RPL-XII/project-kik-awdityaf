<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    /* ===============================
       GET ACTIVE SUBSCRIPTION BY MEMBER
    =============================== */
    public static function activeByMember($memberId)
    {
        return self::where('member_id', $memberId)
            ->where('payment_status', 'COMPLETED')
            ->where('end_date', '>=', Carbon::today())
            ->with('plan')
            ->first();
    }

    /* ===============================
       GET ALL SUBSCRIPTIONS BY MEMBER
    =============================== */
    public static function getSubscriptionsByMember($memberId)
    {
        return self::where('member_id', $memberId)
            ->with('plan')
            ->latest('start_date')
            ->get();
    }
}
