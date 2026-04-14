<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Member;
use App\Models\Transaction;
use App\Services\MidtransService;

class PaymentController extends Controller
{
    private MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        // Notification doesn't need auth, so we specify middleware only for member actions
        $this->middleware('auth')->except(['notification']);

        $this->midtransService = $midtransService;
    }

    // ===============================
    // CREATE TRANSACTION
    // ===============================
    public function createTransaction(Request $request)
    {
        $request->validate([
            'plan_id'   => 'required|integer',
            'member_id' => 'required|integer'
        ]);

        $plan = MembershipPlan::find($request->plan_id);
        $member = Member::with('user')->find($request->member_id);

        if (!$plan || !$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Plan or Member not found'
            ], 404);
        }

        // Generate robust unique order id
        $orderId = 'GYM-' . $member->member_code . '-' . time() . '-' . \Illuminate\Support\Str::random(4);

        // Create transaction record
        $transaction = Transaction::create([
            'order_id' => $orderId,
            'member_id' => $member->id,
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'pending',
            'payment_method' => 'midtrans',
        ]);

        // Interact with Midtrans Service
        $snapToken = $this->midtransService->createSnapToken($transaction);

        if (!$snapToken) {
            $transaction->delete(); // Rollback
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat token pembayaran. Pastikan API key Midtrans valid.'
            ], 500);
        }

        $transaction->update([
            'snap_token' => $snapToken
        ]);

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken,
            'order_id' => $orderId,
        ]);
    }

    private function processPaymentStatus(array $payload)
    {
        $transaction = Transaction::where('order_id', $payload['order_id'])->first();

        if (!$transaction) {
            return false;
        }

        if ($transaction->status !== 'success' && $payload['status'] === 'success') {
            $transaction->update([
                'status' => $payload['status'],
                'payment_method' => $payload['payment_type'] ?? 'midtrans',
            ]);

            // Activate subscription
            $existingSub = MemberSubscription::where('order_id', $transaction->order_id)->first();

            if (!$existingSub) {
                $plan = $transaction->plan;

                MemberSubscription::create([
                    'member_id' => $transaction->member_id,
                    'membership_plan_id' => $transaction->plan_id,
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addMonths($plan->duration_months),
                    'amount_paid' => $transaction->amount,
                    'payment_status' => 'Paid',
                    'payment_method' => $transaction->payment_method,
                    'order_id' => $transaction->order_id,
                    'snap_token' => $transaction->snap_token,
                    'transaction_status' => 'settlement',
                    'payment_date' => now(),
                    'created_at' => now()
                ]);
            }
        } elseif ($transaction->status !== $payload['status']) {
            $transaction->update([
                'status' => $payload['status'],
                'payment_method' => $payload['payment_type'] ?? 'midtrans',
            ]);
        }

        return $transaction;
    }

    // ===============================
    // WEBHOOK NOTIFICATION
    // ===============================
    public function notification(Request $request)
    {
        $payload = $this->midtransService->handleNotification();

        if (!$payload) {
            return response('Error processing notification', 500);
        }

        $this->processPaymentStatus($payload);

        return response('OK', 200);
    }

    // ===============================
    // FINISH PAGE
    // ===============================
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        
        $transaction = Transaction::with('plan')->where('order_id', $orderId)->first();

        // Local environment fallback: if transaction is still pending, proactively check Midtrans API
        if ($transaction && $transaction->status === 'pending') {
            $payload = $this->midtransService->checkStatus($orderId);
            if ($payload) {
                $transaction = $this->processPaymentStatus($payload);
            }
        }

        return view('payment.finish', [
            'title' => 'Payment Result',
            'transaction' => $transaction,
            'order_id' => $request->order_id,
            'status_code' => $request->status_code,
            'transaction_status' => $request->transaction_status
        ]);
    }

    // ===============================
    // TEST CONNECTION
    // ===============================
    public function test()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Integrasi midtrans via Service siap digunakan.'
        ]);
    }
}
