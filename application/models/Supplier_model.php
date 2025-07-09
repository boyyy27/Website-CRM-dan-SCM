<?php
class Supplier_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Get all suppliers from the database
    public function get_all_suppliers()
    {
        $this->db->order_by('supplier_id', 'DESC');
        $query = $this->db->get('suppliers');
        return $query->result_array();
    }

    // Get a specific supplier by ID
    public function get_supplier_by_id($id)
    {
        $this->db->where('supplier_id', $id);
        $query = $this->db->get('suppliers');
        return $query->row_array();
    }

    // Create a new supplier in the database
    public function create_supplier($data)
    {
        return $this->db->insert('suppliers', $data);
    }

    // Update an existing supplier
    public function update_supplier($id, $data)
    {
        $this->db->where('supplier_id', $id);
        return $this->db->update('suppliers', $data);
    }

    // Delete a supplier by ID
    public function delete_supplier($id)
    {
        $this->db->where('supplier_id', $id);
        return $this->db->delete('suppliers');
    }

    // Check if supplier exists by ID
    public function supplier_exists($id)
    {
        $this->db->where('supplier_id', $id);
        $query = $this->db->get('suppliers');
        return $query->num_rows() > 0;
    }

    // Get suppliers by status (active/inactive)
    public function get_suppliers_by_status($status)
    {
        $this->db->where('status', $status);
        $this->db->order_by('nama_supplier', 'ASC');
        $query = $this->db->get('suppliers');
        return $query->result_array();
    }

    // Get active suppliers only (useful for dropdowns)
    public function get_active_suppliers()
    {
        return $this->get_suppliers_by_status('aktif');
    }

    // Search suppliers by name
    public function search_suppliers($keyword)
    {
        $this->db->like('nama_supplier', $keyword);
        $this->db->or_like('kontak_person', $keyword);
        $this->db->or_like('kota', $keyword);
        $this->db->order_by('nama_supplier', 'ASC');
        $query = $this->db->get('suppliers');
        return $query->result_array();
    }

    // Count total suppliers
    public function count_suppliers()
    {
        return $this->db->count_all('suppliers');
    }

    // Count suppliers by status
    public function count_suppliers_by_status($status)
    {
        $this->db->where('status', $status);
        return $this->db->count_all_results('suppliers');
    }

    // Get suppliers with pagination
    public function get_suppliers_paginated($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $this->db->order_by('supplier_id', 'DESC');
        $query = $this->db->get('suppliers');
        return $query->result_array();
    }

    // Check if supplier name already exists (for validation)
    public function is_supplier_name_exists($nama_supplier, $exclude_id = null)
    {
        $this->db->where('nama_supplier', $nama_supplier);
        if ($exclude_id) {
            $this->db->where('supplier_id !=', $exclude_id);
        }
        $query = $this->db->get('suppliers');
        return $query->num_rows() > 0;
    }

    // Get recently added suppliers (last 7 days)
    public function get_recent_suppliers($days = 7)
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $this->db->where('dibuat_tanggal >=', $date);
        $this->db->order_by('dibuat_tanggal', 'DESC');
        $query = $this->db->get('suppliers');
        return $query->result_array();
    }

    // Update supplier status only
    public function update_supplier_status($id, $status)
    {
        $data = array('status' => $status);
        $this->db->where('supplier_id', $id);
        return $this->db->update('suppliers', $data);
    }

    // Get suppliers by city
    public function get_suppliers_by_city($city)
    {
        $this->db->where('kota', $city);
        $this->db->order_by('nama_supplier', 'ASC');
        $query = $this->db->get('suppliers');
        return $query->result_array();
    }

    // Get unique cities from suppliers
    public function get_supplier_cities()
    {
        $this->db->select('kota');
        $this->db->distinct();
        $this->db->where('kota !=', '');
        $this->db->where('kota IS NOT NULL');
        $this->db->order_by('kota', 'ASC');
        $query = $this->db->get('suppliers');
        return $query->result_array();
    }
}
?>