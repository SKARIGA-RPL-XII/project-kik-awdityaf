<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Attendance;
use App\Models\MemberReport;

class MemberController extends Controller
{
    public function __construct()
    {
        // Login + Role Member
        $this->middleware(['auth', 'role:member']);
    }


    /* =========================
        DASHBOARD
    ========================= */
    public function index()
    {
        $title = 'Member Dashboard';

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        $currentSubscription = null;
        $recentAttendance = [];
        $attendanceRate = 0;
        $isInGym = false;

        if ($member) {

            $currentSubscription = MemberSubscription::activeByMember($member->id);

            $recentAttendance = Attendance::byMember($member->id)
                                ->limit(10)
                                ->latest()
                                ->get();

            $attendanceRate = Attendance::getRate($member->id);

            $isInGym = Attendance::isInGym($member->id);
        }

        return view('member.dashboard', compact(
            'title',
            'user',
            'member',
            'currentSubscription',
            'recentAttendance',
            'attendanceRate',
            'isInGym'
        ));
    }


    /* =========================
        PROFILE
    ========================= */
    public function profile()
    {
        $title = 'My Profile';

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        return view('member.profile', compact(
            'title',
            'user',
            'member'
        ));
    }


    /* =========================
        UPDATE PROFILE
    ========================= */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        // Update User
        $user->update([
            'name' => $request->name,
        ]);

        // Update Member
        if ($member) {

            $member->update([
                'phone'             => $request->phone,
                'address'           => $request->address,
                'emergency_contact' => $request->emergency_contact,
                'emergency_phone'   => $request->emergency_phone,
            ]);
        }

        return redirect()
            ->route('member.profile')
            ->with('success', 'Profile updated successfully!');
    }


    /* =========================
        MEMBERSHIP PLANS
    ========================= */
    public function membershipPlans()
    {
        $title = 'Membership Plans';

        $plans = MembershipPlan::active()->orderPrice()->get();

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        $currentSubscription = null;

        if ($member) {
            $currentSubscription =
                MemberSubscription::activeByMember($member->id);
        }

        return view('member.membership_plans', compact(
            'title',
            'plans',
            'member',
            'currentSubscription'
        ));
    }


    /* =========================
        MY SUBSCRIPTIONS
    ========================= */
    public function mySubscriptions()
    {
        $title = 'My Subscriptions';

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        $subscriptions = [];

        if ($member) {
            $subscriptions = MemberSubscription::where('member_id', $member->id)
                            ->latest()
                            ->get();
        }

        return view('member.subscriptions', compact(
            'title',
            'subscriptions',
            'member'
        ));
    }


    /* =========================
        MY ATTENDANCE
    ========================= */
    public function myAttendance()
    {
        $title = 'My Attendance';

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        $attendance = [];
        $attendanceRate = 0;
        $isInGym = false;

        if ($member) {

            $attendance = Attendance::byMember($member->id)
                            ->latest()
                            ->get();

            $attendanceRate = Attendance::getRate($member->id);

            $isInGym = Attendance::isInGym($member->id);
        }

        return view('member.attendance', compact(
            'title',
            'attendance',
            'attendanceRate',
            'isInGym',
            'member'
        ));
    }


    /* =========================
        REPORT FORM
    ========================= */
    public function reportForm()
    {
        $title = 'Laporan Member';

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        $categories = [
            'facility'   => 'Fasilitas Gym',
            'equipment'  => 'Peralatan',
            'service'    => 'Pelayanan',
            'cleanliness'=> 'Kebersihan',
            'staff'      => 'Staff/Trainer',
            'suggestion' => 'Saran & Masukan',
            'complaint'  => 'Keluhan',
            'other'      => 'Lainnya'
        ];

        return view('member.report', compact(
            'title',
            'user',
            'member',
            'categories'
        ));
    }


    /* =========================
        SUBMIT REPORT
    ========================= */
    public function submitReport(Request $request)
    {
        $request->validate([
            'category'    => 'required',
            'subject'     => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->firstOrFail();

        MemberReport::create([
            'member_id'  => $member->id,
            'category'   => $request->category,
            'subject'    => $request->subject,
            'description'=> $request->description,
            'priority'   => $request->priority ?? 'Medium',
            'status'     => 'Open',
        ]);

        return redirect()
            ->route('member.report')
            ->with('success', 'Laporan berhasil dikirim!');
    }


    /* =========================
        MY REPORTS
    ========================= */
    public function myReports()
    {
        $title = 'Laporan Saya';

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->first();

        $reports = [];

        if ($member) {
            $reports = MemberReport::where('member_id', $member->id)
                        ->latest()
                        ->get();
        }

        return view('member.my_reports', compact(
            'title',
            'reports',
            'member'
        ));
    }


    /* =========================
        CHECK IN
    ========================= */
    public function checkIn()
    {
        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->firstOrFail();

        // Cek subscription
        if (!MemberSubscription::activeByMember($member->id)) {

            return redirect()
                ->route('member.plans')
                ->with('error', 'You need an active membership!');
        }

        if (!Attendance::checkIn($member->id)) {

            return back()
                ->with('error', 'You are already checked in!');
        }

        return back()
            ->with('success', 'Checked in successfully!');
    }


    /* =========================
        CHECK OUT
    ========================= */
    public function checkOut()
    {
        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->firstOrFail();

        if (!Attendance::checkOut($member->id)) {

            return back()
                ->with('error', 'You are not checked in!');
        }

        return back()
            ->with('success', 'Checked out successfully!');
    }


    /* =========================
        CHANGE PASSWORD
    ========================= */
    public function changePasswordForm()
    {
        $title = 'Change Password';

        return view('member.change_password', compact('title'));
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {

            return back()
                ->with('error', 'Current password is incorrect!');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()
            ->route('member.profile')
            ->with('success', 'Password changed successfully!');
    }


    /* =========================
        SUBSCRIBE FORM
    ========================= */
    public function subscribe($id)
    {
        $plan = MembershipPlan::active()->findOrFail($id);

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->firstOrFail();

        if (MemberSubscription::activeByMember($member->id)) {

            return redirect()
                ->route('member.plans')
                ->with('warning', 'You already have an active plan!');
        }

        $title = 'Subscribe to ' . $plan->plan_name;

        return view('member.subscribe', compact(
            'title',
            'plan',
            'member'
        ));
    }


    /* =========================
        PROCESS SUBSCRIBE
    ========================= */
    public function processSubscription(Request $request)
    {
        $request->validate([
            'plan_id'        => 'required|exists:membership_plans,id',
            'payment_method'=> 'required',
        ]);

        $plan = MembershipPlan::active()
                ->findOrFail($request->plan_id);

        $user = Auth::user();

        $member = Member::where('user_id', $user->id)->firstOrFail();

        if (MemberSubscription::activeByMember($member->id)) {

            return back()
                ->with('warning', 'You already have an active plan!');
        }

        $start = now();

        $end = now()->addMonths($plan->duration_months);

        MemberSubscription::create([
            'member_id'           => $member->id,
            'membership_plan_id'  => $plan->id,
            'start_date'          => $start,
            'end_date'            => $end,
            'amount_paid'         => $plan->price,
            'payment_status'      => 'Paid',
            'payment_date'        => now(),
        ]);

        return redirect()
            ->route('member.subscriptions')
            ->with('success', 'Subscription successful!');
    }

}