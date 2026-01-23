<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
    private $server_key;
    private $client_key;
    private $is_production;
    private $midtrans_url;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Membership_Plan_model', 'membership_plan');
        $this->load->model('Member_Subscription_model', 'member_subscription');
        $this->load->model('Gym_Member_model', 'gym_member');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->dbforge();
        $this->load->database();

        // Midtrans Configuration (Development Mode)
        // Using Midtrans public demo credentials for testing
        $this->server_key = 'SB-Mid-server-rrHhwl-lwOLrwJkroPggJyUw'; // Working demo server key
        $this->client_key = 'SB-Mid-client-nKsqvar5cn60u2Lv'; // Working demo client key
        $this->is_production = false; // Set to true for production
        $this->midtrans_url = $this->is_production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Create payment-related columns if they don't exist
        $this->create_payment_columns();
    }

    // Create payment transaction
    public function create_transaction()
    {
        $plan_id = $this->input->post('plan_id');
        $member_id = $this->input->post('member_id');

        if (!$plan_id || !$member_id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Missing required parameters']));
            return;
        }

        // Get plan details
        $plan = $this->membership_plan->getPlanById($plan_id);
        if (!$plan) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Plan not found']));
            return;
        }

        // Get member details
        $member = $this->gym_member->getMemberById($member_id);
        if (!$member) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Member not found']));
            return;
        }

        // Get user details
        $user = $this->db->get_where('user', ['id' => $member['user_id']])->row_array();

        // Generate unique order ID
        $order_id = 'GYM-' . $member['member_code'] . '-' . time();

        // Create pending subscription record
        $subscription_data = [
            'member_id' => $member_id,
            'membership_plan_id' => $plan_id,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+' . $plan['duration_months'] . ' months')),
            'amount_paid' => $plan['price'],
            'payment_status' => 'Pending',
            'payment_method' => 'midtrans',
            'order_id' => $order_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $subscription_id = $this->member_subscription->createSubscription($subscription_data);

        // Prepare Midtrans transaction data
        $transaction_data = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => (int)$plan['price']
            ],
            'customer_details' => [
                'first_name' => $user['name'] ?? 'Member',
                'email' => $user['email'] ?? 'member@gym.com',
                'phone' => $member['phone'] ?? '08123456789'
            ],
            'item_details' => [
                [
                    'id' => 'membership_' . $plan['id'],
                    'price' => (int)$plan['price'],
                    'quantity' => 1,
                    'name' => $plan['plan_name'] ?? 'Gym Membership',
                    'category' => 'membership'
                ]
            ]
        ];

        // Add callbacks for web interface
        if (!$this->input->is_ajax_request()) {
            $transaction_data['callbacks'] = [
                'finish' => base_url('payment/finish'),
                'unfinish' => base_url('payment/unfinish'),
                'error' => base_url('payment/error')
            ];
        }

        // Create Snap Token
        $snap_token = $this->create_snap_token($transaction_data);

        if ($snap_token) {
            // Update subscription with snap token
            $this->member_subscription->updateSubscription($subscription_id, ['snap_token' => $snap_token]);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'snap_token' => $snap_token,
                    'order_id' => $order_id,
                    'subscription_id' => $subscription_id
                ]));
        } else {
            // Log the error for debugging
            error_log("Failed to create Midtrans snap token for order: " . $order_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Failed to create payment token. Please check your internet connection and try again.',
                    'debug_info' => [
                        'order_id' => $order_id,
                        'server_key_prefix' => substr($this->server_key, 0, 20) . '...',
                        'midtrans_url' => $this->midtrans_url
                    ]
                ]));
        }
    }

    // Create Snap Token using Midtrans API
    private function create_snap_token($transaction_data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->midtrans_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($transaction_data),
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->server_key . ':')
            ],
            CURLOPT_SSL_VERIFYPEER => false, // For local development
            CURLOPT_SSL_VERIFYHOST => false  // For local development
        ]);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);

        // Log the response for debugging
        error_log("Midtrans API Response: HTTP $http_code");
        error_log("Midtrans API Response Body: " . $response);
        error_log("Midtrans API URL: " . $this->midtrans_url);
        error_log("Transaction Data: " . json_encode($transaction_data));

        if ($curl_error) {
            error_log("CURL Error: " . $curl_error);
            return null;
        }

        if ($http_code == 201) {
            $result = json_decode($response, true);
            return $result['token'] ?? null;
        } else {
            error_log("Midtrans API Error: HTTP $http_code - " . $response);
            return null;
        }
    }

    // Payment notification webhook
    public function notification()
    {
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result, true);

        if (!$result) {
            http_response_code(400);
            echo 'Invalid JSON';
            return;
        }

        $order_id = $result['order_id'];
        $status_code = $result['status_code'];
        $gross_amount = $result['gross_amount'];
        $signature_key = $result['signature_key'];

        // Verify signature
        $input = $order_id . $status_code . $gross_amount . $this->server_key;
        $signature = openssl_digest($input, 'sha512');

        if ($signature != $signature_key) {
            http_response_code(400);
            echo 'Invalid signature';
            return;
        }

        // Get subscription by order_id
        $subscription = $this->member_subscription->getSubscriptionByOrderId($order_id);
        if (!$subscription) {
            http_response_code(404);
            echo 'Subscription not found';
            return;
        }

        $transaction_status = $result['transaction_status'];
        $fraud_status = $result['fraud_status'] ?? '';

        // Update subscription status based on transaction status
        if ($transaction_status == 'capture') {
            if ($fraud_status == 'challenge') {
                $payment_status = 'Challenge';
            } else if ($fraud_status == 'accept') {
                $payment_status = 'Paid';
            }
        } else if ($transaction_status == 'settlement') {
            $payment_status = 'Paid';
        } else if ($transaction_status == 'cancel' || $transaction_status == 'deny' || $transaction_status == 'expire') {
            $payment_status = 'Failed';
        } else if ($transaction_status == 'pending') {
            $payment_status = 'Pending';
        } else {
            $payment_status = 'Unknown';
        }

        // Update subscription
        $update_data = [
            'payment_status' => $payment_status,
            'transaction_status' => $transaction_status,
            'payment_date' => ($payment_status == 'Paid') ? date('Y-m-d H:i:s') : null
        ];

        $this->member_subscription->updateSubscription($subscription['id'], $update_data);

        echo 'OK';
    }

    // Payment finish page
    public function finish()
    {
        $order_id = $this->input->get('order_id');
        $status_code = $this->input->get('status_code');
        $transaction_status = $this->input->get('transaction_status');

        $data['title'] = 'Payment Result';
        $data['order_id'] = $order_id;
        $data['status_code'] = $status_code;
        $data['transaction_status'] = $transaction_status;

        // Get subscription details
        if ($order_id) {
            $data['subscription'] = $this->member_subscription->getSubscriptionByOrderId($order_id);
        }

        $this->load->view('payment/finish', $data);
    }

    // Payment unfinish page
    public function unfinish()
    {
        $data['title'] = 'Payment Unfinished';
        $this->load->view('payment/unfinish', $data);
    }

    // Payment error page
    public function error()
    {
        $data['title'] = 'Payment Error';
        $this->load->view('payment/error', $data);
    }

    // Get Midtrans client key for frontend
    public function get_client_key()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['client_key' => $this->client_key]));
    }

    // Test Midtrans connection
    public function test_connection()
    {
        // Simple test transaction data
        $test_data = [
            'transaction_details' => [
                'order_id' => 'TEST-' . time(),
                'gross_amount' => 10000
            ],
            'customer_details' => [
                'first_name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '08123456789'
            ],
            'item_details' => [
                [
                    'id' => 'test_item',
                    'price' => 10000,
                    'quantity' => 1,
                    'name' => 'Test Membership'
                ]
            ]
        ];

        $snap_token = $this->create_snap_token($test_data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => $snap_token ? 'success' : 'failed',
                'message' => $snap_token ? 'Midtrans connection successful' : 'Midtrans connection failed',
                'snap_token' => $snap_token ? substr($snap_token, 0, 20) . '...' : null,
                'server_key_prefix' => substr($this->server_key, 0, 20) . '...',
                'client_key_prefix' => substr($this->client_key, 0, 20) . '...',
                'midtrans_url' => $this->midtrans_url,
                'test_data' => $test_data
            ]));
    }

    // Create payment-related columns in member_subscriptions table
    private function create_payment_columns()
    {
        // Check if columns exist, if not add them
        $fields = $this->db->field_data('member_subscriptions');
        $existing_fields = array_column($fields, 'name');

        $new_fields = [];

        if (!in_array('order_id', $existing_fields)) {
            $new_fields['order_id'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ];
        }

        if (!in_array('snap_token', $existing_fields)) {
            $new_fields['snap_token'] = [
                'type' => 'TEXT',
                'null' => TRUE
            ];
        }

        if (!in_array('transaction_status', $existing_fields)) {
            $new_fields['transaction_status'] = [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ];
        }

        if (!in_array('payment_method', $existing_fields)) {
            $new_fields['payment_method'] = [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ];
        }

        if (!in_array('created_at', $existing_fields)) {
            $new_fields['created_at'] = [
                'type' => 'DATETIME',
                'null' => TRUE
            ];
        }

        if (!empty($new_fields)) {
            $this->dbforge->add_column('member_subscriptions', $new_fields);
        }
    }

    // Debug payment creation
    public function debug_payment()
    {
        $plan_id = $this->input->get('plan_id') ?: 1;
        $member_id = $this->input->get('member_id') ?: 1;

        $debug_info = [];

        // Test 1: Check plan
        $plan = $this->membership_plan->getPlanById($plan_id);
        $debug_info['plan'] = $plan ? 'Found' : 'Not found';
        $debug_info['plan_data'] = $plan;

        // Test 2: Check member
        $member = $this->gym_member->getMemberById($member_id);
        $debug_info['member'] = $member ? 'Found' : 'Not found';
        $debug_info['member_data'] = $member;

        // Test 3: Check user
        if ($member) {
            $user = $this->db->get_where('user', ['id' => $member['user_id']])->row_array();
            $debug_info['user'] = $user ? 'Found' : 'Not found';
            $debug_info['user_data'] = $user;
        }

        // Test 4: Configuration
        $debug_info['config'] = [
            'server_key_prefix' => substr($this->server_key, 0, 20) . '...',
            'client_key_prefix' => substr($this->client_key, 0, 20) . '...',
            'midtrans_url' => $this->midtrans_url,
            'is_production' => $this->is_production
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($debug_info, JSON_PRETTY_PRINT));
    }
}
