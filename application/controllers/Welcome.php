<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load database library in constructor for better performance
        $this->load->database();
        $this->load->library('session');
       

      
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        // Check if user is logged in as admin
        if ($this->session->userdata('user_id') && $this->session->userdata('role') === 'admin') {
            redirect('index.php/Dashboard/admin_dashboard');
        }
        // If not admin, go to landing page
        $this->landing();
    }

    public function landing()
    {
        // Check if user is logged in as admin
        if ($this->session->userdata('user_id') && $this->session->userdata('role') === 'admin') {
            redirect('index.php/Dashboard/admin_dashboard');
        }

        try {
            // Fetch featured products (first 8 active products)
            $this->db->select('produk_id, nama_produk, harga_jual, gambar, deskripsi');
            $this->db->where('status', 'aktif');
            $this->db->order_by('produk_id', 'DESC');
            $this->db->limit(8);
            $featured_query = $this->db->get('produk');
            $featured_products = $featured_query->result_array();

            // Fetch latest products (next 8 active products, skip first 8)
            $this->db->select('produk_id, nama_produk, harga_jual, gambar, deskripsi');
            $this->db->where('status', 'aktif');
            $this->db->order_by('produk_id', 'DESC');
            $this->db->limit(8, 8);
            $latest_query = $this->db->get('produk');
            $latest_products = $latest_query->result_array();

            // Prepare products data with proper error handling
            $data['featured_products'] = $this->formatProducts($featured_products);
            $data['latest_products'] = $this->formatProducts($latest_products);

            // Brands data
            $data['brands'] = $this->getBrands();

            // Ambil 10 feedback terbaru dengan informasi customer
            $this->load->model('Complaint_model');
            $data['complaints'] = $this->Complaint_model->get_all();
            // Limit to 10 most recent
            if (count($data['complaints']) > 10) {
                $data['complaints'] = array_slice($data['complaints'], 0, 10);
            }

            // Check if user is logged in
            $data['is_logged_in'] = $this->session->userdata('customer_id') || $this->session->userdata('user_id');
            $data['username'] = $this->session->userdata('username');

            // Ambil data customer dari database jika login sebagai customer
            $customer_id = $this->session->userdata('customer_id');
            $customer = null;
            if ($customer_id) {
                $this->load->model('Auth_model');
                $customer = $this->Auth_model->get_customer_by_id($customer_id, true);
            }
            $data['customer'] = $customer;

            // Load the view
            $this->load->view('landing_page', $data);

        } catch (Exception $e) {
            // Log error and show error page
            log_message('error', 'Error in Welcome::landing - ' . $e->getMessage());
            show_error('Terjadi kesalahan saat memuat halaman. Silakan coba lagi.');
        }
    }

    public function signup()
    {
        $this->load->view('signup');
    }

    /**
     * Format products array for view
     * @param array $products
     * @return array
     */
    private function formatProducts($products)
    {
        return array_map(function($product) {
            // Handle missing or null values
            $produk_id = isset($product['produk_id']) ? $product['produk_id'] : '';
            $nama_produk = isset($product['nama_produk']) ? $product['nama_produk'] : 'Produk Tidak Diketahui';
            $harga_jual = isset($product['harga_jual']) && is_numeric($product['harga_jual']) ? $product['harga_jual'] : 0;
            $deskripsi = isset($product['deskripsi']) ? $product['deskripsi'] : '';
            
            // Enhanced image handling with debugging
            $image = $this->getProductImage($product['gambar'] ?? '');

            return [
                'id' => $produk_id,
                'name' => $nama_produk,
                'image' => $image,
                'rating' => $this->generateRandomRating(),
                'price' => $this->formatPrice($harga_jual),
                'original_price' => $harga_jual,
                'description' => $deskripsi
            ];
        }, $products);
    }

    /**
     * Get product image with fallback options
     * @param string $gambar
     * @return string
     */
    private function getProductImage($gambar)
    {
        // If no image name provided, use placeholder
        if (empty($gambar)) {
            return base_url('assets/gambar/vape.png'); // Use your existing vape.png as fallback
        }

        // Possible image paths to check (in order of preference)
        $possible_paths = [
            FCPATH . 'assets/uploads/' . $gambar,           // Main uploads folder
            FCPATH . 'assets/gambar/' . $gambar,           // Alternative folder
            FCPATH . 'assets/images/' . $gambar,           // Another common folder
            FCPATH . 'uploads/' . $gambar,                 // Root uploadss folder
        ];

        $possible_urls = [
            base_url('assets/uploads/' . $gambar),
            base_url('assets/gambar/' . $gambar),
            base_url('assets/images/' . $gambar),
            base_url('uploads/' . $gambar),
        ];

        // Check each path and return the first valid one
        for ($i = 0; $i < count($possible_paths); $i++) {
            if (file_exists($possible_paths[$i])) {
                return $possible_urls[$i];
            }
        }

        // If in development, log missing image for debugging
        if (ENVIRONMENT === 'development') {
            log_message('debug', 'Image not found: ' . $gambar . ' - Using fallback vape.png');
        }
        
        // Return fallback image
        return base_url('assets/gambar/vape.png');
    }

    /**
     * Format price to IDR currency
     * @param float $price
     * @return string
     */
    private function formatPrice($price)
    {
        if ($price <= 0) {
            return 'Hubungi Kami';
        }
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Generate random rating between 3.5 and 5.0
     * @return float
     */
    private function generateRandomRating()
    {
        return round(mt_rand(35, 50) / 10, 1);
    }

    /**
     * Get brands data
     * @return array
     */
    private function getBrands()
    {
        return [
            [
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c6/Coca-Cola_logo.svg/1200px-Coca-Cola_logo.svg.png',
                'alt' => 'Coca-Cola',
                'name' => 'Coca-Cola'
            ],
            [
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/4a/Godrej_logo.svg',
                'alt' => 'Godrej',
                'name' => 'Godrej'
            ],
            [
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/9/9e/Oppo_logo.svg',
                'alt' => 'Oppo',
                'name' => 'Oppo'
            ],
            [
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg',
                'alt' => 'PayPal',
                'name' => 'PayPal'
            ],
            [
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/3a/Philips_logo.svg',
                'alt' => 'Philips',
                'name' => 'Philips'
            ]
        ];
    }

    /**
     * Debug method to check image files
     * Only works in development environment
     */
    public function debug_images()
    {
        // Only allow in development environment
        if (ENVIRONMENT !== 'development') {
            show_404();
            return;
        }

        echo "<h2>Image Debug Information</h2>";
        echo "<style>table { border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; } th { background-color: #f2f2f2; }</style>";
        
        // Check upload directory
        $upload_path = FCPATH . 'assets/upload/';
        echo "<h3>Upload Directory: " . $upload_path . "</h3>";
        
        if (is_dir($upload_path)) {
            echo "<p style='color: green;'>✅ Directory exists</p>";
            $files = scandir($upload_path);
            echo "<h4>Files in directory (" . (count($files) - 2) . " files):</h4><ul>";
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $file_path = $upload_path . $file;
                    $size = filesize($file_path);
                    echo "<li><strong>$file</strong> (Size: " . number_format($size) . " bytes)</li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>❌ Directory does not exist</p>";
            echo "<p><strong>Solution:</strong> Create the directory: <code>mkdir " . $upload_path . "</code></p>";
        }

        // Check other possible directories
        $other_paths = [
            'assets/gambar/' => FCPATH . 'assets/gambar/',
            'assets/images/' => FCPATH . 'assets/images/',
            'uploads/' => FCPATH . 'uploads/'
        ];

        foreach ($other_paths as $name => $path) {
            echo "<h4>$name Directory:</h4>";
            if (is_dir($path)) {
                $files = scandir($path);
                $file_count = count($files) - 2;
                echo "<p style='color: green;'>✅ Exists ($file_count files)</p>";
            } else {
                echo "<p style='color: red;'>❌ Does not exist</p>";
            }
        }

        // Check database images
        echo "<h3>Database Image References</h3>";
        $this->db->select('produk_id, nama_produk, gambar');
        $this->db->where('gambar IS NOT NULL');
        $this->db->where('gambar !=', '');
        $this->db->limit(10); // Limit for debugging
        $query = $this->db->get('produk');
        
        if ($query->num_rows() > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Product Name</th><th>Image Name</th><th>File Exists</th><th>Checked Paths</th></tr>";
            
            foreach ($query->result_array() as $product) {
                $file_checks = [];
                $found = false;
                
                $possible_paths = [
                    'assets/uploads/' => FCPATH . 'assets/uploadss/' . $product['gambar'],
                    'assets/gambar/' => FCPATH . 'assets/gambar/' . $product['gambar'],
                    'assets/images/' => FCPATH . 'assets/images/' . $product['gambar'],
                    'uploadss/' => FCPATH . 'uploadss/' . $product['gambar']
                ];
                
                foreach ($possible_paths as $name => $path) {
                    $exists = file_exists($path);
                    $file_checks[] = $name . ': ' . ($exists ? '✅' : '❌');
                    if ($exists) $found = true;
                }
                
                echo "<tr>";
                echo "<td>" . $product['produk_id'] . "</td>";
                echo "<td>" . htmlspecialchars($product['nama_produk']) . "</td>";
                echo "<td>" . htmlspecialchars($product['gambar']) . "</td>";
                echo "<td style='color: " . ($found ? 'green' : 'red') . ";'>" . ($found ? '✅ Found' : '❌ Not Found') . "</td>";
                echo "<td><small>" . implode('<br>', $file_checks) . "</small></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No products with images found in database</p>";
        }

        // Show current configuration
        echo "<h3>Configuration Info</h3>";
        echo "<p><strong>Base URL:</strong> " . base_url() . "</p>";
        echo "<p><strong>FCPATH:</strong> " . FCPATH . "</p>";
        echo "<p><strong>Environment:</strong> " . ENVIRONMENT . "</p>";
    }
}