<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Produk_model');
        header('Content-Type: application/json');
    }

    // Get current cart contents
    public function get_cart()
{
    try {
        $this->output->set_content_type('application/json');
        
        $cart = $this->session->userdata('cart');
        if (!$cart || !is_array($cart)) {
            $cart = [];
        }
        
        $this->output->set_output(json_encode([
            'success' => true,
            'cart' => $cart
        ]));
        
    } catch (Exception $e) {
        log_message('error', 'Cart get_cart error: ' . $e->getMessage());
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to get cart data'
            ]));
    }
}
    // Add product to cart
   public function add_to_cart()
{
    try {
        // Set header untuk JSON response
        $this->output->set_content_type('application/json');
        
        // Pastikan ini POST request
        if ($this->input->method() !== 'post') {
            $this->output->set_output(json_encode([
                'success' => false, 
                'message' => 'Method not allowed'
            ]));
            return;
        }

        $product_id = $this->input->post('product_id');
        $quantity = intval($this->input->post('quantity'));
        
        // Validasi input
        if (!$product_id || $quantity < 1) {
            $this->output->set_output(json_encode([
                'success' => false, 
                'message' => 'Invalid product or quantity'
            ]));
            return;
        }

        // Get product details from database
        $product = $this->Produk_model->get_product_by_id($product_id);
        if (!$product) {
            $this->output->set_output(json_encode([
                'success' => false, 
                'message' => 'Product not found'
            ]));
            return;
        }

        // Get existing cart
        $cart = $this->session->userdata('cart');
        if (!$cart || !is_array($cart)) {
            $cart = [];
        }

        // Check if product already in cart
        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        // Add new item if not found
        if (!$found) {
            // Pastikan semua field ada dan tidak null
            $image = $this->get_product_image($product['gambar']);
            
            $cart[] = [
                'id' => $product_id,
                'name' => $product['nama_produk'] ?? 'Unknown Product',
                'price' => floatval($product['harga_jual'] ?? 0),
                'image' => $image ?? 'default-image.jpg',
                'quantity' => $quantity
            ];
        }

        // Save cart to session
        $this->session->set_userdata('cart', $cart);
        
        // Return success response
        $this->output->set_output(json_encode([
            'success' => true, 
            'message' => 'Product added to cart', 
            'cart' => $cart
        ]));
        
    } catch (Exception $e) {
        // Log error untuk debugging
        log_message('error', 'Cart add_to_cart error: ' . $e->getMessage());
        
        // Return error response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false, 
                'message' => 'Server error occurred. Please try again.'
            ]));
    }
}

    // Update quantity of a cart item
   public function update_cart_item()
{
    try {
        $this->output->set_content_type('application/json');
        
        if ($this->input->method() !== 'post') {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Method not allowed'
            ]));
            return;
        }
        
        $product_id = $this->input->post('product_id');
        $quantity = intval($this->input->post('quantity'));
        
        if (!$product_id || $quantity < 1) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Invalid input'
            ]));
            return;
        }
        
        $cart = $this->session->userdata('cart');
        if (!$cart || !is_array($cart)) {
            $cart = [];
        }
        
        // Update quantity
        foreach ($cart as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        
        $this->session->set_userdata('cart', $cart);
        
        $this->output->set_output(json_encode([
            'success' => true,
            'message' => 'Cart updated',
            'cart' => $cart
        ]));
        
    } catch (Exception $e) {
        log_message('error', 'Cart update_cart_item error: ' . $e->getMessage());
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to update cart'
            ]));
    }
}

public function remove_cart_item()
{
    try {
        $this->output->set_content_type('application/json');
        
        if ($this->input->method() !== 'post') {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Method not allowed'
            ]));
            return;
        }
        
        $product_id = $this->input->post('product_id');
        
        if (!$product_id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Invalid product ID'
            ]));
            return;
        }
        
        $cart = $this->session->userdata('cart');
        if (!$cart || !is_array($cart)) {
            $cart = [];
        }
        
        // Remove item
        $cart = array_filter($cart, function($item) use ($product_id) {
            return $item['id'] != $product_id;
        });
        
        $this->session->set_userdata('cart', $cart);
        
        $this->output->set_output(json_encode([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart' => array_values($cart) // Re-index array
        ]));
        
    } catch (Exception $e) {
        log_message('error', 'Cart remove_cart_item error: ' . $e->getMessage());
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to remove item'
            ]));
    }
}

    // Helper to get product image URL
    private function get_product_image($gambar)
    {
        if (empty($gambar)) {
            return base_url('assets/gambar/vape.png');
        }

        $possible_paths = [
            FCPATH . 'assets/uploads/' . $gambar,
            FCPATH . 'assets/gambar/' . $gambar,
            FCPATH . 'assets/images/' . $gambar,
            FCPATH . 'uploads/' . $gambar,
        ];

        $possible_urls = [
            base_url('assets/uploads/' . $gambar),
            base_url('assets/gambar/' . $gambar),
            base_url('assets/images/' . $gambar),
            base_url('uploads/' . $gambar),
        ];

        for ($i = 0; $i < count($possible_paths); $i++) {
            if (file_exists($possible_paths[$i])) {
                return $possible_urls[$i];
            }
        }

        return base_url('assets/gambar/vape.png');
    }


    public function test_add()
{
    // Set JSON header
    $this->output->set_content_type('application/json');
    
    // Log semua data yang masuk
    log_message('debug', 'POST data: ' . print_r($_POST, true));
    log_message('debug', 'REQUEST METHOD: ' . $_SERVER['REQUEST_METHOD']);
    
    try {
        // Test 1: Basic response
        $response = [
            'success' => true,
            'message' => 'Test method working',
            'post_data' => $_POST,
            'method' => $_SERVER['REQUEST_METHOD'],
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        $this->output->set_output(json_encode($response));
        
    } catch (Exception $e) {
        $this->output->set_output(json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]));
    }
}

// Method add_to_cart yang disederhanakan untuk debug
public function add_to_cart_debug()
{
    $this->output->set_content_type('application/json');
    
    try {
        // Step 1: Check method
        if ($this->input->method() !== 'post') {
            $this->output->set_output(json_encode([
                'success' => false,
                'error' => 'Method not POST',
                'actual_method' => $this->input->method()
            ]));
            return;
        }
        
        // Step 2: Get POST data
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');
        
        // Step 3: Validate input
        if (!$product_id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'error' => 'No product_id',
                'post_data' => $_POST
            ]));
            return;
        }
        
        // Step 4: Check if model exists
        if (!isset($this->Produk_model)) {
            $this->output->set_output(json_encode([
                'success' => false,
                'error' => 'Produk_model not loaded'
            ]));
            return;
        }
        
        // Step 5: Test model method
        $product = $this->Produk_model->get_product_by_id($product_id);
        if (!$product) {
            $this->output->set_output(json_encode([
                'success' => false,
                'error' => 'Product not found',
                'product_id' => $product_id
            ]));
            return;
        }
        
        // Step 6: Test session
        $cart = $this->session->userdata('cart') ?: [];
        
        // Step 7: Success response
        $this->output->set_output(json_encode([
            'success' => true,
            'message' => 'Debug test passed',
            'product_id' => $product_id,
            'product_found' => !empty($product),
            'cart_count' => count($cart)
        ]));
        
    } catch (Exception $e) {
        $this->output->set_output(json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]));
    }
}
}

