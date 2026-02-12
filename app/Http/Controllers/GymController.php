<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GymController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // ================= DASHBOARD =================
    public function index()
{
    $title = 'Gym Dashboard';

    // --- STATISTIK MEMBER (Format Array) ---
    $totalActive = Member::where('status', 'Active')->count();
    $newThisMonth = Member::whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year)
                              ->count();
    
    $maleCount = Member::count() > 0 && Member::first()->gender ? Member::where('gender', 'male')->count() : 0;
    $femaleCount = Member::count() > 0 && Member::first()->gender ? Member::where('gender', 'female')->count() : 0;

    $memberStats = [
        'total_active' => $totalActive,
        'new_this_month' => $newThisMonth,
        'male' => $maleCount, 
        'female' => $femaleCount
    ];

    // --- STATISTIK PENDAPATAN (Format Array) ---
    $monthlyRevenue = MemberSubscription::whereMonth('created_at', Carbon::now()->month)
                                             ->whereYear('created_at', Carbon::now()->year)
                                             ->sum('amount_paid');

    $subscriptionStats = [
        'monthly_revenue' => $monthlyRevenue
    ];

    // --- STATISTIK ABSENSI HARI INI (Format Array) ---
    $todayAttendance = Attendance::whereDate('date', Carbon::today())->count();

    $attendanceStats = [
        'today' => $todayAttendance
    ];

        // --- CHART BULANAN ---
    
    // Rename this variable to $rawMonthlyGrowth to avoid confusion with the final $monthlyGrowth array
    $rawMonthlyGrowth = Member::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month') 
        ->toArray();

    // FIX: Variable renamed from $chartData to $monthlyGrowth
    $monthlyGrowth = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyGrowth[] = $rawMonthlyGrowth[$i] ?? 0;
    }

    // Chart pendapatan bulanan
    $monthlyRevenueChart = MemberSubscription::selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total')
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->get();

    // --- DATA MEMBER TERBARU & EXPIRING ---
    $recentMembers = Member::with('user')->latest()->take(5)->get();
    
    $expiringSubscriptions = MemberSubscription::with('member.user')
        ->whereBetween('end_date', [Carbon::now(), Carbon::now()->addDays(7)])
        ->get();

    // FIX: Inside compact, remove '=> $chartData'. 
    // Just use 'monthlyGrowth' because the variable is now named $monthlyGrowth.
    $plans = MembershipPlan::all();
    $subscriptions = MemberSubscription::with('member.user', 'plan')->get();
    
    return view('gym.subscriptions.index', compact(
        'title',
        'memberStats',
        'subscriptionStats',
        'attendanceStats',
        'monthlyGrowth', 
        'recentMembers',
        'expiringSubscriptions',
        'monthlyRevenueChart',
        'plans',
        'subscriptions'
    ));
}
    // ================= MEMBERS =================
    public function members()
    {
        $members = Member::with('user')->get();

        return view('gym.members.index', compact('members'));
    }

    public function addMember()
    {
        return view('gym.members.add');
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required'
        ]);

        // Create User
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('123456'),
            'role_id' => 2
        ]);

        // Create Member
        Member::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'join_date' => now(),
            'status' => 'Active'
        ]);

        return redirect()->route('gym.members')
            ->with('success', 'Member berhasil ditambahkan');
    }

    // ================= EDIT MEMBER =================
    public function editMember($id)
    {
        $member = Member::findOrFail($id);

        return view('gym.members.edit', compact('member'));
    }

    public function updateMember(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        // Update user
        $member->user->update([
            'name' => $request->name
        ]);

        // Update member
        $member->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status
        ]);

        return redirect()->route('gym.members')
            ->with('success', 'Member diupdate');
    }

    // ================= DELETE =================
    public function deleteMember($id)
    {
        $member = Member::findOrFail($id);

        $member->user()->delete();
        $member->delete();

        return back()->with('success', 'Member dihapus');
    }

    // ================= SUBSCRIPTIONS =================
    public function subscriptions()
    {
        $subscriptions = MemberSubscription::with('member.user', 'plan')->get();
        $plans = MembershipPlan::all();

        return view('gym.subscriptions.index', compact('subscriptions', 'plans'));
    }

    public function createSubscription()
    {
        $members = Member::with('user')->get();
        $plans = MembershipPlan::all();

        return view('gym.subscriptions.add', compact('members', 'plans'));
    }

    public function storeSubscription(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:gym_members,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount_paid' => 'required|numeric',
            'payment_status' => 'required|in:Pending,Paid,Overdue'
        ]);

        MemberSubscription::create($request->all());

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription berhasil ditambahkan');
    }

    public function editSubscription($id)
    {
        $subscription = MemberSubscription::findOrFail($id);
        $members = Member::with('user')->get();
        $plans = MembershipPlan::all();

        return view('gym.subscriptions.edit', compact('subscription', 'members', 'plans'));
    }

    public function updateSubscription(Request $request, $id)
    {
        $subscription = MemberSubscription::findOrFail($id);

        $request->validate([
            'member_id' => 'required|exists:gym_members,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount_paid' => 'required|numeric',
            'payment_status' => 'required|in:Pending,Paid,Overdue'
        ]);

        $subscription->update($request->all());

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription diupdate');
    }

    public function deleteSubscription($id)
    {
        $subscription = MemberSubscription::findOrFail($id);
        $subscription->delete();

        return back()->with('success', 'Subscription dihapus');
    }

    public function showSubscription($id)
    {
        $subscription = MemberSubscription::with('member.user', 'plan')->findOrFail($id);

        return view('gym.subscriptions.details', compact('subscription'));
    }

    public function paySubscription($id)
    {
        $subscription = MemberSubscription::findOrFail($id);
        $subscription->update([
            'payment_status' => 'Paid',
            'payment_date' => now()
        ]);

        return back()->with('success', 'Subscription telah dibayar');
    }

    public function renewSubscription($id)
    {
        $oldSubscription = MemberSubscription::findOrFail($id);
        $plan = $oldSubscription->plan;

        $start = now();
        $end = now()->addMonths($plan->duration_months);

        MemberSubscription::create([
            'member_id' => $oldSubscription->member_id,
            'membership_plan_id' => $plan->id,
            'start_date' => $start,
            'end_date' => $end,
            'amount_paid' => $plan->price,
            'payment_status' => 'Pending'
        ]);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription diperpanjang');
    }

    // ================= ATTENDANCE =================
    public function attendance()
    {
        $attendances = Attendance::with('member.user')->latest()->get();
        
        // Calculate stats
        $today = now()->toDateString();
        $attendance_stats = [
            'today' => Attendance::whereDate('date', $today)->count(),
            'currently_in_gym' => Attendance::whereDate('date', $today)
                ->whereNull('check_out_time')
                ->count(),
            'this_month' => Attendance::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
            'avg_daily' => Attendance::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->selectRaw('COUNT(*) as total, COUNT(DISTINCT date) as days')
                ->first(),
        ];
        
        if ($attendance_stats['avg_daily']) {
            $attendance_stats['avg_daily'] = $attendance_stats['avg_daily']->total / max(1, $attendance_stats['avg_daily']->days);
        } else {
            $attendance_stats['avg_daily'] = 0;
        }
        
        return view('gym.attendance.index', compact('attendances', 'attendance_stats'));
    }

    // ================= SETTINGS =================
    public function settings()
    {
        return view('gym.settings.index');
    }
}