<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_pembelian()
    {
        $this->db->select('p.*, s.nama_supplier, u.nama_lengkap as dibuat_oleh_nama');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->join('users u', 'p.dibuat_oleh = u.user_id', 'left');
        $this->db->order_by('p.pembelian_id', 'DESC');
        
        return $this->db->get()->result();
    }

    

    // Di Pembelian_model
public function create_pembelian($data) {
    $this->db->insert('pembelian', $data);
    return $this->db->insert_id();
}

public function get_detail_pembelian($pembelian_id)
{
    // Menggunakan query builder untuk memilih kolom
    $this->db->select('dp.*, pr.kode_produk, pr.nama_produk, k.nama_kategori, 
                       (dp.jumlah * dp.harga_satuan) as subtotal');
    $this->db->from('detail_pembelian dp');
    $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
    $this->db->join('kategori k', 'pr.kategori_id = k.kategori_id');
    $this->db->where('dp.pembelian_id', $pembelian_id);
    
    // Menangani jika tidak ada hasil
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result();  // Mengembalikan hasil jika data ditemukan
    } else {
        return [];  // Mengembalikan array kosong jika tidak ada hasil
    }
}

public function get_pembelian_by_id($id)
{
    // Memilih kolom yang diperlukan dengan join
    $this->db->select('p.*, s.nama_supplier, s.kontak_person, s.telepon as supplier_telepon, 
                       u.nama_lengkap as dibuat_oleh_nama');
    $this->db->from('pembelian p');
    $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
    $this->db->join('users u', 'p.dibuat_oleh = u.user_id', 'left');
    $this->db->where('p.pembelian_id', $id);
    
    // Menangani hasil query kosong
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row();  // Mengembalikan hasil jika data ditemukan
    } else {
        return null;  // Mengembalikan null jika tidak ada hasil
    }
}


    public function update_pembelian($id, $data)
    {
        $this->db->where('pembelian_id', $id);
        return $this->db->update('pembelian', $data);
    }

    public function delete_pembelian($id)
    {
        // Start transaction
        $this->db->trans_start();
        
        // Delete detail first
        $this->db->where('pembelian_id', $id);
        $this->db->delete('detail_pembelian');
        
        // Delete main record
        $this->db->where('pembelian_id', $id);
        $this->db->delete('pembelian');
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function save_detail_pembelian($pembelian_id, $detail_data)
    {
        // Delete existing details
        $this->db->where('pembelian_id', $pembelian_id);
        $this->db->delete('detail_pembelian');
        
        // Insert new details
        if (!empty($detail_data)) {
            return $this->db->insert_batch('detail_pembelian', $detail_data);
        }
        
        return true;
    }

    public function update_total_pembelian($pembelian_id, $total_harga)
    {
        $data = array('total_harga' => $total_harga);
        $this->db->where('pembelian_id', $pembelian_id);
        return $this->db->update('pembelian', $data);
    }

    public function terima_pembelian($pembelian_id)
    {
        $this->db->trans_start();
        
        // Update status pembelian
        $this->db->where('pembelian_id', $pembelian_id);
        $this->db->update('pembelian', array(
            'status' => 'diterima',
            'tanggal_terima' => date('Y-m-d')
        ));
        
        // Get detail pembelian
        $details = $this->get_detail_pembelian($pembelian_id);
        
        // Update stock for each product (langsung update tabel produk)
        foreach ($details as $detail) {
            $this->db->set('jumlah_stok', 'jumlah_stok + ' . (int)$detail->jumlah, FALSE);
            $this->db->where('produk_id', $detail->produk_id);
            $this->db->update('produk');
        }
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function get_last_po_number($date)
    {
        $this->db->select('nomor_po');
        $this->db->from('pembelian');
        $this->db->like('nomor_po', 'PO' . $date, 'after');
        $this->db->order_by('nomor_po', 'DESC');
        $this->db->limit(1);
        
        return $this->db->get()->row();
    }

    public function get_pembelian_by_date_range($start_date, $end_date)
    {
        $this->db->select('p.*, s.nama_supplier, u.nama_lengkap as dibuat_oleh_nama');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->join('users u', 'p.dibuat_oleh = u.user_id', 'left');
        $this->db->where('p.tanggal_pesan >=', $start_date);
        $this->db->where('p.tanggal_pesan <=', $end_date);
        $this->db->order_by('p.tanggal_pesan', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_pembelian_by_supplier($supplier_id)
    {
        $this->db->select('p.*, s.nama_supplier, u.nama_lengkap as dibuat_oleh_nama');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->join('users u', 'p.dibuat_oleh = u.user_id', 'left');
        $this->db->where('p.supplier_id', $supplier_id);
        $this->db->order_by('p.tanggal_pesan', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_pembelian_by_supplier_and_date($supplier_id, $start_date, $end_date)
    {
        $this->db->select('p.*, s.nama_supplier, u.nama_lengkap as dibuat_oleh_nama');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->join('users u', 'p.dibuat_oleh = u.user_id', 'left');
        $this->db->where('p.supplier_id', $supplier_id);
        $this->db->where('p.tanggal_pesan >=', $start_date);
        $this->db->where('p.tanggal_pesan <=', $end_date);
        $this->db->order_by('p.tanggal_pesan', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_pembelian_by_status($status)
    {
        $this->db->select('p.*, s.nama_supplier, u.nama_lengkap as dibuat_oleh_nama');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->join('users u', 'p.dibuat_oleh = u.user_id', 'left');
        $this->db->where('p.status', $status);
        $this->db->order_by('p.tanggal_pesan', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_pembelian_pending()
    {
        $this->db->select('p.*, s.nama_supplier');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->where('p.status', 'dipesan');
        $this->db->order_by('p.tanggal_pesan', 'ASC');
        
        return $this->db->get()->result();
    }

    public function get_total_pembelian_bulan_ini()
    {
        $this->db->select_sum('total_harga');
        $this->db->from('pembelian');
        $this->db->where('YEAR(tanggal_pesan)', date('Y'));
        $this->db->where('MONTH(tanggal_pesan)', date('m'));
        $this->db->where('status', 'diterima');
        
        $result = $this->db->get()->row();
        return $result->total_harga ?: 0;
    }

    public function get_jumlah_po_pending()
    {
        $this->db->from('pembelian');
        $this->db->where('status', 'dipesan');
        
        return $this->db->count_all_results();
    }

    public function get_supplier_terbanyak($limit = 10)
    {
        $this->db->select('s.nama_supplier, COUNT(p.pembelian_id) as total_po, 
                          SUM(p.total_harga) as total_pembelian');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->where('p.status', 'diterima');
        $this->db->group_by('p.supplier_id');
        $this->db->order_by('total_pembelian', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    public function get_pembelian_chart_data($months = 12)
    {
        $this->db->select('DATE_FORMAT(tanggal_pesan, "%Y-%m") as bulan, 
                          SUM(total_harga) as total_pembelian,
                          COUNT(*) as jumlah_po');
        $this->db->from('pembelian');
        $this->db->where('status', 'diterima');
        $this->db->where('tanggal_pesan >=', date('Y-m-d', strtotime("-$months months")));
        $this->db->group_by('DATE_FORMAT(tanggal_pesan, "%Y-%m")');
        $this->db->order_by('bulan', 'ASC');
        
        return $this->db->get()->result();
    }

    public function get_produk_sering_dibeli($limit = 10)
    {
        $this->db->select('pr.kode_produk, pr.nama_produk, SUM(dp.jumlah) as total_dibeli,
                          AVG(dp.harga_satuan) as rata_harga');
        $this->db->from('detail_pembelian dp');
        $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
        $this->db->join('pembelian p', 'dp.pembelian_id = p.pembelian_id');
        $this->db->where('p.status', 'diterima');
        $this->db->group_by('dp.produk_id');
        $this->db->order_by('total_dibeli', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    public function cek_nomor_po_exists($nomor_po, $exclude_id = null)
    {
        $this->db->from('pembelian');
        $this->db->where('nomor_po', $nomor_po);
        
        if ($exclude_id) {
            $this->db->where('pembelian_id !=', $exclude_id);
        }
        
        return $this->db->count_all_results() > 0;
    }

    public function get_riwayat_harga_produk($produk_id, $limit = 10)
    {
        $this->db->select('dp.harga_satuan, p.tanggal_pesan, s.nama_supplier');
        $this->db->from('detail_pembelian dp');
        $this->db->join('pembelian p', 'dp.pembelian_id = p.pembelian_id');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->where('dp.produk_id', $produk_id);
        $this->db->where('p.status', 'diterima');
        $this->db->order_by('p.tanggal_pesan', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    public function batalkan_pembelian($pembelian_id, $alasan = '')
    {
        $data = array(
            'status' => 'dibatalkan',
            'catatan' => $this->db->escape_str($alasan),
            'tanggal_batal' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('pembelian_id', $pembelian_id);
        return $this->db->update('pembelian', $data);
    }

    public function get_estimasi_kedatangan()
    {
        $this->db->select('p.*, s.nama_supplier, 
                          DATEDIFF(p.estimasi_kedatangan, CURDATE()) as hari_tersisa');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->where('p.status', 'dipesan');
        $this->db->where('p.estimasi_kedatangan IS NOT NULL');
        $this->db->order_by('p.estimasi_kedatangan', 'ASC');
        
        return $this->db->get()->result();
    }

    public function delete_detail_pembelian($pembelian_id)
    {
        $this->db->where('pembelian_id', $pembelian_id);
        return $this->db->delete('detail_pembelian');
    }

    public function get_pembelian_filtered($date_start = null, $date_end = null, $supplier_id = null, $status = null)
    {
        $this->db->select('p.*, s.nama_supplier, u.nama_lengkap as dibuat_oleh_nama');
        $this->db->from('pembelian p');
        $this->db->join('suppliers s', 'p.supplier_id = s.supplier_id');
        $this->db->join('users u', 'p.dibuat_oleh = u.user_id', 'left');

        if ($date_start) {
            $this->db->where('p.tanggal_pesan >=', $date_start);
        }
        if ($date_end) {
            $this->db->where('p.tanggal_pesan <=', $date_end);
        }
        if ($supplier_id) {
            $this->db->where('p.supplier_id', $supplier_id);
        }
        if ($status && $status !== 'all') {
            $this->db->where('p.status', $status);
        }
        $this->db->order_by('p.tanggal_pesan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_total_pembelian_today() {
        $this->db->select_sum('total_harga');
        $this->db->where('tanggal_pesan', date('Y-m-d'));
        $query = $this->db->get('pembelian');
        return $query->row()->total_harga ?? 0;
    }

    public function get_total_pembelian_mingguan() {
        $this->db->select_sum('total_harga');
        $this->db->where('tanggal_pesan >=', date('Y-m-d', strtotime('-7 days')));
        $this->db->where('tanggal_pesan <=', date('Y-m-d'));
        $query = $this->db->get('pembelian');
        return $query->row()->total_harga ?? 0;
    }

    public function get_total_pembelian_bulanan() {
        $this->db->select_sum('total_harga');
        $this->db->where('tanggal_pesan >=', date('Y-m-01'));
        $this->db->where('tanggal_pesan <=', date('Y-m-t'));
        $query = $this->db->get('pembelian');
        return $query->row()->total_harga ?? 0;
    }

    // Tambahan: total semua pengeluaran (semua pembelian)
    public function get_total_pembelian_all() {
        $this->db->select_sum('total_harga');
        $query = $this->db->get('pembelian');
        return $query->row()->total_harga ?? 0;
    }
}