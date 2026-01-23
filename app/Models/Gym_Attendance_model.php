<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GymAttendance extends Model
{
    protected $table = 'gym_attendance';

    protected $fillable = [
        'member_id',
        'check_in_time',
        'check_out_time',
        'date',
    ];

    public $timestamps = false;


    /* ===============================
       RELATION
    =============================== */

    public function member()
    {
        return $this->belongsTo(GymMember::class, 'member_id');
    }


    /* ===============================
       GET ALL ATTENDANCE
    =============================== */

    public static function getAllAttendance()
    {
        return self::select(
                'gym_attendance.*',
                'gym_members.member_code',
                'users.name as member_name'
            )
            ->join('gym_members', 'gym_attendance.member_id', '=', 'gym_members.id')
            ->join('users', 'gym_members.user_id', '=', 'users.id')
            ->orderByDesc('check_in_time')
            ->get();
    }


    /* ===============================
       BY MEMBER
    =============================== */

    public static function getAttendanceByMember($memberId, $limit = null)
    {
        $query = self::select(
                'gym_attendance.*',
                'gym_members.member_code',
                'users.name as member_name'
            )
            ->join('gym_members', 'gym_attendance.member_id', '=', 'gym_members.id')
            ->join('users', 'gym_members.user_id', '=', 'users.id')
            ->where('gym_attendance.member_id', $memberId)
            ->orderByDesc('check_in_time');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }


    /* ===============================
       CHECK IN
    =============================== */

    public static function checkIn($memberId)
    {
        $today = Carbon::today()->toDateString();

        $exists = self::where('member_id', $memberId)
            ->where('date', $today)
            ->whereNull('check_out_time')
            ->exists();

        if ($exists) {
            return false;
        }

        return self::create([
            'member_id'     => $memberId,
            'check_in_time' => Carbon::now(),
            'date'          => $today,
        ]);
    }


    /* ===============================
       CHECK OUT
    =============================== */

    public static function checkOut($memberId)
    {
        $today = Carbon::today()->toDateString();

        return self::where('member_id', $memberId)
            ->where('date', $today)
            ->whereNull('check_out_time')
            ->update([
                'check_out_time' => Carbon::now()
            ]);
    }


    /* ===============================
       TODAY
    =============================== */

    public static function getTodayAttendance()
    {
        $today = Carbon::today()->toDateString();

        return self::select(
                'gym_attendance.*',
                'gym_members.member_code',
                'users.name as member_name'
            )
            ->join('gym_members', 'gym_attendance.member_id', '=', 'gym_members.id')
            ->join('users', 'gym_members.user_id', '=', 'users.id')
            ->where('gym_attendance.date', $today)
            ->orderByDesc('check_in_time')
            ->get();
    }


    public static function getTodayAttendanceCount()
    {
        return self::whereDate('date', Carbon::today())->count();
    }


    /* ===============================
       MONTHLY
    =============================== */

    public static function getMonthlyAttendanceCount($month = null, $year = null)
    {
        $month ??= date('m');
        $year ??= date('Y');

        return self::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->count();
    }


    /* ===============================
       CHART DATA
    =============================== */

    public static function getDailyAttendanceChart($days = 7)
    {
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i)->toDateString();

            $data[] = self::whereDate('date', $date)->count();
        }

        return $data;
    }


    public static function getMonthlyAttendanceChart($year = null)
    {
        $year ??= date('Y');

        $data = [];

        for ($i = 1; $i <= 12; $i++) {

            $data[] = self::whereMonth('date', $i)
                ->whereYear('date', $year)
                ->count();
        }

        return $data;
    }


    /* ===============================
       MEMBER RATE
    =============================== */

    public static function getMemberAttendanceRate($memberId, $days = 30)
    {
        $start = Carbon::now()->subDays($days)->toDateString();

        $count = self::where('member_id', $memberId)
            ->whereBetween('date', [$start, Carbon::today()])
            ->count();

        return round(($count / $days) * 100, 2);
    }


    /* ===============================
       PEAK HOURS
    =============================== */

    public static function getPeakHours()
    {
        return self::selectRaw('HOUR(check_in_time) as hour, COUNT(*) as total')
            ->where('date', '>=', Carbon::now()->subDays(30))
            ->groupBy('hour')
            ->orderByDesc('total')
            ->get();
    }


    /* ===============================
       STATUS
    =============================== */

    public static function isMemberInGym($memberId)
    {
        return self::where('member_id', $memberId)
            ->whereDate('date', Carbon::today())
            ->whereNull('check_out_time')
            ->exists();
    }


    /* ===============================
       STATISTIC
    =============================== */

    public static function getAttendanceStats()
    {
        $stats = [];

        $stats['today'] = self::getTodayAttendanceCount();

        $stats['this_month'] = self::getMonthlyAttendanceCount();

        $stats['avg_daily'] = DB::table('gym_attendance')
            ->selectRaw('AVG(daily_count) as avg')
            ->fromSub(function ($q) {

                $q->from('gym_attendance')
                    ->selectRaw('date, COUNT(*) as daily_count')
                    ->where('date', '>=', Carbon::now()->subDays(30))
                    ->groupBy('date');

            }, 't')
            ->value('avg') ?? 0;

        $stats['currently_in_gym'] = self::whereDate('date', Carbon::today())
            ->whereNull('check_out_time')
            ->count();

        return $stats;
    }


    /* ===============================
       BY ID
    =============================== */

    public static function getAttendanceById($id)
    {
        return self::select(
                'gym_attendance.*',
                'gym_members.member_code',
                'users.name as member_name'
            )
            ->join('gym_members', 'gym_attendance.member_id', '=', 'gym_members.id')
            ->join('users', 'gym_members.user_id', '=', 'users.id')
            ->where('gym_attendance.id', $id)
            ->first();
    }


    /* ===============================
       DATE RANGE
    =============================== */

    public static function getAttendanceByDateRange($start, $end)
    {
        return self::select(
                'gym_attendance.*',
                'gym_members.member_code',
                'users.name as member_name'
            )
            ->join('gym_members', 'gym_attendance.member_id', '=', 'gym_members.id')
            ->join('users', 'gym_members.user_id', '=', 'users.id')
            ->whereBetween('gym_attendance.date', [$start, $end])
            ->orderByDesc('date')
            ->orderByDesc('check_in_time')
            ->get();
    }


    /* ===============================
       DELETE
    =============================== */

    public static function deleteAttendance($id)
    {
        return self::where('id', $id)->delete();
    }


    /* ===============================
       WEEKLY
    =============================== */

    public static function getWeeklyAttendanceChart()
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i)->toDateString();

            $data[] = self::whereDate('date', $date)->count();
        }

        return $data;
    }


    /* ===============================
       MONTHLY SUMMARY
    =============================== */

    public static function getMonthlyAttendanceSummary($year = null, $month = null)
    {
        $year ??= date('Y');
        $month ??= date('m');

        return self::selectRaw('DATE(date) as attendance_date, COUNT(*) as total')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->groupBy('attendance_date')
            ->orderBy('attendance_date')
            ->get();
    }
}