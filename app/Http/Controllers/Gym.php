<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        $memberStats = Member::count();

        $subscriptionStats = Subscription::count();

        $attendanceStats = Attendance::whereDate('date', now())->count();

        // Chart bulanan
        $monthlyGrowth = Member::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->get();

        return view('gym.dashboard', compact(
            'title',
            'memberStats',
            'subscriptionStats',
            'attendanceStats',
            'monthlyGrowth'
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

    // ================= ATTENDANCE =================
    public function attendance()
    {
        $attendance = Attendance::latest()->get();

        return view('gym.attendance.index', compact('attendance'));
    }

    public function checkin(Request $request)
    {
        Attendance::create([
            'member_id' => $request->member_id,
            'date' => now(),
            'check_in_time' => now()
        ]);

        return back()->with('success', 'Check-in berhasil');
    }

    // ================= PLANS =================
    public function plans()
    {
        $plans = Plan::all();

        return view('gym.plans.index', compact('plans'));
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'plan_name' => 'required',
            'price' => 'required|numeric'
        ]);

        Plan::create($request->all());

        return back()->with('success', 'Plan ditambahkan');
    }

    // ================= SUBSCRIPTIONS =================
    public function subscriptions()
    {
        $subscriptions = Subscription::with('member','plan')->get();

        return view('gym.subscriptions.index', compact('subscriptions'));
    }

}