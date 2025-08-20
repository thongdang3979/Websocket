<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url', 'string']);
    }

    /**
     * User payment view - shows QR code and payment status
     */
    public function index() {
        // Generate or get existing payment
        $payment_id = $this->input->get('payment_id');

        if (!$payment_id) {
            // Create new payment
            $payment_id = $this->create_payment();
            redirect('payment?payment_id=' . $payment_id);
        }

        $payment = $this->get_payment($payment_id);

        if (!$payment) {
            show_404();
        }

        $data = [
            'payment' => $payment,
            'websocket_url' => 'ws://localhost:8080/websocket'  // Fixed: Added /websocket path
        ];

        $this->load->view('payment/user', $data);
    }

    /**
     * Admin view - manage payments
     */
    public function admin() {
        // Simple admin check - implement your own authentication
        if (!$this->session->userdata('is_admin')) {
            redirect('payment/admin_login');
        }

        $payments = $this->get_all_payments();

        $data = [
            'payments' => $payments,
            'websocket_url' => 'ws://localhost:8080/websocket'
        ];

        $this->load->view('payment/admin', $data);
    }

    /**
     * Simple admin login (for demo purposes)
     */
    public function admin_login() {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Simple hardcoded check - implement your own authentication
            if ($username === 'admin' && $password === 'admin123') {
                $this->session->set_userdata('is_admin', true);
                redirect('payment/admin');
            } else {
                $data['error'] = 'Invalid credentials';
            }
        }

        $this->load->view('payment/admin_login', isset($data) ? $data : []);
    }

    /**
     * AJAX endpoint to update payment status
     */
    public function update_status() {
        if (!$this->session->userdata('is_admin')) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $payment_id = $this->input->post('payment_id');
        $status = $this->input->post('status');

        $allowed_statuses = ['pending', 'completed', 'failed', 'expired'];

        if (!in_array($status, $allowed_statuses)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid status']);
            return;
        }

        $result = $this->db->where('payment_id', $payment_id)
            ->update('payments', [
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update payment']);
        }
    }

    /**
     * Get payment status (AJAX endpoint)
     */
    public function get_status($payment_id) {
        $payment = $this->get_payment($payment_id);

        if (!$payment) {
            http_response_code(404);
            echo json_encode(['error' => 'Payment not found']);
            return;
        }

        echo json_encode([
            'payment_id' => $payment->payment_id,
            'status' => $payment->status,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'updated_at' => $payment->updated_at
        ]);
    }

    /**
     * Create new payment
     */
    private function create_payment() {
        $payment_id = 'PAY_' . strtoupper(random_string('alnum', 12));
        $amount = 99.99; // Demo amount - you can make this dynamic

        // Generate QR code data (you can use a QR library or service)
        $qr_data = "PAYMENT:{$payment_id}:AMOUNT:{$amount}:URL:" . base_url("payment?payment_id={$payment_id}");

        $data = [
            'payment_id' => $payment_id,
            'amount' => $amount,
            'currency' => 'USD',
            'status' => 'pending',
            'user_session' => $this->session->session_id,
            'qr_code_data' => $qr_data,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('payments', $data);

        return $payment_id;
    }

    /**
     * Payment success page
     */
    public function success() {
        $payment_id = $this->input->get('payment_id');

        if (!$payment_id) {
            redirect('payment');
        }

        $payment = $this->get_payment($payment_id);

        if (!$payment || $payment->status !== 'completed') {
            redirect('payment?payment_id=' . $payment_id);
        }

        $data = [
            'payment' => $payment
        ];

        $this->load->view('payment/success', $data);
    }

    /**
     * Get payment by ID
     */
    private function get_payment($payment_id) {
        return $this->db->where('payment_id', $payment_id)
            ->get('payments')
            ->row();
    }

    /**
     * Get all payments for admin
     */
    private function get_all_payments() {
        return $this->db->order_by('created_at', 'DESC')
            ->limit(50)
            ->get('payments')
            ->result();
    }
}