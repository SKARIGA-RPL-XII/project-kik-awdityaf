<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Transaction;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function createSnapToken(Transaction $transaction)
    {
        $member = $transaction->member;
        $plan = $transaction->plan;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $member->user->name ?? 'Member',
                'email' => $member->user->email ?? 'member@gym.com',
                'phone' => $member->phone ?? '08123456789',
            ],
            'item_details' => [[
                'id' => 'membership_' . $plan->id,
                'price' => (int) $transaction->amount,
                'quantity' => 1,
                'name' => $plan->plan_name,
            ]]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return null;
        }
    }

    public function handleNotification()
    {
        try {
            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            $status = 'pending';

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $status = 'pending';
                    } else {
                        $status = 'success';
                    }
                }
            } else if ($transaction == 'settlement') {
                $status = 'success';
            } else if ($transaction == 'pending') {
                $status = 'pending';
            } else if ($transaction == 'deny') {
                $status = 'failed';
            } else if ($transaction == 'expire') {
                $status = 'failed';
            } else if ($transaction == 'cancel') {
                $status = 'failed';
            }

            return [
                'order_id' => $orderId,
                'status' => $status,
                'raw_status' => $transaction,
                'payment_type' => $type
            ];
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return null;
        }
    }
    public function checkStatus($orderId)
    {
        try {
            $statusResponse = \Midtrans\Transaction::status($orderId);
            
            $transaction = $statusResponse->transaction_status;
            $type = $statusResponse->payment_type;
            $fraud = $statusResponse->fraud_status ?? '';

            $status = 'pending';

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $status = 'pending';
                    } else {
                        $status = 'success';
                    }
                }
            } else if ($transaction == 'settlement') {
                $status = 'success';
            } else if ($transaction == 'pending') {
                $status = 'pending';
            } else if ($transaction == 'deny') {
                $status = 'failed';
            } else if ($transaction == 'expire') {
                $status = 'failed';
            } else if ($transaction == 'cancel') {
                $status = 'failed';
            }

            return [
                'order_id' => $orderId,
                'status' => $status,
                'raw_status' => $transaction,
                'payment_type' => $type
            ];
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Check Status Error: ' . $e->getMessage());
            return null;
        }
    }
}
