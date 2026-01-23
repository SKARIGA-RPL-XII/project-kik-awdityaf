<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GymMember extends Model
{
    protected $table = 'gym_members';

    protected $fillable = [
        'user_id',
        'member_code',
        'status',
        'gender',
        'join_date',
        'created_at',
        'updated_at',
    ];

    /* ===============================
        RELATION
    =============================== */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(MemberSubscription::class, 'member_id');
    }

    /* ===============================
        GET ALL MEMBERS
    =============================== */

    public static function getAllMembers()
    {
        return DB::table('gym_members as gm')
            ->select(
                'gm.*',
                'u.name',
                'u.email',
                'u.image',
                'mp.plan_name',
                'ms.end_date as membership_end'
            )
            ->leftJoin('users as u', 'gm.user_id', '=', 'u.id')
            ->leftJoin('member_subscriptions as ms', function ($join) {
                $join->on('gm.id', '=', 'ms.member_id')
                     ->where('ms.end_date', '>=', now());
            })
            ->leftJoin('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->orderBy('gm.created_at', 'DESC')
            ->get();
    }

    /* ===============================
        GET BY ID
    =============================== */

    public static function getMemberById($id)
    {
        return DB::table('gym_members as gm')
            ->select('gm.*', 'u.name', 'u.email', 'u.image')
            ->leftJoin('users as u', 'gm.user_id', '=', 'u.id')
            ->where('gm.id', $id)
            ->first();
    }

    public static function getMemberByUserId($userId)
    {
        return DB::table('gym_members as gm')
            ->select('gm.*', 'u.name', 'u.email', 'u.image')
            ->leftJoin('users as u', 'gm.user_id', '=', 'u.id')
            ->where('gm.user_id', $userId)
            ->first();
    }

    /* ===============================
        CRUD
    =============================== */

    public static function createMember($data)
    {
        return self::create($data);
    }

    public static function updateMember($id, $data)
    {
        return self::where('id', $id)->update($data);
    }

    public static function deleteMember($id)
    {
        return self::where('id', $id)->delete();
    }

    /* ===============================
        GENERATE CODE
    =============================== */

    public static function generateMemberCode()
    {
        $prefix = 'GYM';
        $year   = date('Y');

        $last = self::where('member_code', 'like', $prefix.$year.'%')
            ->orderBy('member_code', 'DESC')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->member_code, -4);
            $newNumber  = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix.$year.str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /* ===============================
        COUNT
    =============================== */

    public static function getActiveMembersCount()
    {
        return self::where('status', 'Active')->count();
    }

    public static function getNewMembersThisMonth()
    {
        return self::whereMonth('join_date', date('m'))
                   ->whereYear('join_date', date('Y'))
                   ->count();
    }

    public static function getMembersByStatus($status)
    {
        return DB::table('gym_members as gm')
            ->select('gm.*', 'u.name', 'u.email')
            ->leftJoin('users as u', 'gm.user_id', '=', 'u.id')
            ->where('gm.status', $status)
            ->get();
    }

    /* ===============================
        CHECK CODE
    =============================== */

    public static function memberCodeExists($code)
    {
        return self::where('member_code', $code)->exists();
    }

    /* ===============================
        CURRENT SUBSCRIPTION
    =============================== */

    public static function getCurrentSubscription($memberId)
    {
        return DB::table('member_subscriptions as ms')
            ->select('ms.*', 'mp.plan_name', 'mp.price')
            ->join('membership_plans as mp', 'ms.membership_plan_id', '=', 'mp.id')
            ->where('ms.member_id', $memberId)
            ->where('ms.end_date', '>=', now())
            ->orderBy('ms.end_date', 'DESC')
            ->first();
    }

    /* ===============================
        DASHBOARD STATS
    =============================== */

    public static function getMemberStats()
    {
        $stats = [];

        $stats['total_active'] = self::where('status', 'Active')->count();

        $stats['new_this_month'] = self::whereMonth('join_date', date('m'))
            ->whereYear('join_date', date('Y'))
            ->count();

        $gender = self::select('gender', DB::raw('COUNT(*) as total'))
            ->where('status', 'Active')
            ->groupBy('gender')
            ->get();

        $stats['male']   = 0;
        $stats['female'] = 0;

        foreach ($gender as $g) {
            if ($g->gender === 'Male') {
                $stats['male'] = $g->total;
            } else {
                $stats['female'] = $g->total;
            }
        }

        $stats['inactive'] = self::where('status', '!=', 'Active')->count();

        return $stats;
    }

    /* ===============================
        MONTHLY GROWTH
    =============================== */

    public static function getMonthlyGrowth($year = null)
    {
        $year = $year ?? date('Y');

        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = self::whereMonth('join_date', $i)
                ->whereYear('join_date', $year)
                ->count();
        }

        return $data;
    }

    /* ===============================
        SEARCH
    =============================== */

    public static function searchMembers($query)
    {
        return DB::table('gym_members as gm')
            ->select('gm.id', 'gm.member_code', 'u.name')
            ->join('users as u', 'gm.user_id', '=', 'u.id')
            ->where('gm.status', 'Active')
            ->where(function ($q) use ($query) {
                $q->where('u.name', 'like', "%$query%")
                  ->orWhere('gm.member_code', 'like', "%$query%");
            })
            ->limit(10)
            ->get();
    }
}