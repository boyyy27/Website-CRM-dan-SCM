<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
    }

    /**
     * Generate unique customer code
     * @return string
     */
    private function generate_customer_code() {
        // Get the last customer code
        $this->db->select('kode_customer');
        $this->db->from('customers');
        $this->db->order_by('customer_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $last_code = $query->row()->kode_customer;
            // Extract the number part and increment
            $number = intval(substr($last_code, 4)) + 1;
        } else {
            $number = 1;
        }
        
        // Format: CUST001, CUST002, etc.
        return 'CUST' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Register new customer
     * @param array $data - Customer data
     * @return int|false - Customer ID if success, false if failed
     */
    public function register_customer($data) {
        try {
            // Generate customer code
            $data['kode_customer'] = $this->generate_customer_code();
            
            // Insert data ke table customers
            $this->db->insert('customers', $data);
            
            // Cek apakah insert berhasil
            if ($this->db->affected_rows() > 0) {
                // Return customer ID yang baru saja diinsert
                return $this->db->insert_id();
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Log error untuk debugging
            log_message('error', 'Database error in register_customer: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Login customer dengan username/email dan password
     * @param string $username_or_email - Username atau email
     * @param string $password - Password (plain text)
     * @return object|false - User object if success, false if failed
     */
   public function login_customer($username_or_email, $password) {
    try {
        // Query untuk mencari customer berdasarkan username atau email
        $this->db->where('(username = "' . $this->db->escape_str($username_or_email) . '" OR email = "' . $this->db->escape_str($username_or_email) . '")');
        $this->db->where('status', 'aktif'); // Hanya customer yang aktif
        $query = $this->db->get('customers');

        if ($query->num_rows() == 1) {
            $customer = $query->row();
            
            // Verifikasi password
            if (password_verify($password, $customer->password)) {
                // Hapus password untuk keamanan
                unset($customer->password);
                return $customer; // Mengembalikan data customer
            } else {
                return false; // Password salah
            }
        } else {
            return false; // Customer tidak ditemukan
        }
    } catch (Exception $e) {
        log_message('error', 'Database error in login_customer: ' . $e->getMessage());
        return false;
    }
}

public function login_user($username_or_email, $password) {
    try {
        // Query untuk mencari user berdasarkan username atau email
        $this->db->where('(username = "' . $this->db->escape_str($username_or_email) . '" OR email = "' . $this->db->escape_str($username_or_email) . '")');
        $this->db->where('status', 'aktif'); // Hanya user yang aktif
        $query = $this->db->get('users'); // Menggunakan tabel `users` untuk login

        if ($query->num_rows() == 1) {
            $user = $query->row();
            
            // Verifikasi password
            if (password_verify($password, $user->password)) {
                // Hapus password untuk keamanan
                unset($user->password);
                return $user; // Mengembalikan data user (admin, kasir, owner)
            } else {
                return false; // Password salah
            }
        } else {
            return false; // User tidak ditemukan
        }
    } catch (Exception $e) {
        log_message('error', 'Database error in login_user: ' . $e->getMessage());
        return false;
    }
}


    /**
     * Cek apakah username sudah ada
     * @param string $username
     * @return bool - true if exists, false if not
     */
    public function check_username_exists($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('customers');
        return ($query->num_rows() > 0);
    }

    /**
     * Cek apakah email sudah ada
     * @param string $email
     * @return bool - true if exists, false if not
     */
    public function check_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('customers');
        return ($query->num_rows() > 0);
    }

    /**
     * Get customer by ID
     * @param int $customer_id
     * @param bool $with_password - Whether to include password in the result
     * @return object|false - Customer object if found, false if not
     */
    public function get_customer_by_id($customer_id, $with_password = false) {
        try {
            $this->db->where('customer_id', $customer_id);
            $this->db->where('status', 'aktif');
            $query = $this->db->get('customers');

            if ($query->num_rows() == 1) {
                $user = $query->row();
                if (!$with_password) {
                    unset($user->password);
                }
                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Database error in get_customer_by_id: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update customer profile
     * @param int $customer_id
     * @param array $data
     * @return bool - true if success, false if failed
     */
    public function update_customer($customer_id, $data) {
    try {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customers', $data);
        
        return ($this->db->affected_rows() > 0);
    } catch (Exception $e) {
        log_message('error', 'Database error in update_customer: ' . $e->getMessage());
        return false;
    }
}


    /**
     * Update last login time
     * @param int $customer_id
     * @return bool
     */
    private function update_last_login($customer_id) {
        try {
            $data = array(
                'last_login' => date('Y-m-d H:i:s')
            );
            
            $this->db->where('customer_id', $customer_id);
            $this->db->update('customers', $data);
            
            return true;
        } catch (Exception $e) {
            log_message('error', 'Database error in update_last_login: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Reset password - Generate reset token
     * @param string $email
     * @return string|false - Reset token if success, false if failed
     */
    public function generate_reset_token($email) {
        try {
            // Cek apakah email ada
            $this->db->where('email', $email);
            $this->db->where('status', 'aktif');
            $query = $this->db->get('customers');

            if ($query->num_rows() == 1) {
                // Generate random token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token berlaku 1 jam

                $data = array(
                    'reset_token' => $token,
                    'reset_expires' => $expires
                );

                $this->db->where('email', $email);
                $this->db->update('customers', $data);

                return $token;
            } else {
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Database error in generate_reset_token: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Reset password dengan token
     * @param string $token
     * @param string $new_password
     * @return bool
     */
    public function reset_password($token, $new_password) {
        try {
            // Cek token dan belum expired
            $this->db->where('reset_token', $token);
            $this->db->where('reset_expires >', date('Y-m-d H:i:s'));
            $this->db->where('status', 'aktif');
            $query = $this->db->get('customers');

            if ($query->num_rows() == 1) {
                $data = array(
                    'password' => password_hash($new_password, PASSWORD_DEFAULT),
                    'reset_token' => null,
                    'reset_expires' => null
                );

                $this->db->where('reset_token', $token);
                $this->db->update('customers', $data);

                return ($this->db->affected_rows() > 0);
            } else {
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Database error in reset_password: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Deactivate customer account
     * @param int $customer_id
     * @return bool
     */
    public function deactivate_customer($customer_id) {
        try {
            $data = array(
                'status' => 'inactive',
                'deactivated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('customer_id', $customer_id);
            $this->db->update('customers', $data);

            return ($this->db->affected_rows() > 0);
        } catch (Exception $e) {
            log_message('error', 'Database error in deactivate_customer: ' . $e->getMessage());
            return false;
        }
    }
}