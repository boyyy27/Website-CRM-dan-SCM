<?php
class Category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Get all categories from the database
    public function get_all_categories()
    {
        $this->db->order_by('kategori_id', 'DESC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Get a specific category by ID
    public function get_category_by_id($id)
    {
        $this->db->where('kategori_id', $id);
        $query = $this->db->get('kategori');
        return $query->row_array();
    }

    // Create a new category in the database
    public function create_category($data)
    {
        return $this->db->insert('kategori', $data);
    }

    // Update an existing category
    public function update_category($id, $data)
    {
        $this->db->where('kategori_id', $id);
        return $this->db->update('kategori', $data);
    }

    // Delete a category by ID
    public function delete_category($id)
    {
        $this->db->where('kategori_id', $id);
        return $this->db->delete('kategori');
    }

    // Check if category exists by ID
    public function category_exists($id)
    {
        $this->db->where('kategori_id', $id);
        $query = $this->db->get('kategori');
        return $query->num_rows() > 0;
    }

    // Search categories by name or description
    public function search_categories($keyword)
    {
        $this->db->like('nama_kategori', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Count total categories
    public function count_categories()
    {
        return $this->db->count_all('kategori');
    }

    // Get categories with pagination
    public function get_categories_paginated($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $this->db->order_by('kategori_id', 'DESC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Check if category name already exists (for validation)
    public function is_category_name_exists($nama_kategori, $exclude_id = null)
    {
        $this->db->where('nama_kategori', $nama_kategori);
        if ($exclude_id) {
            $this->db->where('kategori_id !=', $exclude_id);
        }
        $query = $this->db->get('kategori');
        return $query->num_rows() > 0;
    }

    // Get categories ordered by name (useful for dropdowns)
    public function get_categories_ordered()
    {
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Get categories with product count (if you have products table)
    // Uncomment this function if you have a products table with kategori_id
    /*
    public function get_categories_with_product_count()
    {
        $this->db->select('k.*, COUNT(p.product_id) as product_count');
        $this->db->from('kategori k');
        $this->db->join('products p', 'k.kategori_id = p.kategori_id', 'left');
        $this->db->group_by('k.kategori_id');
        $this->db->order_by('k.nama_kategori', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    */

    // Check if category is being used by products (if you have products table)
    // Uncomment this function if you have a products table with kategori_id
    /*
    public function is_category_used($id)
    {
        $this->db->where('kategori_id', $id);
        $query = $this->db->get('products');
        return $query->num_rows() > 0;
    }
    */

    // Get category by name
    public function get_category_by_name($nama_kategori)
    {
        $this->db->where('nama_kategori', $nama_kategori);
        $query = $this->db->get('kategori');
        return $query->row_array();
    }

    // Get categories that have descriptions (method terpotong yang dilanjutkan)
    public function get_categories_with_description()
    {
        $this->db->where('deskripsi !=', '');
        $this->db->where('deskripsi IS NOT NULL');
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Get categories without descriptions
    public function get_categories_without_description()
    {
        $this->db->group_start();
        $this->db->where('deskripsi', '');
        $this->db->or_where('deskripsi IS NULL');
        $this->db->group_end();
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Get categories for select dropdown (returns id and name only)
    public function get_categories_for_dropdown()
    {
        $this->db->select('kategori_id, nama_kategori');
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Get category statistics
    public function get_category_statistics()
    {
        $stats = array();
        
        // Total categories
        $stats['total_categories'] = $this->count_categories();
        
        // Categories with descriptions
        $this->db->where('deskripsi !=', '');
        $this->db->where('deskripsi IS NOT NULL');
        $query = $this->db->get('kategori');
        $stats['categories_with_description'] = $query->num_rows();
        
        // Categories without descriptions
        $stats['categories_without_description'] = $stats['total_categories'] - $stats['categories_with_description'];
        
        return $stats;
    }

    // Bulk delete categories
    public function bulk_delete_categories($ids)
    {
        if (empty($ids) || !is_array($ids)) {
            return false;
        }
        
        $this->db->where_in('kategori_id', $ids);
        return $this->db->delete('kategori');
    }

    // Get recently added categories (last N categories)
    public function get_recent_categories($limit = 5)
    {
        $this->db->limit($limit);
        $this->db->order_by('kategori_id', 'DESC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Get categories with search and pagination
    public function get_categories_with_search_pagination($keyword = '', $limit = 10, $offset = 0)
    {
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('nama_kategori', $keyword);
            $this->db->or_like('deskripsi', $keyword);
            $this->db->group_end();
        }
        
        $this->db->limit($limit, $offset);
        $this->db->order_by('kategori_id', 'DESC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Count categories with search filter
    public function count_categories_with_search($keyword = '')
    {
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('nama_kategori', $keyword);
            $this->db->or_like('deskripsi', $keyword);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results('kategori');
    }

    // Update category status (if you have status field)
    public function update_category_status($id, $status)
    {
        $data = array('status' => $status);
        $this->db->where('kategori_id', $id);
        return $this->db->update('kategori', $data);
    }

    // Get active categories (if you have status field)
    public function get_active_categories()
    {
        $this->db->where('status', 1); // Assuming 1 = active
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Import categories from array
    public function import_categories($categories_data)
    {
        if (empty($categories_data) || !is_array($categories_data)) {
            return false;
        }
        
        $this->db->trans_start();
        
        foreach ($categories_data as $category) {
            // Skip if category name already exists
            if (!$this->is_category_name_exists($category['nama_kategori'])) {
                $this->db->insert('kategori', $category);
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Export categories to array
    public function export_categories()
    {
        $this->db->select('nama_kategori, deskripsi');
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get('kategori');
        return $query->result_array();
    }

    // Get category name by ID (lightweight method)
    public function get_category_name($id)
    {
        $this->db->select('nama_kategori');
        $this->db->where('kategori_id', $id);
        $query = $this->db->get('kategori');
        $result = $query->row_array();
        return $result ? $result['nama_kategori'] : '';
    }

    // Clean up empty categories (categories without name)
    public function cleanup_empty_categories()
    {
        $this->db->group_start();
        $this->db->where('nama_kategori', '');
        $this->db->or_where('nama_kategori IS NULL');
        $this->db->group_end();
        return $this->db->delete('kategori');
    }
}
?>