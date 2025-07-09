<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Complaint_model');
        $this->load->library('session');
        $this->load->model('Auth_model');
    }

    // Proses submit dari form contact-us
    public function submit() {
        // Check if user is logged in (either customer or admin)
        if (!$this->session->userdata('customer_id') && !$this->session->userdata('user_id')) {
            redirect('index.php/Auth/signin');
        }

        // Get customer data if logged in as customer
        $customer_id = $this->session->userdata('customer_id');
        $customer = null;
        
        if ($customer_id) {
            $customer = $this->Auth_model->get_customer_by_id($customer_id, true);
        }

        // Prepare data for submission
        $data = [
            'name'    => $customer ? $customer->nama_lengkap : $this->input->post('name'),
            'email'   => $customer ? $customer->email : $this->input->post('email'),
            'subject' => $this->input->post('subject'),
            'rating'  => $this->input->post('rating'),
            'message' => $this->input->post('message'),
            'customer_id' => $customer_id // Add customer_id to track who submitted
        ];

        $this->Complaint_model->submit($data);
        $this->session->set_flashdata('success', 'Thank you for your feedback!');
        redirect(base_url('index.php/Welcome/landing#contact-us'));
    }

    // Halaman admin untuk melihat semua kritik & saran
    public function admin() {
        // Check if user is admin
        if (!$this->session->userdata('user_id') || !$this->session->userdata('role')) {
            redirect('index.php/Auth/signin');
        }
        
        $data['complaints'] = $this->Complaint_model->get_all();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('complaints/index', $data);
        $this->load->view('template/footer');
    }

    // Hapus pesan
    public function delete($id) {
        // Check if user is admin
        if (!$this->session->userdata('user_id') || !$this->session->userdata('role')) {
            redirect('index.php/Auth/signin');
        }
        
        $this->Complaint_model->delete($id);
        $this->session->set_flashdata('success', 'Pesan berhasil dihapus.');
        redirect('index.php/Complaint/admin');
    }
}
