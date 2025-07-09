<?php
class Produk_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Create a new product
    public function create_produk($data)
    {
        return $this->db->insert('produk', $data);
    }

    // Get all products with category and supplier names
    public function get_all_produk()
    {
        $this->db->select('produk.*, kategori.nama_kategori, suppliers.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
        $this->db->join('suppliers', 'produk.supplier_id = suppliers.supplier_id', 'left');
        $this->db->order_by('produk.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single product by its ID
    public function get_produk_by_id($id)
    {
        $this->db->select('produk.*, kategori.nama_kategori, suppliers.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
        $this->db->join('suppliers', 'produk.supplier_id = suppliers.supplier_id', 'left');
        $this->db->where('produk.produk_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Get product by code (for validation)
    public function get_produk_by_kode($kode_produk, $exclude_id = null)
    {
        $this->db->where('kode_produk', $kode_produk);
        if ($exclude_id) {
            $this->db->where('produk_id !=', $exclude_id);
        }
        $query = $this->db->get('produk');
        return $query->row_array();
    }

    // Update a product
    public function update_produk($id, $data)
    {
        $this->db->where('produk_id', $id);
        return $this->db->update('produk', $data);
    }

    // Delete a product
    public function delete_produk($id)
    {
        $this->db->where('produk_id', $id);
        return $this->db->delete('produk');
    }

    // PERBAIKAN: Get all categories dengan error handling
    public function get_all_categories()
    {
        $this->db->select('kategori_id, nama_kategori');
        $this->db->from('kategori');
        $this->db->order_by('nama_kategori', 'ASC');
        $query = $this->db->get();
        
        // Debug: uncomment untuk debugging
        // if ($this->db->error()['code'] != 0) {
        //     log_message('error', 'Categories query error: ' . $this->db->error()['message']);
        //     return array();
        // }
        
        $result = $query->result_array();
        
        // Debug: uncomment untuk debugging
        // log_message('debug', 'Categories found: ' . count($result));
        
        return $result;
    }

    // PERBAIKAN: Get all suppliers dengan error handling
    public function get_all_suppliers()
    {
        $this->db->select('supplier_id, nama_supplier');
        $this->db->from('suppliers');
        $this->db->order_by('nama_supplier', 'ASC');
        $query = $this->db->get();
        
        // Debug: uncomment untuk debugging
        // if ($this->db->error()['code'] != 0) {
        //     log_message('error', 'Suppliers query error: ' . $this->db->error()['message']);
        //     return array();
        // }
        
        $result = $query->result_array();
        
        // Debug: uncomment untuk debugging
        // log_message('debug', 'Suppliers found: ' . count($result));
        
        return $result;
    }

    // Get products by category
    public function get_produk_by_category($kategori_id)
    {
        $this->db->select('produk.*, kategori.nama_kategori, suppliers.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
        $this->db->join('suppliers', 'produk.supplier_id = suppliers.supplier_id', 'left');
        $this->db->where('produk.kategori_id', $kategori_id);
        $this->db->order_by('produk.nama_produk', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get products by supplier
    public function get_produk_by_supplier($supplier_id)
    {
        $this->db->select('produk.*, kategori.nama_kategori, suppliers.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
        $this->db->join('suppliers', 'produk.supplier_id = suppliers.supplier_id', 'left');
        $this->db->where('produk.supplier_id', $supplier_id);
        $this->db->order_by('produk.nama_produk', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get active products only
    public function get_active_produk()
    {
        $this->db->select('produk.*, kategori.nama_kategori, suppliers.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
        $this->db->join('suppliers', 'produk.supplier_id = suppliers.supplier_id', 'left');
        $this->db->where('produk.status', 'aktif');
        $this->db->order_by('produk.nama_produk', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Search products
    public function search_produk($keyword)
    {
        $this->db->select('produk.*, kategori.nama_kategori, suppliers.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
        $this->db->join('suppliers', 'produk.supplier_id = suppliers.supplier_id', 'left');
        $this->db->group_start();
        $this->db->like('produk.nama_produk', $keyword);
        $this->db->or_like('produk.kode_produk', $keyword);
        $this->db->or_like('kategori.nama_kategori', $keyword);
        $this->db->or_like('suppliers.nama_supplier', $keyword);
        $this->db->group_end();
        $this->db->order_by('produk.nama_produk', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get products with low stock
    public function get_low_stock_produk()
    {
        $this->db->select('produk.*, kategori.nama_kategori, suppliers.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.kategori_id', 'left');
        $this->db->join('suppliers', 'produk.supplier_id = suppliers.supplier_id', 'left');
        $this->db->where('produk.stok_minimum <=', 10);
        $this->db->where('produk.status', 'aktif');
        $this->db->order_by('produk.stok_minimum', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Count total products
    public function count_all_produk()
    {
        return $this->db->count_all('produk');
    }

    // Count active products
    public function count_active_produk()
    {
        $this->db->where('status', 'aktif');
        return $this->db->count_all_results('produk');
    }

    // Count inactive products
    public function count_inactive_produk()
    {
        $this->db->where('status', 'nonaktif');
        return $this->db->count_all_results('produk');
    }

    // TAMBAHAN: Method untuk debugging database
    public function test_database_connection()
    {
        // Test query ke tabel kategori
        $kategori_test = $this->db->query("SELECT COUNT(*) as count FROM kategori")->row();
        
        // Test query ke tabel suppliers
        $supplier_test = $this->db->query("SELECT COUNT(*) as count FROM suppliers")->row();
        
        return array(
            'kategori_count' => $kategori_test->count,
            'supplier_count' => $supplier_test->count,
            'db_error' => $this->db->error()
        );
    }

    public function get_available_produk()
    {
        $this->db->select('produk_id, kode_produk, nama_produk, harga_jual');
        $this->db->from('produk');
        $this->db->where('jumlah_stok >', 0);
        $this->db->order_by('nama_produk', 'ASC');
        return $this->db->get()->result();
    }

    public function get_total_produk() {
        return $this->db->count_all('produk');
    }

    public function get_low_stock_products() {
        $this->db->where('jumlah_stok <', 3);
        $this->db->order_by('jumlah_stok', 'ASC');
        return $this->db->get('produk')->result();
    }

    // TAMBAHAN: Method untuk debugging database
    public function debug_database()
    {
        $this->db->select('kategori_id, nama_kategori');
        $this->db->from('kategori');
        $query = $this->db->get();
        
        if ($this->db->error()['code'] != 0) {
            return array('error' => $this->db->error()['message']);
        }
        
        return $query->result_array();
    }

    // Generate automatic product code based on category
    public function generate_product_code($kategori_id)
    {
        // Get category name
        $this->db->select('nama_kategori');
        $this->db->from('kategori');
        $this->db->where('kategori_id', $kategori_id);
        $query = $this->db->get();
        $category = $query->row_array();
        
        if (!$category) {
            return false;
        }
        
        // Create prefix based on category name
        $prefix = $this->get_category_prefix($category['nama_kategori']);
        
        // Get the latest product code for this category
        $this->db->select('kode_produk');
        $this->db->from('produk');
        $this->db->where('kategori_id', $kategori_id);
        $this->db->like('kode_produk', $prefix, 'after');
        $this->db->order_by('kode_produk', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $latest = $query->row_array();
        
        if ($latest) {
            // Extract number from existing code and increment
            $number = intval(substr($latest['kode_produk'], strlen($prefix))) + 1;
        } else {
            // First product in this category
            $number = 1;
        }
        
        // Format with leading zeros (e.g., 01, 02, 10, 100)
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    // Get category prefix based on category name
    private function get_category_prefix($nama_kategori)
    {
        $nama_kategori = strtolower($nama_kategori);
        
        // Define category prefixes
        $prefixes = array(
            'pod system' => 'POD',
            'mod vape' => 'MOD',
            'e-liquid' => 'ELQ',
            'coil' => 'COIL',
            'disposable' => 'DSP',
            'aksesoris' => 'ACC'
        );
        
        // Check for exact match first
        if (isset($prefixes[$nama_kategori])) {
            return $prefixes[$nama_kategori];
        }
        
        // Check for partial matches
        foreach ($prefixes as $key => $prefix) {
            if (strpos($nama_kategori, $key) !== false) {
                return $prefix;
            }
        }
        
        // Default: use first 3 letters of category name in uppercase
        return strtoupper(substr($nama_kategori, 0, 3));
    }
}
?>