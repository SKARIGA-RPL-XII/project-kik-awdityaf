<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\GymMember;

class PaymentController extends Controller
{
    private string $serverKey;
    private string $clientKey;
    private bool $isProduction;
    private string $midtransUrl;

    public function __construct()
    {
        $this->middleware('auth');

        $this->serverKey = config('services.midtrans.server_key');
        $this->clientKey = config('services.midtrans.client_key');
        $this->isProduction = config('services.midtrans.is_production');

        $this->midtransUrl = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
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
        $member = GymMember::with('user')->find($request->member_id);

        if (!$plan || !$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Plan or Member not found'
            ], 404);
        }

        $orderId = 'GYM-' . $member->member_code . '-' . time();

        // Create subscription
        $subscription = MemberSubscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonths($plan->duration_months),
            'amount_paid' => $plan->price,
            'payment_status' => 'Pending',
            'payment_method' => 'midtrans',
            'order_id' => $orderId,
            'created_at' => now()
        ]);

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int)$plan->price
            ],

            'customer_details' => [
                'first_name' => $member->user->name ?? 'Member',
                'email' => $member->user->email ?? 'member@gym.com',
                'phone' => $member->phone ?? '08123456789'
            ],

            'item_details' => [[
                'id' => 'membership_' . $plan->id,
                'price' => (int)$plan->price,
                'quantity' => 1,
                'name' => $plan->plan_name
            ]]
        ];

        $snapToken = $this->createSnapToken($payload);

        if (!$snapToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed create payment token'
            ], 500);
        }

        $subscription->update([
            'snap_token' => $snapToken
        ]);

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken,
            'order_id' => $orderId,
            'subscription_id' => $subscription->id
        ]);
    }

    // ===============================
    // CREATE SNAP TOKEN
    // ===============================
    private function createSnapToken(array $data)
    {
        try {

            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json'
                ])
                ->post($this->midtransUrl, $data);

            Log::info('Midtrans Response', $response->json());

            if ($response->status() == 201) {
                return $response->json('token');
            }

            return null;

        } catch (\Exception $e) {

            Log::error('Midtrans Error: ' . $e->getMessage());

            return null;
        }
    }

    // ===============================
    // WEBHOOK NOTIFICATION
    // ===============================
    public function notification(Request $request)
    {
        $data = $request->all();

        $signature = hash(
            'sha512',
            $data['order_id'] .
            $data['status_code'] .
            $data['gross_amount'] .
            $this->serverKey
        );

        if ($signature !== $data['signature_key']) {
            return response('Invalid signature', 400);
        }

        $subscription = MemberSubscription::where('order_id', $data['order_id'])->first();

        if (!$subscription) {
            return response('Not found', 404);
        }

        $status = match ($data['transaction_status']) {

            'capture' => $data['fraud_status'] === 'accept' ? 'Paid' : 'Challenge',

            'settlement' => 'Paid',

            'pending' => 'Pending',

            'deny', 'cancel', 'expire' => 'Failed',

            default => 'Unknown'
        };

        $subscription->update([
            'payment_status' => $status,
            'transaction_status' => $data['transaction_status'],
            'payment_date' => $status === 'Paid' ? now() : null
        ]);

        return response('OK');
    }

    // ===============================
    // FINISH PAGE
    // ===============================
    public function finish(Request $request)
    {
        $subscription = MemberSubscription::where('order_id', $request->order_id)->first();

        return view('payment.finish', [
            'title' => 'Payment Result',
            'subscription' => $subscription,
            'order_id' => $request->order_id,
            'status_code' => $request->status_code,
            'transaction_status' => $request->transaction_status
        ]);
    }

    // ===============================
    // CLIENT KEY
    // ===============================
    public function getClientKey()
    {
        return response()->json([
            'client_key' => $this->clientKey
        ]);
    }

    // ===============================
    // TEST CONNECTION
    // ===============================
    public function test()
    {
        $payload = [
            'transaction_details' => [
                'order_id' => 'TEST-' . time(),
                'gross_amount' => 10000
            ]
        ];

        $token = $this->createSnapToken($payload);

        return response()->json([
            'status' => $token ? 'success' : 'failed',
            'token' => $token
        ]);
    }
}