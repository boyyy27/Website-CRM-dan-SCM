<?php
class Produk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model'); // Load the Produk_model
        $this->load->helper('url'); // Load URL helper
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload'); // Load the upload library
        // Proteksi: jika tidak login sebagai user (admin/kasir/owner), redirect ke login
        if ($this->session->userdata('customer_id')) {
            // Tampilkan modal forbidden access
            echo $this->load->view('forbidden_access', [], true);
            exit;
        }
         // Load URL helper
         if (!$this->session->userdata('user_id') || !$this->session->userdata('role')) {
            redirect('index.php/Auth/signin');
        }
    }

    // View all products
     public function view_product()
    {
        // Retrieve all products from the database
        $data['produk'] = $this->Produk_model->get_all_produk();
        
        // TAMBAHAN: Load categories dan suppliers untuk dropdown modal
        $data['categories'] = $this->Produk_model->get_all_categories();
        $data['suppliers'] = $this->Produk_model->get_all_suppliers();
        
        // Load views with data
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('view_produk', $data); // Sekarang include categories dan suppliers
        $this->load->view('template/footer');
    }

    // Alternatif: jika method ini yang digunakan untuk halaman utama produk
   

    // Show form to create a new product
    public function create()
    {
        // Fetch categories and suppliers for dropdowns
        $data['categories'] = $this->Produk_model->get_all_categories();
        $data['suppliers'] = $this->Produk_model->get_all_suppliers();

        // Load the form for creating a new product
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('produk/create', $data);
        $this->load->view('template/footer');
    }

    // Store a new product in the database
    public function store()
    {
        // Validasi inputan
        $this->form_validation->set_rules('nama_produk', 'Product Name', 'required');
        $this->form_validation->set_rules('kategori_id', 'Category', 'required');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('harga_beli', 'Buy Price', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('harga_jual', 'Sell Price', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('jumlah_stok', 'Stock', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/produk/view_product'); // Redirect ke method yang benar
            return;
        }

        // Generate product code automatically based on category
        $kategori_id = $this->input->post('kategori_id');
        $kode_produk = $this->Produk_model->generate_product_code($kategori_id);
        
        if (!$kode_produk) {
            $this->session->set_flashdata('message', 'Failed to generate product code');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/produk/view_product');
            return;
        }

        // Upload image
        $image = $this->upload_image();
        if ($image === false) {
            $this->session->set_flashdata('message', 'Failed to upload image: ' . $this->upload->display_errors('', ''));
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/produk/view_product');
            return;
        }

        // Data produk yang akan disimpan
        $data = array(
            'kode_produk' => $kode_produk,
            'nama_produk' => $this->input->post('nama_produk'),
            'kategori_id' => $this->input->post('kategori_id'),
            'supplier_id' => $this->input->post('supplier_id'),
            'harga_beli' => $this->input->post('harga_beli'),
            'harga_jual' => $this->input->post('harga_jual'),
            'jumlah_stok' => $this->input->post('jumlah_stok'),
            'deskripsi' => $this->input->post('deskripsi'),
            'status' => $this->input->post('status'),
            'gambar' => $image,
            'created_at' => date('Y-m-d H:i:s')
        );

        // Simpan data produk ke dalam database
        if ($this->Produk_model->create_produk($data)) {
            $this->session->set_flashdata('message', 'Product added successfully! Code: ' . $kode_produk . ', Stock: ' . $data['jumlah_stok']);
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to add product');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect ke daftar produk
        redirect('index.php/produk/view_product');
    }

    // Update product details
    public function update($id)
    {
        // Validate required fields
        $this->form_validation->set_rules('kode_produk', 'Product Code', 'required');
        $this->form_validation->set_rules('nama_produk', 'Product Name', 'required');
        $this->form_validation->set_rules('kategori_id', 'Category', 'required');
        $this->form_validation->set_rules('harga_beli', 'Buy Price', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('harga_jual', 'Sell Price', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('jumlah_stok', 'Stock', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        // Check if product code is unique (except for current product)
        $existing_product = $this->Produk_model->get_produk_by_kode($this->input->post('kode_produk'), $id);
        if ($existing_product) {
            $this->session->set_flashdata('message', 'Product code already exists');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/produk/view_product');
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/produk/view_product');
            return;
        }

        // Upload the image if provided
        $image = $this->upload_image();

        // Collect updated data from the form
        $data = array(
            'kode_produk' => $this->input->post('kode_produk'),
            'nama_produk' => $this->input->post('nama_produk'),
            'kategori_id' => $this->input->post('kategori_id'),
            'supplier_id' => $this->input->post('supplier_id') ?: null,
            'harga_beli' => $this->input->post('harga_beli'),
            'harga_jual' => $this->input->post('harga_jual'),
            'jumlah_stok' => $this->input->post('jumlah_stok'),
            'deskripsi' => $this->input->post('deskripsi'),
            'status' => $this->input->post('status'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        // If an image is uploaded, add the image field to the data array
        if ($image && $image !== null) {
            // Get old image to delete it later
            $old_product = $this->Produk_model->get_produk_by_id($id);
            if ($old_product && !empty($old_product['gambar'])) {
                $old_image_path = './assets/uploads/' . $old_product['gambar'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path); // Delete old image
                }
            }
            $data['gambar'] = $image;
        }

        // Call the model to update the product in the database
        if ($this->Produk_model->update_produk($id, $data)) {
            $this->session->set_flashdata('message', 'Product updated successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to update product');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect to the product list
        redirect('index.php/produk/view_product');
    }

    // Delete a product
    public function delete($id)
    {
        // Get product data before deletion to remove image file
        $product = $this->Produk_model->get_produk_by_id($id);
        
        // Call the model to delete the product by its ID
        if ($this->Produk_model->delete_produk($id)) {
            // Delete associated image file if exists
            if ($product && !empty($product['gambar'])) {
                $image_path = './assets/uploads/' . $product['gambar'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            
            $this->session->set_flashdata('message', 'Product deleted successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to delete product');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect to the product list
        redirect('index.php/produk/view_product');
    }

    // Show the form to edit a product (if you need separate edit page)
    public function edit($id)
    {
        // Fetch product data by its ID
        $data['produk'] = $this->Produk_model->get_produk_by_id($id);
        // Fetch categories and suppliers for dropdowns
        $data['categories'] = $this->Produk_model->get_all_categories();
        $data['suppliers'] = $this->Produk_model->get_all_suppliers();

        if (!$data['produk']) {
            $this->session->set_flashdata('message', 'Product not found');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/produk/view_product');
            return;
        }

        // Load views with the data
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('produk/edit', $data);
        $this->load->view('template/footer');
    }

    // Image upload handling function
    private function upload_image()
    {
        // Check if image is uploaded
        if (empty($_FILES['gambar']['name'])) {
            return null; // No image uploaded
        }

        // Configuration for file upload
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // Max image size (2MB)
        $config['file_name'] = uniqid('product_') . '_' . time();
        $config['encrypt_name'] = FALSE;

        // Create upload directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        // Initialize the upload library with the configuration
        $this->upload->initialize($config);

        // If an image is uploaded
        if ($this->upload->do_upload('gambar')) {
            return $this->upload->data('file_name'); // Return the uploaded file name
        } else {
            // If upload fails and image was required
            $error = $this->upload->display_errors('', '');
            if (strpos($error, 'did not select a file') === false) {
                return false; // Return false to indicate upload error
            }
            return null; // Return null if no file selected
        }
    }

    // Get product details via AJAX (optional for future enhancements)
    public function get_product_details($id)
    {
        $product = $this->Produk_model->get_produk_by_id($id);
        
        if ($product) {
            echo json_encode($product);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }
    }

    // AJAX endpoint to generate product code based on category
    public function generate_product_code()
    {
        // Check if this is an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $kategori_id = $this->input->post('kategori_id');
        
        if (!$kategori_id) {
            echo json_encode(['error' => 'Category ID is required']);
            return;
        }
        
        $product_code = $this->Produk_model->generate_product_code($kategori_id);
        
        if ($product_code) {
            echo json_encode(['success' => true, 'product_code' => $product_code]);
        } else {
            echo json_encode(['error' => 'Failed to generate product code']);
        }
    }
}
?>
