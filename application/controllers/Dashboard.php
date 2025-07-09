<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the session library
        $this->load->library('session');
       
        // Load the form_validation library
        $this->load->library('form_validation');
        // Load the Auth model
        $this->load->model('Auth_model'); 
        $this->load->helper('url'); 
        $this->load->model('User_model'); // Model untuk user management
        $this->load->model('Penjualan_model');
        $this->load->model('Produk_model');
        $this->load->model('Customer_model');
        $this->load->model('Pembelian_model');

        if ($this->session->userdata('customer_id')) {
            // Tampilkan modal forbidden access
            echo $this->load->view('forbidden_access', [], true);
            exit;
        }
         // Load URL helper
         if (!$this->session->userdata('user_id') || !$this->session->userdata('role')) {
            redirect('index.php/Auth/signin');
        }

        // Jika login sebagai customer, redirect ke landing page
       


    }
public function admin_dashboard()
	{
        $data['title'] = 'Dashboard';
        $data['orders_count'] = $this->Penjualan_model->get_jumlah_transaksi_today();
        $data['products_count'] = $this->Produk_model->get_total_produk();
        $data['customers_count'] = $this->Customer_model->get_total_customers();
        $data['revenue'] = $this->Penjualan_model->get_total_penjualan_today();
        $data['revenue_mingguan'] = $this->Penjualan_model->get_total_penjualan_mingguan();
        $data['revenue_bulanan'] = $this->Penjualan_model->get_total_penjualan_bulanan();
        $data['penjualan'] = $this->Penjualan_model->get_all_penjualan();
        $data['pembelian'] = $this->Pembelian_model->get_all_pembelian();
        $data['pembelian_today'] = $this->Pembelian_model->get_total_pembelian_today();
        $data['pembelian_mingguan'] = $this->Pembelian_model->get_total_pembelian_mingguan();
        $data['pembelian_bulanan'] = $this->Pembelian_model->get_total_pembelian_bulanan();
        $data['low_stock_products'] = $this->Produk_model->get_low_stock_products();
        
        // Get top customers data
        $this->db->select('*');
        $this->db->from('top_customer');
        $this->db->limit(10);
        $data['top_customers'] = $this->db->get()->result();

        // Get top products data
        $this->db->select('p.kode_produk, p.nama_produk, k.nama_kategori, SUM(dp.jumlah) as total_terjual, SUM(dp.subtotal) as total_pendapatan');
        $this->db->from('produk p');
        $this->db->join('kategori k', 'p.kategori_id = k.kategori_id');
        $this->db->join('detail_penjualan dp', 'p.produk_id = dp.produk_id');
        $this->db->join('penjualan pj', 'dp.penjualan_id = pj.penjualan_id');
        $this->db->where('pj.status_bayar', 'lunas');
        $this->db->group_by('p.produk_id');
        $this->db->order_by('total_terjual', 'DESC');
        $this->db->limit(5);
        $data['top_products'] = $this->db->get()->result();

        // Grafik penjualan: ambil data untuk tahun berjalan
        $current_year = date('Y');
        $data['sales_chart'] = $this->Penjualan_model->get_penjualan_chart_data(12, null, $current_year);

        // Get fast moving and slow moving data for current month
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        $data['fast_slow_moving'] = $this->Penjualan_model->get_fast_slow_moving($start, $end);

        $data['customer_analytics'] = $this->Penjualan_model->get_customer_product_analytics(3);
        // Tambahkan rekomendasi produk untuk setiap customer
        foreach ($data['customer_analytics'] as $cid => &$cust) {
            if ($cid == 0 || empty($cust['nama_lengkap']) || strtolower($cust['nama_lengkap']) == 'non member') {
                $cust['rekomendasi'] = $this->Penjualan_model->get_rekomendasi_umum(2, 1);
            } else {
                $cust['rekomendasi'] = $this->Penjualan_model->get_rekomendasi_produk($cid, 2, 1);
            }
        }
        unset($cust);
        // Ambil analitik non-member
        $data['non_member_analytics'] = $this->Penjualan_model->get_non_member_product_analytics(3);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
		$this->load->view('admin_dashboard', $data);
        $this->load->view('template/footer');

	}

       public function role_management() {
        // Mengambil data pengguna dari model
        $data['users'] = $this->User_model->get_all_users();

        // Memuat halaman role management
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('role_management', $data);
        $this->load->view('template/footer');

    }

    public function create_user() {
        // Ambil data input
        $data = array(
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'email' => $this->input->post('email'),
            'telepon' => $this->input->post('telepon'),
            'role' => $this->input->post('role'),
            'status' => $this->input->post('status'),
        );

        if ($this->User_model->create_user($data)) {
            // Set flash data untuk sukses
            $this->session->set_flashdata('message', 'User added successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            // Set flash data untuk error
            $this->session->set_flashdata('message', 'Failed to add user');
            $this->session->set_flashdata('message_type', 'error');
        }

        redirect('index.php/Dashboard/role_management');
    }

    public function update_user($user_id) {
        // Ambil data input role dan status
        $role = $this->input->post('role');
        $status = $this->input->post('status');

        // Update role dan status pengguna
        $update_data = array(
            'role' => $role,
            'status' => $status
        );

        if ($this->User_model->update_user($user_id, $update_data)) {
            $this->session->set_flashdata('message', 'User role updated successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to update user role');
            $this->session->set_flashdata('message_type', 'error');
        }

        redirect('index.php/Dashboard/role_management');
    }

    public function delete_user($user_id) {
        if ($this->User_model->delete_user($user_id)) {
            $this->session->set_flashdata('message', 'User deleted successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to delete user');
            $this->session->set_flashdata('message_type', 'error');
        }
        redirect('index.php/Dashboard/role_management');
    }

    public function customer_management() {
        // Get all customers
        $data['customers'] = $this->Customer_model->get_all_customers();

        // Load views
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('customer_management', $data);
        $this->load->view('template/footer');
    }

    public function save_customer() {
        // Get form data
        $customer_id = $this->input->post('customer_id');
        $data = array(
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'telepon' => $this->input->post('telepon'),
            'alamat' => $this->input->post('alamat'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'status' => $this->input->post('status')
        );

        // Handle password
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($customer_id) {
            // Update existing customer
            $result = $this->Customer_model->update_customer($customer_id, $data);
            $message = 'Customer updated successfully';
        } else {
            // Add new customer - password is required for new customers
            if (empty($password)) {
                $this->session->set_flashdata('message', 'Password is required for new customers');
                $this->session->set_flashdata('message_type', 'error');
                redirect('index.php/Dashboard/customer_management');
                return;
            }
            $result = $this->Customer_model->add_customer($data);
            $message = 'Customer added successfully';
        }

        if ($result) {
            $this->session->set_flashdata('message', $message);
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Operation failed');
            $this->session->set_flashdata('message_type', 'error');
        }

        redirect('index.php/Dashboard/customer_management');
    }

    public function delete_customer($customer_id) {
        // Delete customer
        $result = $this->Customer_model->delete_customer($customer_id);

        if ($result) {
            $this->session->set_flashdata('message', 'Customer deleted successfully');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Failed to delete customer');
            $this->session->set_flashdata('message_type', 'error');
        }

        redirect('index.php/Dashboard/customer_management');
    }
}