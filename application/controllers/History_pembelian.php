<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History_pembelian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model yang diperlukan
        $this->load->model('Penjualan_model');
        $this->load->model('Customer_model');
        $this->load->library('session');

        // Cek apakah customer sudah login
        if (!$this->session->userdata('customer_id')) {
            redirect('index.php/Auth/login');
        }
    }

    public function index() {
        // Get filter parameters
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $status_bayar = $this->input->get('status_bayar');
        
        // Get customer ID from session
        $customer_id = $this->session->userdata('customer_id');
        
        // Get purchase history
        $data['history_pembelian'] = $this->Penjualan_model->get_purchase_history($customer_id, $date_start, $date_end, $status_bayar);
        $data['title'] = 'History Pembelian';
        
        $this->load->view('history_pembelian', $data);
    }

    public function detail($penjualan_id) {
        // Get customer ID from session
        $customer_id = $this->session->userdata('customer_id');
        
        // Get purchase detail
        $data['detail_pembelian'] = $this->Penjualan_model->get_purchase_detail($penjualan_id, $customer_id);
        
        if (!$data['detail_pembelian']) {
            $this->session->set_flashdata('error', 'Data pembelian tidak ditemukan');
            redirect('index.php/history_pembelian');
        }
        
        $data['title'] = 'Detail Pembelian';
        
        $this->load->view('detail_pembelian', $data);
    }

    public function print_invoice($penjualan_id) {
        // Get customer ID from session
        $customer_id = $this->session->userdata('customer_id');
        
        // Get purchase detail
        $data['detail_pembelian'] = $this->Penjualan_model->get_purchase_detail($penjualan_id, $customer_id);
        
        if (!$data['detail_pembelian']) {
            $this->session->set_flashdata('error', 'Data pembelian tidak ditemukan');
            redirect('index.php/history_pembelian');
        }
        
        // Load view khusus untuk print
        $this->load->view('print_invoice', $data);
    }
} 