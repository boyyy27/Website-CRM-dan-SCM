<?php
class Category extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model'); // Load the Category_model
        $this->load->helper('url'); // Load URL helper
        $this->load->library('session');
        $this->load->library('form_validation');

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

    // View all categories
    public function view_category()
    {
        // Retrieve all categories from the database
        $data['categories'] = $this->Category_model->get_all_categories();
        
        // Load views with data
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('view_category', $data);
        $this->load->view('template/footer');
    }

    // Show form to create a new category
    public function create()
    {
        // Load the form for creating a new category
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('category/create');
        $this->load->view('template/footer');
    }

    // Store a new category in the database
    public function store()
    {
        // Validasi inputan
        $this->form_validation->set_rules('nama_kategori', 'Category Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('deskripsi', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/category/view_category');
            return;
        }

        // Check if category name already exists
        if ($this->Category_model->is_category_name_exists($this->input->post('nama_kategori'))) {
            $this->session->set_flashdata('message', 'Category name already exists');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/category/view_category');
            return;
        }

        // Data kategori yang akan disimpan
        $data = array(
            'nama_kategori' => $this->input->post('nama_kategori'),
            'deskripsi' => $this->input->post('deskripsi')
        );

        // Simpan data kategori ke dalam database
        if ($this->Category_model->create_category($data)) {
            $this->session->set_flashdata('message', 'Category added successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to add category');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect ke daftar kategori
        redirect('index.php/category/view_category');
    }

    // Update category details
    public function update($id)
    {
        // Validate required fields
        $this->form_validation->set_rules('nama_kategori', 'Category Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('deskripsi', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/category/view_category');
            return;
        }

        // Check if category name already exists (exclude current category)
        if ($this->Category_model->is_category_name_exists($this->input->post('nama_kategori'), $id)) {
            $this->session->set_flashdata('message', 'Category name already exists');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/category/view_category');
            return;
        }

        // Collect updated data from the form
        $data = array(
            'nama_kategori' => $this->input->post('nama_kategori'),
            'deskripsi' => $this->input->post('deskripsi')
        );

        // Call the model to update the category in the database
        if ($this->Category_model->update_category($id, $data)) {
            $this->session->set_flashdata('message', 'Category updated successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to update category');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect to the category list
        redirect('index.php/category/view_category');
    }

    // Delete a category
    public function delete($id)
    {
        // Check if category is being used by products (if you have products table)
        // Uncomment this if you have products table with kategori_id foreign key
        /*
        if ($this->Category_model->is_category_used($id)) {
            $this->session->set_flashdata('message', 'Cannot delete category. It is being used by products.');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/category/view_category');
            return;
        }
        */

        // Get category data before deletion
        $category = $this->Category_model->get_category_by_id($id);
        
        // Call the model to delete the category by its ID
        if ($this->Category_model->delete_category($id)) {
            $this->session->set_flashdata('message', 'Category deleted successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to delete category');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect to the category list
        redirect('index.php/category/view_category');
    }

    // Show the form to edit a category (if you need separate edit page)
    public function edit($id)
    {
        // Fetch category data by its ID
        $data['category'] = $this->Category_model->get_category_by_id($id);

        if (!$data['category']) {
            $this->session->set_flashdata('message', 'Category not found');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/category/view_category');
            return;
        }

        // Load views with the data
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('category/edit', $data);
        $this->load->view('template/footer');
    }

    // Get category details via AJAX (optional for future enhancements)
    public function get_category_details($id)
    {
        $category = $this->Category_model->get_category_by_id($id);
        if ($category) {
            header('Content-Type: application/json');
            echo json_encode($category);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Category not found']);
        }
    }

    // Get categories for dropdown (AJAX endpoint)
    public function get_categories_dropdown()
    {
        $categories = $this->Category_model->get_all_categories();
        header('Content-Type: application/json');
        echo json_encode($categories);
    }
}
?>