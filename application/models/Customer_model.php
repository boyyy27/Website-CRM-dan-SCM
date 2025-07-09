<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all customers
     * @return array
     */
    public function get_all_customers() {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->order_by('customer_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Add new customer
     * @param array $data
     * @return bool
     */
    public function add_customer($data) {
        try {
            // Generate customer code
            $data['kode_customer'] = $this->generate_customer_code();
            
            // Set default values
            $data['total_pembelian'] = 0;
            $data['poin_loyalty'] = 0;
            $data['verifikasi_umur'] = 0;
            $data['tanggal_daftar'] = date('Y-m-d');
            
            // Insert data
            $this->db->insert('customers', $data);
            return ($this->db->affected_rows() > 0);
        } catch (Exception $e) {
            log_message('error', 'Database error in add_customer: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update customer
     * @param int $customer_id
     * @param array $data
     * @return bool
     */
    public function update_customer($customer_id, $data) {
        try {
            $this->db->where('customer_id', $customer_id);
            $this->db->update('customers', $data);
            return ($this->db->affected_rows() > 0);
        } catch (Exception $e) {
            log_message('error', 'Database error in update_customer: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete customer
     * @param int $customer_id
     * @return bool
     */
    public function delete_customer($customer_id) {
        try {
            $this->db->where('customer_id', $customer_id);
            $this->db->delete('customers');
            return ($this->db->affected_rows() > 0);
        } catch (Exception $e) {
            log_message('error', 'Database error in delete_customer: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate unique customer code
     * @return string
     */
    private function generate_customer_code() {
        // Get the last customer code
        $this->db->select('kode_customer');
        $this->db->from('customers');
        $this->db->order_by('customer_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $last_code = $query->row()->kode_customer;
            // Extract the number part and increment
            $number = intval(substr($last_code, 4)) + 1;
        } else {
            $number = 1;
        }
        
        // Format: CUST001, CUST002, etc.
        return 'CUST' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function get_customer_by_id($id) {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('customer_id', $id);
        return $this->db->get()->row();
    }

    public function update_total_pembelian($customer_id, $jumlah_tambah)
    {
        // Tambah total_pembelian pada customer
        $this->db->set('total_pembelian', 'total_pembelian + ' . floatval($jumlah_tambah), FALSE);
        $this->db->where('customer_id', $customer_id);
        return $this->db->update('customers');
    }

    public function get_total_customers() {
        return $this->db->count_all('customers');
    }
} 