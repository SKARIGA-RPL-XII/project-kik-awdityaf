<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberSubscription extends Model
{
    protected $table = 'member_subscriptions';

    protected $fillable = [
        'member_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'payment_status',
        'payment_date',
        'amount_paid',
        'order_id',
        'created_at',
        'updated_at',
    ];

    /* ============================
       GET ALL SUBSCRIPTIONS
    ============================ */
    public static function getAllSubscriptions()
    {
        return DB::table('member_subscriptions as ms')
            ->join('gym_members as gm', 'ms.member_id', '=', 'gm.id')
            ->join('users as u', 'gm.user_id', '=', 'u.id')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->select(
                'ms.*',
                'gm.member_code',
                'u.name as member_name',
                'mp.plan_name'
            )
            ->orderByDesc('ms.created_at')
            ->get();
    }

    /* ============================
       GET BY ID
    ============================ */
    public static function getSubscriptionById($id)
    {
        return DB::table('member_subscriptions as ms')
            ->join('gym_members as gm', 'ms.member_id', '=', 'gm.id')
            ->join('users as u', 'gm.user_id', '=', 'u.id')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->select(
                'ms.*',
                'gm.member_code',
                'u.name as member_name',
                'mp.plan_name',
                'mp.price'
            )
            ->where('ms.id', $id)
            ->first();
    }

    /* ============================
       BY MEMBER
    ============================ */
    public static function getSubscriptionsByMember($memberId)
    {
        return DB::table('member_subscriptions as ms')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->select('ms.*', 'mp.plan_name', 'mp.price')
            ->where('ms.member_id', $memberId)
            ->orderByDesc('ms.start_date')
            ->get();
    }

    /* ============================
       CREATE
    ============================ */
    public static function createSubscription($data)
    {
        return self::create($data);
    }

    /* ============================
       UPDATE
    ============================ */
    public static function updateSubscription($id, $data)
    {
        return self::where('id', $id)->update($data);
    }

    /* ============================
       DELETE
    ============================ */
    public static function deleteSubscription($id)
    {
        return self::destroy($id);
    }

    /* ============================
       ACTIVE SUBSCRIPTIONS
    ============================ */
    public static function getActiveSubscriptions()
    {
        return DB::table('member_subscriptions as ms')
            ->join('gym_members as gm', 'ms.member_id', '=', 'gm.id')
            ->join('users as u', 'gm.user_id', '=', 'u.id')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->select(
                'ms.*',
                'gm.member_code',
                'u.name as member_name',
                'mp.plan_name'
            )
            ->where('ms.end_date', '>=', now())
            ->where('ms.payment_status', 'Paid')
            ->orderBy('ms.end_date')
            ->get();
    }

    /* ============================
       EXPIRING
    ============================ */
    public static function getExpiringSubscriptions($days = 7)
    {
        return DB::table('member_subscriptions as ms')
            ->join('gym_members as gm', 'ms.member_id', '=', 'gm.id')
            ->join('users as u', 'gm.user_id', '=', 'u.id')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->select(
                'ms.*',
                'gm.member_code',
                'u.name as member_name',
                'u.email',
                'mp.plan_name'
            )
            ->whereBetween('ms.end_date', [
                now(),
                now()->addDays($days)
            ])
            ->where('ms.payment_status', 'Paid')
            ->orderBy('ms.end_date')
            ->get();
    }

    /* ============================
       OVERDUE
    ============================ */
    public static function getOverdueSubscriptions()
    {
        return DB::table('member_subscriptions as ms')
            ->join('gym_members as gm', 'ms.member_id', '=', 'gm.id')
            ->join('users as u', 'gm.user_id', '=', 'u.id')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->select(
                'ms.*',
                'gm.member_code',
                'u.name as member_name',
                'u.email',
                'mp.plan_name'
            )
            ->where('ms.end_date', '<', now())
            ->where('ms.payment_status', 'Paid')
            ->orderBy('ms.end_date')
            ->get();
    }

    /* ============================
       MONTHLY REVENUE
    ============================ */
    public static function getMonthlyRevenue($month = null, $year = null)
    {
        $month ??= now()->month;
        $year ??= now()->year;

        return self::where('payment_status', 'Paid')
            ->whereMonth('payment_date', $month)
            ->whereYear('payment_date', $year)
            ->sum('amount_paid');
    }

    /* ============================
       YEARLY REVENUE
    ============================ */
    public static function getYearlyRevenue($year = null)
    {
        $year ??= now()->year;

        return self::where('payment_status', 'Paid')
            ->whereYear('payment_date', $year)
            ->sum('amount_paid');
    }

    /* ============================
       CHART
    ============================ */
    public static function getMonthlyRevenueChart($year = null)
    {
        $year ??= now()->year;

        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = self::where('payment_status', 'Paid')
                ->whereMonth('payment_date', $i)
                ->whereYear('payment_date', $year)
                ->sum('amount_paid');
        }

        return $data;
    }

    /* ============================
       STATS
    ============================ */
    public static function getSubscriptionStats()
    {
        return [
            'active_subscriptions' => self::where('end_date', '>=', now())
                ->where('payment_status', 'Paid')
                ->count(),

            'expiring_soon' => self::whereBetween('end_date', [
                now(),
                now()->addDays(7)
            ])
                ->where('payment_status', 'Paid')
                ->count(),

            'overdue' => self::where('end_date', '<', now())
                ->where('payment_status', 'Paid')
                ->count(),

            'monthly_revenue' => self::getMonthlyRevenue(),

            'yearly_revenue' => self::getYearlyRevenue(),
        ];
    }

    /* ============================
       ORDER ID
    ============================ */
    public static function getSubscriptionByOrderId($orderId)
    {
        return self::where('order_id', $orderId)->first();
    }

    /* ============================
       ORDER DETAIL
    ============================ */
    public static function getSubscriptionDetailsByOrderId($orderId)
    {
        return DB::table('member_subscriptions as ms')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->join('gym_members as gm', 'ms.member_id', '=', 'gm.id')
            ->join('users as u', 'gm.user_id', '=', 'u.id')
            ->select(
                'ms.*',
                'mp.plan_name',
                'mp.duration_months',
                'gm.member_code',
                'u.name as member_name',
                'u.email'
            )
            ->where('ms.order_id', $orderId)
            ->first();
    }
}