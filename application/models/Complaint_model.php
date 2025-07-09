<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function submit($data) {
        return $this->db->insert('complaints_suggestions', $data);
    }
    public function get_all() {
        // Join with customers table to get customer information
        $this->db->select('complaints_suggestions.*, customers.nama_lengkap as customer_name, customers.email as customer_email');
        $this->db->from('complaints_suggestions');
        $this->db->join('customers', 'customers.customer_id = complaints_suggestions.customer_id', 'left');
        $this->db->order_by('complaints_suggestions.created_at', 'DESC');
        return $this->db->get()->result();
    }
    public function get_by_customer_id($customer_id) {
        // Get complaints by specific customer
        $this->db->where('customer_id', $customer_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('complaints_suggestions')->result();
    }
    public function delete($id) {
        return $this->db->delete('complaints_suggestions', ['id' => $id]);
    }
} 