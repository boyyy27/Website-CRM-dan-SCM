<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the session library
        $this->load->library('session');
        // Load the form_validation library
        $this->load->library('form_validation');
        // Load the Auth model
        $this->load->model('Auth_model'); 
        $this->load->helper('url'); 

        
    
    }

    public function account()
    {
        // Check if user is logged in
        $customer_id = $this->session->userdata('customer_id');
        if (!$customer_id) {
            redirect('index.php/auth/login'); // Redirect to login if not logged in
        }

        // Get user data
        $user = $this->Auth_model->get_customer_by_id($customer_id);
        if (!$user) {
            show_error('User not found', 404);
        }

        // Pass user data to view
        $data['user'] = $user;
        $this->load->view('account', $data);
    }

    public function update_account()
    {
        // Check if user is logged in
        $customer_id = $this->session->userdata('customer_id');
        if (!$customer_id) {
            redirect('index.php/auth/login');
        }

        // Set validation rules
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('telepon', 'Telepon', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');

        $this->load->model('Auth_model');
        $user = $this->Auth_model->get_customer_by_id($customer_id, true);
        $foto = $user->foto ?? '';
        // Handle file upload
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = uniqid('customer_') . '_' . time();
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
                // Hapus foto lama jika ada
                if (!empty($user->foto) && file_exists('./assets/uploads/' . $user->foto)) {
                    @unlink('./assets/uploads/' . $user->foto);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('index.php/account/account');
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload form with errors
            $this->account();
        } else {
            // Prepare data for update
            $update_data = array(
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'telepon' => $this->input->post('telepon'),
                'alamat' => $this->input->post('alamat'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'foto' => $foto
            );

            // Update user data
            $updated = $this->Auth_model->update_customer($customer_id, $update_data);

            if ($updated) {
                $this->session->set_flashdata('success', 'Account updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update account.');
            }

            redirect('index.php/account/account');
        }
    }

    public function change_password() {
        $role = $this->session->userdata('role');
        if ($role && in_array($role, ['admin', 'kasir', 'owner'], true)) {
            $user_id = $this->session->userdata('user_id');
            if (!$user_id) redirect('index.php/auth/login');
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('change_password_admin');
            $this->load->view('template/footer');
        } else {
            $customer_id = $this->session->userdata('customer_id');
            if (!$customer_id) redirect('index.php/auth/login');
            $this->load->view('change_password');
        }
    }

    public function update_password() {
        $role = $this->session->userdata('role');
        if ($role == 'admin' || $role == 'kasir' || $role == 'owner') {
            $user_id = $this->session->userdata('user_id');
            if (!$user_id) redirect('index.php/auth/login');
            $this->load->model('User_model');
            $user = $this->User_model->get_user_by_id($user_id);
            $stored_password = $user['password'];
        } else {
            $customer_id = $this->session->userdata('customer_id');
            if (!$customer_id) redirect('index.php/auth/login');
            $this->load->model('Auth_model');
            $user = $this->Auth_model->get_customer_by_id($customer_id, true);
            $stored_password = $user->password;
        }
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');
        if ($this->form_validation->run() == FALSE) {
            $this->change_password();
        } else {
            $current_password_input = $this->input->post('current_password');
            // Periksa apakah password yang tersimpan adalah hash
            if (strlen($stored_password) === 60) {
                $password_match = password_verify($current_password_input, $stored_password);
            } else {
                $password_match = ($current_password_input === $stored_password);
            }
            if (!$password_match) {
                $this->session->set_flashdata('error', 'Current password is incorrect.');
                redirect('index.php/account/change_password');
                return;
            }
            $new_password_hashed = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
            if ($role == 'admin' || $role == 'kasir' || $role == 'owner') {
                $updated = $this->User_model->update_user($user_id, ['password' => $new_password_hashed]);
            } else {
                $updated = $this->Auth_model->update_customer($customer_id, ['password' => $new_password_hashed]);
            }
            if ($updated) {
                $this->session->set_flashdata('success', 'Password updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update password.');
            }
            redirect('index.php/account/change_password');
        }
    }

    public function history_pembelian()
    {
        // Check if user is logged in dan customer_id ada
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('customer_id')) {
            redirect('index.php/Auth/login');
        }

        $this->load->model('Penjualan_model');
        
        // Get filter parameters
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $status_bayar = $this->input->get('status_bayar');
        
        // Get customer ID from session
        $customer_id = $this->session->userdata('customer_id');
        
        // Get purchase history
        $data['history_pembelian'] = $this->Penjualan_model->get_purchase_history($customer_id, $date_start, $date_end, $status_bayar);
        $data['title'] = 'History Pembelian';
        
        $this->load->view('template/header', $data);
        $this->load->view('history_pembelian', $data);
        $this->load->view('template/footer');
    }

    public function detail_pembelian($penjualan_id)
    {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('index.php/Auth/login');
        }

        $this->load->model('Penjualan_model');
        
        // Get user ID from session
        $user_id = $this->session->userdata('user_id');
        
        // Get purchase detail
        $data['detail_pembelian'] = $this->Penjualan_model->get_purchase_detail($penjualan_id, $user_id);
        
        if (!$data['detail_pembelian']) {
            $this->session->set_flashdata('error', 'Data pembelian tidak ditemukan');
            redirect('index.php/account/history_pembelian');
        }
        
        $data['title'] = 'Detail Pembelian';
        
        $this->load->view('template/header', $data);
        $this->load->view('detail_pembelian', $data);
        $this->load->view('template/footer');
    }

    public function change_profile() {
        $role = $this->session->userdata('role');
        if ($role == 'admin' || $role == 'kasir' || $role == 'owner') {
            $user_id = $this->session->userdata('user_id');
            if (!$user_id) redirect('index.php/auth/login');
            $this->load->model('User_model');
            $user = $this->User_model->get_user_by_id($user_id);
            if ($this->input->method() === 'post') {
                $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('telepon', 'Telepon', 'trim');
                $foto = $user['foto'] ?? '';
                // Handle file upload
                if (!empty($_FILES['foto']['name'])) {
                    $config['upload_path'] = './assets/uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 2048; // 2MB
                    $config['file_name'] = uniqid('user_') . '_' . time();
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('foto')) {
                        $upload_data = $this->upload->data();
                        $foto = $upload_data['file_name'];
                        // Hapus foto lama jika ada
                        if (!empty($user['foto']) && file_exists('./assets/uploads/' . $user['foto'])) {
                            @unlink('./assets/uploads/' . $user['foto']);
                        }
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('index.php/account/change_profile');
                        return;
                    }
                }
                if ($this->form_validation->run() == TRUE) {
                    $update_data = [
                        'nama_lengkap' => $this->input->post('nama_lengkap'),
                        'email' => $this->input->post('email'),
                        'telepon' => $this->input->post('telepon'),
                        'foto' => $foto
                    ];
                    $updated = $this->User_model->update_user($user_id, $update_data);
                    if ($updated) {
                        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
                    }
                    redirect('index.php/account/change_profile');
                }
            }
        } else {
            $customer_id = $this->session->userdata('customer_id');
            if (!$customer_id) redirect('index.php/auth/login');
            $this->load->model('Auth_model');
            $user = $this->Auth_model->get_customer_by_id($customer_id);
            if ($this->input->method() === 'post') {
                $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('telepon', 'Telepon', 'trim');
                $foto = $user->foto ?? '';
                // Handle file upload
                if (!empty($_FILES['foto']['name'])) {
                    $config['upload_path'] = './assets/uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 2048; // 2MB
                    $config['file_name'] = uniqid('customer_') . '_' . time();
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('foto')) {
                        $upload_data = $this->upload->data();
                        $foto = $upload_data['file_name'];
                        // Hapus foto lama jika ada
                        if (!empty($user->foto) && file_exists('./assets/uploads/' . $user->foto)) {
                            @unlink('./assets/uploads/' . $user->foto);
                        }
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('index.php/account/change_profile');
                        return;
                    }
                }
                if ($this->form_validation->run() == TRUE) {
                    $update_data = [
                        'nama_lengkap' => $this->input->post('nama_lengkap'),
                        'email' => $this->input->post('email'),
                        'telepon' => $this->input->post('telepon'),
                        'foto' => $foto
                    ];
                    $updated = $this->Auth_model->update_customer($customer_id, $update_data);
                    if ($updated) {
                        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
                    }
                    redirect('index.php/account/change_profile');
                }
            }
        }
        $data['user'] = is_array($user) ? (object)$user : $user;
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('change_profile', $data);
        $this->load->view('template/footer');
    }

}
