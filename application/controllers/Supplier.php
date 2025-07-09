<?php
class Supplier extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model'); // Load the Supplier_model
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

    // View all suppliers
    public function view_supplier()
    {
        // Retrieve all suppliers from the database
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        // Load views with data
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('view_supplier', $data);
        $this->load->view('template/footer');
    }

    // Show form to create a new supplier
    public function create()
    {
        // Load the form for creating a new supplier
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('supplier/create');
        $this->load->view('template/footer');
    }

    // Store a new supplier in the database
    public function store()
    {
        // Validasi inputan
        $this->form_validation->set_rules('nama_supplier', 'Supplier Name', 'required|trim');
        $this->form_validation->set_rules('kontak_person', 'Contact Person', 'trim');
        $this->form_validation->set_rules('telepon', 'Phone', 'trim|max_length[20]');
        $this->form_validation->set_rules('alamat', 'Address', 'trim');
        $this->form_validation->set_rules('kota', 'City', 'trim|max_length[50]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/supplier/view_supplier');
            return;
        }

        // Data supplier yang akan disimpan
        $data = array(
            'nama_supplier' => $this->input->post('nama_supplier'),
            'kontak_person' => $this->input->post('kontak_person'),
            'telepon' => $this->input->post('telepon'),
            'alamat' => $this->input->post('alamat'),
            'kota' => $this->input->post('kota'),
            'status' => $this->input->post('status'),
            'dibuat_tanggal' => date('Y-m-d H:i:s')
        );

        // Simpan data supplier ke dalam database
        if ($this->Supplier_model->create_supplier($data)) {
            $this->session->set_flashdata('message', 'Supplier added successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to add supplier');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect ke daftar supplier
        redirect('index.php/supplier/view_supplier');
    }

    // Update supplier details
    public function update($id)
    {
        // Validate required fields
        $this->form_validation->set_rules('nama_supplier', 'Supplier Name', 'required|trim');
        $this->form_validation->set_rules('kontak_person', 'Contact Person', 'trim');
        $this->form_validation->set_rules('telepon', 'Phone', 'trim|max_length[20]');
        $this->form_validation->set_rules('alamat', 'Address', 'trim');
        $this->form_validation->set_rules('kota', 'City', 'trim|max_length[50]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', validation_errors());
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/supplier/view_supplier');
            return;
        }

        // Collect updated data from the form
        $data = array(
            'nama_supplier' => $this->input->post('nama_supplier'),
            'kontak_person' => $this->input->post('kontak_person'),
            'telepon' => $this->input->post('telepon'),
            'alamat' => $this->input->post('alamat'),
            'kota' => $this->input->post('kota'),
            'status' => $this->input->post('status')
        );

        // Call the model to update the supplier in the database
        if ($this->Supplier_model->update_supplier($id, $data)) {
            $this->session->set_flashdata('message', 'Supplier updated successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to update supplier');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect to the supplier list
        redirect('index.php/supplier/view_supplier');
    }

    // Delete a supplier
    public function delete($id)
    {
        // Get supplier data before deletion
        $supplier = $this->Supplier_model->get_supplier_by_id($id);
        
        // Call the model to delete the supplier by its ID
        if ($this->Supplier_model->delete_supplier($id)) {
            $this->session->set_flashdata('message', 'Supplier deleted successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to delete supplier');
            $this->session->set_flashdata('message_type', 'error');
        }

        // Redirect to the supplier list
        redirect('index.php/supplier/view_supplier');
    }

    // Show the form to edit a supplier (if you need separate edit page)
    public function edit($id)
    {
        // Fetch supplier data by its ID
        $data['supplier'] = $this->Supplier_model->get_supplier_by_id($id);

        if (!$data['supplier']) {
            $this->session->set_flashdata('message', 'Supplier not found');
            $this->session->set_flashdata('message_type', 'error');
            redirect('index.php/supplier/view_supplier');
            return;
        }

        // Load views with the data
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('supplier/edit', $data);
        $this->load->view('template/footer');
    }

    // Get supplier details via AJAX (optional for future enhancements)
    public function get_supplier_details($id)
    {
        $supplier = $this->Supplier_model->get_supplier_by_id($id);
        if ($supplier) {
            header('Content-Type: application/json');
            echo json_encode($supplier);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Supplier not found']);
        }
    }
}
?>