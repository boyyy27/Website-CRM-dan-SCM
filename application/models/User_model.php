<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil semua pengguna dari tabel 'users'
     * @return array - Daftar pengguna
     */
    public function get_all_users() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_lengkap', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Menambah pengguna baru ke tabel 'users'
     * @param array $data - Data pengguna yang akan ditambahkan
     * @return bool - True jika berhasil, false jika gagal
     */
    public function create_user($data) {
        return $this->db->insert('users', $data);
    }

    /**
     * Mengupdate data pengguna berdasarkan user_id
     * @param int $user_id - ID pengguna yang akan diupdate
     * @param array $data - Data yang akan diperbarui
     * @return bool - True jika berhasil, false jika gagal
     */
    public function update_user($user_id, $data) {
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Menghapus pengguna berdasarkan user_id
     * @param int $user_id - ID pengguna yang akan dihapus
     * @return bool - True jika berhasil, false jika gagal
     */
    public function delete_user($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('users');
    }

    /**
     * Mengambil data pengguna berdasarkan user_id
     * @param int $user_id - ID pengguna yang akan diambil
     * @return array - Data pengguna yang sesuai dengan user_id
     */
    public function get_user_by_id($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('users');
        return $query->row_array(); // Mengembalikan hasil sebagai array
    }
}
