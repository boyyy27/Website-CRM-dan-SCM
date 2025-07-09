<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the session library
        $this->load->library('session');
        // Load the form_validation library
        $this->load->library('form_validation');
        // Load the Auth model
        $this->load->model('Auth_model'); 
        $this->load->helper('url'); 
         // Load URL helper
       
    }

    // Display the signup form
   public function signup() {
        // Load form helper untuk set_value() function
        $this->load->helper('form');
        
        // Load view dengan data kosong untuk form pertama kali
        $data['title'] = 'Sign Up - ZE Vapestore';
        $this->load->view('signup', $data);
    }

    // Handle form submission and insert data into the database
    public function submit_signup()
    {
        // Load form helper untuk set_value() dan form_error()
        $this->load->helper('form');
        
        // Validasi input form
        $this->form_validation->set_rules('nama_lengkap', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[20]|is_unique[customers.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[customers.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        // Set custom error messages
        $this->form_validation->set_message('required', '{field} is required.');
        $this->form_validation->set_message('min_length', '{field} must be at least {param} characters.');
        $this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
        $this->form_validation->set_message('is_unique', 'This {field} already exists.');
        $this->form_validation->set_message('valid_email', 'Please enter a valid email address.');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan form lagi dengan error message
            $data['title'] = 'Sign Up - ZE Vapestore';
            $this->load->view('signup', $data);
        } else {
            // Sanitize input data
            $nama_lengkap = trim($this->input->post('nama_lengkap'));
            $username = trim(strtolower($this->input->post('username')));
            $email = trim(strtolower($this->input->post('email')));
            $password = $this->input->post('password');

            // Validasi tambahan di server side
            if (strlen($password) < 6) {
                $this->session->set_flashdata('message', 'Password must be at least 6 characters long.');
                redirect('Auth/signup');
                return;
            }

            // Ambil data dari form
            $data = array(
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT), // Enkripsi password
                'status' => 'aktif', // Set status aktif
                'tanggal_daftar' => date('Y-m-d H:i:s'), // Timestamp registrasi
            );

            // Cek apakah model sudah di-load
            if (!isset($this->Auth_model)) {
                $this->load->model('Auth_model');
            }

            try {
                // Panggil model untuk menyimpan data customer
                $customer_id = $this->Auth_model->register_customer($data);

                if ($customer_id && $customer_id > 0) {
                    // Jika berhasil, set session success message
                    $this->session->set_flashdata('message', 'Registration successful! You can now login.');
                    $this->session->set_flashdata('message_type', 'success');
                    redirect('index.php/Auth/signin');
                } else {
                    // Jika gagal, tampilkan error
                    $this->session->set_flashdata('message', 'Registration failed. Please try again.');
                    $this->session->set_flashdata('message_type', 'error');
                    redirect('index.php/Auth/signup');
                }
            } catch (Exception $e) {
                // Handle database errors
                log_message('error', 'Registration error: ' . $e->getMessage());
                $this->session->set_flashdata('message', 'Registration failed due to system error. Please try again.');
                $this->session->set_flashdata('message_type', 'error');
                redirect('index.php/Auth/signup');
            }
        }
    }

    public function signin()
    {
        $this->load->view('login'); // Menampilkan halaman login
    }

  public function submit_login()
{
    // Validasi input form
    $this->form_validation->set_rules('username_or_email', 'Username or Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, tampilkan form login kembali dengan error
        $this->load->view('login');
    } else {
        // Ambil data input dari form
        $username_or_email = $this->input->post('username_or_email');
        $password = $this->input->post('password');

        // Periksa apakah pengguna adalah customer atau user (admin, kasir, owner)
        $customer = $this->Auth_model->login_customer($username_or_email, $password);
        $user = $this->Auth_model->login_user($username_or_email, $password);

        if ($customer) {
            // Jika customer berhasil login, set session dan redirect ke landing page
            $this->session->set_userdata('customer_id', $customer->customer_id);
            $this->session->set_userdata('nama_lengkap', $customer->nama_lengkap);
            $this->session->set_userdata('username', $customer->username);
            $this->session->set_userdata('foto', $customer->foto);
            $this->session->set_userdata('logged_in', true);
            redirect('index.php/Welcome/landing'); // Halaman untuk customer
        } elseif ($user) {
            // Jika user (admin, kasir, owner) berhasil login, set session
            $this->session->set_userdata('user_id', $user->user_id);
            $this->session->set_userdata('nama_lengkap', $user->nama_lengkap);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('role', $user->role);

            // Redirect berdasarkan role
            if ($user->role == 'admin') {
                redirect('index.php/Dashboard/admin_dashboard'); // Redirect admin ke dashboard admin
            } elseif ($user->role == 'kasir') {
                redirect('index.php/Penjualan/penjualan'); // Redirect kasir ke halaman penjualan
            } elseif ($user->role == 'owner') {
                redirect('index.php/Dashboard/admin_dashboard'); // Redirect owner ke dashboard admin
            } else {
                redirect('index.php/Welcome/landing'); // Default redirect untuk role lainnya
            }
        } else {
            // Jika login gagal, tampilkan pesan error
            $this->session->set_flashdata('message', 'Invalid username/email or password!');
            redirect('index.php/Auth/signin');
        }
    }
}


    // Logout user
    public function logout()
    {
        // Hapus session dan redirect ke halaman login
        $this->session->sess_destroy();
        redirect('index.php/welcome/landing');
    }
}
