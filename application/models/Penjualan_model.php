<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_penjualan()
    {
        $this->db->select('p.*, c.nama_lengkap as nama_customer, u.nama_lengkap as kasir_nama');
        $this->db->from('penjualan p');
        $this->db->join('customers c', 'p.customer_id = c.customer_id', 'left');
        $this->db->join('users u', 'p.dilayani_oleh = u.user_id', 'left');
        $this->db->order_by('p.penjualan_id', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_penjualan_by_id($id)
    {
        $this->db->select('p.*, c.nama_lengkap as nama_customer, c.telepon as customer_telepon, c.alamat as customer_alamat,
                          u.nama_lengkap as kasir_nama');
        $this->db->from('penjualan p');
        $this->db->join('customers c', 'p.customer_id = c.customer_id', 'left');
        $this->db->join('users u', 'p.dilayani_oleh = u.user_id', 'left');
        $this->db->where('p.penjualan_id', $id);
        
        return $this->db->get()->row();
    }

    public function get_detail_penjualan($penjualan_id)
    {
        $this->db->select('dp.*, pr.nama_produk, pr.kode_produk, k.nama_kategori,
                          (dp.jumlah * dp.harga_satuan) as subtotal');
        $this->db->from('detail_penjualan dp');
        $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
        $this->db->join('kategori k', 'pr.kategori_id = k.kategori_id');
        $this->db->where('dp.penjualan_id', $penjualan_id);
        
        return $this->db->get()->result();
    }

    public function get_penjualan_filtered($date_start = null, $date_end = null, $customer_id = null, $status_bayar = null, $kasir_id = null)
    {
        $this->db->select('p.*, c.nama_lengkap as nama_customer, u.nama_lengkap as kasir_nama');
        $this->db->from('penjualan p');
        $this->db->join('customers c', 'p.customer_id = c.customer_id', 'left');
        $this->db->join('users u', 'p.dilayani_oleh = u.user_id', 'left');
        if ($date_start && $date_end) {
            $this->db->where('p.tanggal_jual >=', $date_start);
            $this->db->where('p.tanggal_jual <=', $date_end.' 23:59:59');
        }
        if ($customer_id) {
            $this->db->where('p.customer_id', $customer_id);
        }
        if ($status_bayar && $status_bayar !== 'all') {
            $this->db->where('p.status_bayar', $status_bayar);
        }
        if ($kasir_id) {
            $this->db->where('p.dilayani_oleh', $kasir_id);
        }
        $this->db->order_by('p.tanggal_jual', 'DESC');
        return $this->db->get()->result();
    }

    public function create_penjualan($data)
    {
        $this->db->insert('penjualan', $data);
        return $this->db->insert_id();
    }

    public function update_penjualan($id, $data)
    {
        $this->db->where('penjualan_id', $id);
        return $this->db->update('penjualan', $data);
    }

    public function delete_penjualan($id)
    {
        // Hapus detail penjualan dulu agar tidak gagal karena foreign key
        $this->db->where('penjualan_id', $id);
        $this->db->delete('detail_penjualan');
        // Baru hapus penjualan utama
        $this->db->where('penjualan_id', $id);
        return $this->db->delete('penjualan');
    }

    public function save_detail_penjualan($penjualan_id, $detail_data)
    {
        // Delete existing details
        $this->db->where('penjualan_id', $penjualan_id);
        $this->db->delete('detail_penjualan');
        
        // Insert new details
        if (!empty($detail_data)) {
            return $this->db->insert_batch('detail_penjualan', $detail_data);
        }
        
        return true;
    }

    public function update_total_penjualan($penjualan_id, $subtotal, $diskon, $pajak, $total_bayar)
    {
        $data = array(
            'subtotal' => $subtotal,
            'diskon' => $diskon,
            'pajak' => $pajak,
            'total_bayar' => $total_bayar
        );
        $this->db->where('penjualan_id', $penjualan_id);
        return $this->db->update('penjualan', $data);
    }

    public function update_stock_penjualan($penjualan_id)
    {
        // Get detail penjualan
        $details = $this->get_detail_penjualan($penjualan_id);
        
        // Update stock for each product (langsung update tabel produk)
        foreach ($details as $detail) {
            $this->db->set('jumlah_stok', 'jumlah_stok - ' . (int)$detail->jumlah, FALSE);
            $this->db->where('produk_id', $detail->produk_id);
            $this->db->update('produk');
        }
        
        return true;
    }

    public function restore_stock_penjualan($penjualan_id)
    {
        // Get detail penjualan
        $details = $this->get_detail_penjualan($penjualan_id);
        
        // Restore stock for each product
        foreach ($details as $detail) {
            // Add back the stock that was reduced
            $this->db->set('jumlah_stok', 'jumlah_stok + ' . $detail->jumlah, FALSE);
            $this->db->where('produk_id', $detail->produk_id);
            $this->db->update('produk');
        }
        
        return true;
    }

    public function get_last_invoice_number($date)
    {
        $this->db->select('nomor_invoice');
        $this->db->from('penjualan');
        $this->db->like('nomor_invoice', 'INV' . $date, 'after');
        $this->db->order_by('nomor_invoice', 'DESC');
        $this->db->limit(1);
        
        return $this->db->get()->row();
    }

    public function get_penjualan_by_date_range($start_date, $end_date)
    {
        $this->db->select('p.*, c.nama_customer');
        $this->db->from('penjualan p');
        $this->db->join('customers c', 'p.customer_id = c.customer_id', 'left');
        $this->db->where('DATE(p.tanggal_jual) >=', $start_date);
        $this->db->where('DATE(p.tanggal_jual) <=', $end_date);
        $this->db->order_by('p.tanggal_jual', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_penjualan_by_customer($customer_id)
    {
        $this->db->select('p.*, c.nama_customer');
        $this->db->from('penjualan p');
        $this->db->join('customers c', 'p.customer_id = c.customer_id');
        $this->db->where('p.customer_id', $customer_id);
        $this->db->order_by('p.tanggal_jual', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_penjualan_by_status($status_bayar)
    {
        $this->db->select('p.*, c.nama_customer');
        $this->db->from('penjualan p');
        $this->db->join('customers c', 'p.customer_id = c.customer_id', 'left');
        $this->db->where('p.status_bayar', $status_bayar);
        $this->db->order_by('p.tanggal_jual', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_penjualan_belum_lunas()
    {
        $this->db->select('p.*, c.nama_customer');
        $this->db->from('penjualan p');
        $this->db->join('customers c', 'p.customer_id = c.customer_id', 'left');
        $this->db->where('p.status_bayar', 'belum_lunas');
        $this->db->order_by('p.tanggal_jual', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_total_penjualan_today()
    {
        $this->db->select_sum('total_bayar');
        $this->db->from('penjualan');
        $this->db->where('DATE(tanggal_jual)', date('Y-m-d'));
        $this->db->where('status_bayar', 'lunas');
        
        $result = $this->db->get()->row();
        return $result->total_bayar ?: 0;
    }

    public function get_total_penjualan_bulan_ini()
    {
        $this->db->select_sum('total_bayar');
        $this->db->from('penjualan');
        $this->db->where('YEAR(tanggal_jual)', date('Y'));
        $this->db->where('MONTH(tanggal_jual)', date('m'));
        $this->db->where('status_bayar', 'lunas');
        
        $result = $this->db->get()->row();
        return $result->total_bayar ?: 0;
    }

    public function get_jumlah_transaksi_today()
    {
        $this->db->from('penjualan');
        $this->db->where('DATE(tanggal_jual)', date('Y-m-d'));
        
        return $this->db->count_all_results();
    }

    public function get_produk_terlaris($limit = 10)
    {
        $this->db->select('pr.kode_produk, pr.nama_produk, SUM(dp.jumlah) as total_terjual');
        $this->db->from('detail_penjualan dp');
        $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
        $this->db->join('penjualan p', 'dp.penjualan_id = p.penjualan_id');
        $this->db->where('p.status_bayar', 'lunas');
        $this->db->group_by('dp.produk_id');
        $this->db->order_by('total_terjual', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    public function get_penjualan_chart_data($months = 12, $selected_month = null, $selected_year = null)
    {
        $this->db->select('DATE_FORMAT(tanggal_jual, "%Y-%m") as bulan, 
                          SUM(total_bayar) as total_penjualan,
                          COUNT(*) as jumlah_transaksi');
        $this->db->from('penjualan');
        $this->db->where('status_bayar', 'lunas');
        
        if ($selected_year) {
            $this->db->where('YEAR(tanggal_jual)', $selected_year);
        }
        if ($selected_month) {
            $this->db->where('MONTH(tanggal_jual)', $selected_month);
        }
        $this->db->group_by('DATE_FORMAT(tanggal_jual, "%Y-%m")');
        $this->db->order_by('bulan', 'ASC');
        
        return $this->db->get()->result();
    }

    public function cek_stok_tersedia($produk_id, $jumlah_diminta)
    {
        $this->db->select('jumlah_stok');
        $this->db->from('produk');
        $this->db->where('produk_id', $produk_id);
        
        $produk = $this->db->get()->row();
        
        if ($produk) {
            return $produk->jumlah_stok >= $jumlah_diminta;
        }
        
        return false;
    }

    public function get_riwayat_pembayaran($penjualan_id)
    {
        // Jika ada tabel riwayat pembayaran terpisah
        $this->db->select('*');
        $this->db->from('riwayat_pembayaran');
        $this->db->where('penjualan_id', $penjualan_id);
        $this->db->order_by('tanggal_bayar', 'DESC');
        
        return $this->db->get()->result();
    }

    public function simpan_riwayat_pembayaran($data_pembayaran)
    {
        // Untuk menyimpan riwayat pembayaran jika ada cicilan
        return $this->db->insert('riwayat_pembayaran', $data_pembayaran);
    }

    public function get_total_penjualan_mingguan() {
        $this->db->select_sum('total_bayar');
        $this->db->where('tanggal_jual >=', date('Y-m-d', strtotime('-7 days')));
        $this->db->where('tanggal_jual <=', date('Y-m-d'));
        $query = $this->db->get('penjualan');
        return $query->row()->total_bayar ?? 0;
    }

    public function get_total_penjualan_bulanan() {
        $this->db->select_sum('total_bayar');
        $this->db->where('tanggal_jual >=', date('Y-m-01'));
        $this->db->where('tanggal_jual <=', date('Y-m-t'));
        $query = $this->db->get('penjualan');
        return $query->row()->total_bayar ?? 0;
    }

    // Menghitung total produk terjual (semua produk, semua transaksi) pada bulan ini
    public function get_total_produk_terjual_bulan_ini()
    {
        $this->db->select_sum('dp.jumlah');
        $this->db->from('detail_penjualan dp');
        $this->db->join('penjualan p', 'dp.penjualan_id = p.penjualan_id');
        $this->db->where('YEAR(p.tanggal_jual)', date('Y'));
        $this->db->where('MONTH(p.tanggal_jual)', date('m'));
        $this->db->where('p.status_bayar', 'lunas');
        $result = $this->db->get()->row();
        return $result->jumlah ?: 0;
    }

    // Menghitung jumlah transaksi pada bulan ini
    public function get_jumlah_transaksi_bulan_ini()
    {
        $this->db->from('penjualan');
        $this->db->where('YEAR(tanggal_jual)', date('Y'));
        $this->db->where('MONTH(tanggal_jual)', date('m'));
        $this->db->where('status_bayar', 'lunas');
        return $this->db->count_all_results();
    }

    // Get purchase history for a specific customer
    public function get_purchase_history($customer_id, $date_start = null, $date_end = null, $status_bayar = null) {
        $this->db->select('penjualan.*, customers.nama_lengkap as nama_customer, users.nama_lengkap as nama_kasir');
        $this->db->from('penjualan');
        $this->db->join('customers', 'customers.customer_id = penjualan.customer_id');
        $this->db->join('users', 'users.user_id = penjualan.dilayani_oleh');
        $this->db->where('penjualan.customer_id', $customer_id);
        
        if ($date_start) {
            $this->db->where('DATE(penjualan.tanggal_jual) >=', $date_start);
        }
        if ($date_end) {
            $this->db->where('DATE(penjualan.tanggal_jual) <=', $date_end);
        }
        if ($status_bayar) {
            $this->db->where('penjualan.status_bayar', $status_bayar);
        }
        
        $this->db->order_by('penjualan.tanggal_jual', 'DESC');
        return $this->db->get()->result();
    }

    // Get purchase detail for a specific transaction
    public function get_purchase_detail($penjualan_id, $customer_id) {
        // Get penjualan data
        $this->db->select('penjualan.*, customers.nama_lengkap as nama_customer, customers.telepon, customers.alamat, users.nama_lengkap as nama_kasir');
        $this->db->from('penjualan');
        $this->db->join('customers', 'customers.customer_id = penjualan.customer_id');
        $this->db->join('users', 'users.user_id = penjualan.dilayani_oleh');
        $this->db->where('penjualan.penjualan_id', $penjualan_id);
        $this->db->where('penjualan.customer_id', $customer_id);
        $penjualan = $this->db->get()->row();

        if ($penjualan) {
            // Get detail items, alias harga_satuan as harga_jual
            $this->db->select('detail_penjualan.*, produk.nama_produk, detail_penjualan.harga_satuan as harga_jual');
            $this->db->from('detail_penjualan');
            $this->db->join('produk', 'produk.produk_id = detail_penjualan.produk_id');
            $this->db->where('detail_penjualan.penjualan_id', $penjualan_id);
            $penjualan->items = $this->db->get()->result();
        }

        return $penjualan;
    }

    // Get best-selling product per month for the last N months
    public function get_produk_terlaris_per_bulan($months = 12)
    {
        $sql = "
            SELECT
                DATE_FORMAT(p.tanggal_jual, '%Y-%m') AS bulan,
                dp.produk_id,
                pr.nama_produk,
                SUM(dp.jumlah) AS total_terjual
            FROM detail_penjualan dp
            JOIN penjualan p ON dp.penjualan_id = p.penjualan_id
            JOIN produk pr ON dp.produk_id = pr.produk_id
            WHERE p.status_bayar = 'lunas'
                AND p.tanggal_jual >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL ? MONTH), '%Y-%m-01')
            GROUP BY bulan, dp.produk_id
        ";
        $query = $this->db->query($sql, [$months]);
        $result = $query->result_array();
        // Ambil produk terlaris tiap bulan
        $terlaris_per_bulan = [];
        foreach ($result as $row) {
            $bulan = $row['bulan'];
            if (!isset($terlaris_per_bulan[$bulan]) || $row['total_terjual'] > $terlaris_per_bulan[$bulan]['total_terjual']) {
                $terlaris_per_bulan[$bulan] = $row;
            }
        }
        // Ubah ke array numerik
        return array_values($terlaris_per_bulan);
    }

    // Get best-selling products for a specific date range
    public function get_produk_terlaris_by_date_range($start_date, $end_date)
    {
        $sql = "
            SELECT
                DATE_FORMAT(p.tanggal_jual, '%Y-%m') AS bulan,
                dp.produk_id,
                pr.nama_produk,
                SUM(dp.jumlah) AS total_terjual
            FROM detail_penjualan dp
            JOIN penjualan p ON dp.penjualan_id = p.penjualan_id
            JOIN produk pr ON dp.produk_id = pr.produk_id
            WHERE p.status_bayar = 'lunas'
                AND DATE(p.tanggal_jual) >= ?
                AND DATE(p.tanggal_jual) <= ?
            GROUP BY bulan, dp.produk_id
            ORDER BY bulan ASC, total_terjual DESC
        ";
        $query = $this->db->query($sql, [$start_date, $end_date]);
        $result = $query->result_array();
        
        // Ambil produk terlaris tiap bulan dalam range
        $terlaris_per_bulan = [];
        foreach ($result as $row) {
            $bulan = $row['bulan'];
            if (!isset($terlaris_per_bulan[$bulan]) || $row['total_terjual'] > $terlaris_per_bulan[$bulan]['total_terjual']) {
                $terlaris_per_bulan[$bulan] = $row;
            }
        }
        // Ubah ke array numerik
        return array_values($terlaris_per_bulan);
    }

    // Analisis Fast/Slow Moving Produk
    public function get_fast_slow_moving($start_date, $end_date)
    {
        $this->db->select('pr.produk_id, pr.kode_produk, pr.nama_produk, k.nama_kategori, SUM(dp.jumlah) as total_terjual, SUM(dp.subtotal) as total_pendapatan');
        $this->db->from('detail_penjualan dp');
        $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
        $this->db->join('kategori k', 'pr.kategori_id = k.kategori_id');
        $this->db->join('penjualan p', 'dp.penjualan_id = p.penjualan_id');
        $this->db->where('p.status_bayar', 'lunas');
        $this->db->where('p.tanggal_jual >=', $start_date);
        $this->db->where('p.tanggal_jual <=', $end_date);
        $this->db->group_by('pr.produk_id');
        $this->db->order_by('total_terjual', 'DESC');
        $result = $this->db->get()->result_array();

        // Hitung rata-rata penjualan
        $total = 0;
        foreach ($result as $row) $total += $row['total_terjual'];
        $avg = count($result) ? $total / count($result) : 0;

        // Tandai fast/slow moving
        foreach ($result as &$row) {
            $row['kategori'] = ($row['total_terjual'] >= $avg) ? 'Fast Moving' : 'Slow Moving';
        }
        return $result;
    }

    public function get_customer_product_analytics($limit_per_customer = 3) {
        $sql = "
            SELECT
                c.customer_id,
                c.nama_lengkap,
                c.foto,
                pr.produk_id,
                pr.nama_produk,
                COUNT(*) AS jumlah_dibeli
            FROM
                customers c
            JOIN
                penjualan pj ON c.customer_id = pj.customer_id
            JOIN
                detail_penjualan dp ON pj.penjualan_id = dp.penjualan_id
            JOIN
                produk pr ON dp.produk_id = pr.produk_id
            GROUP BY
                c.customer_id, pr.produk_id
            ORDER BY
                c.customer_id, jumlah_dibeli DESC
        ";
        $result = $this->db->query($sql)->result_array();

        // Group by customer and take top N
        $analytics = [];
        foreach ($result as $row) {
            $cid = $row['customer_id'];
            if (!isset($analytics[$cid])) $analytics[$cid] = [
                'nama_lengkap' => $row['nama_lengkap'],
                'foto' => $row['foto'],
                'produk' => []
            ];
            if (count($analytics[$cid]['produk']) < $limit_per_customer) {
                $analytics[$cid]['produk'][] = [
                    'nama_produk' => $row['nama_produk'],
                    'jumlah_dibeli' => $row['jumlah_dibeli']
                ];
            }
        }
        return $analytics;
    }

    public function get_rekomendasi_produk($customer_id, $limit_populer = 2, $limit_baru = 1) {
        // Produk yang sudah pernah dibeli customer
        $beli = $this->db->select('produk_id')->from('penjualan pj')
            ->join('detail_penjualan dp', 'pj.penjualan_id=dp.penjualan_id')
            ->where('pj.customer_id', $customer_id)
            ->group_by('produk_id')->get()->result_array();
        $beli_ids = array_column($beli, 'produk_id');

        // Produk populer di toko, exclude yang sudah dibeli customer
        $this->db->select('pr.produk_id, pr.nama_produk, COUNT(dp.detail_id) as total_terjual')
            ->from('detail_penjualan dp')
            ->join('produk pr', 'dp.produk_id=pr.produk_id')
            ->group_by('pr.produk_id')
            ->order_by('total_terjual', 'DESC');
        if (!empty($beli_ids)) $this->db->where_not_in('pr.produk_id', $beli_ids);
        $populer = $this->db->limit($limit_populer)->get()->result_array();

        // Produk baru (berdasarkan created_at), exclude yang sudah dibeli customer
        $this->db->select('produk_id, nama_produk')
            ->from('produk')
            ->order_by('created_at', 'DESC');
        if (!empty($beli_ids)) $this->db->where_not_in('produk_id', $beli_ids);
        $baru = $this->db->limit($limit_baru)->get()->result_array();

        return [
            'populer' => $populer,
            'baru' => $baru
        ];
    }

    public function get_rekomendasi_umum($limit_populer = 2, $limit_baru = 1) {
        // Produk populer umum
        $populer = $this->db->select('pr.produk_id, pr.nama_produk, COUNT(dp.detail_id) as total_terjual')
            ->from('detail_penjualan dp')
            ->join('produk pr', 'dp.produk_id=pr.produk_id')
            ->group_by('pr.produk_id')
            ->order_by('total_terjual', 'DESC')
            ->limit($limit_populer)
            ->get()->result_array();

        // Produk baru umum
        $baru = $this->db->select('produk_id, nama_produk')
            ->from('produk')
            ->order_by('created_at', 'DESC')
            ->limit($limit_baru)
            ->get()->result_array();

        return [
            'populer' => $populer,
            'baru' => $baru
        ];
    }

    // Analitik produk favorit untuk transaksi non-member
    public function get_non_member_product_analytics($limit = 3) {
        $sql = "
            SELECT
                pr.produk_id,
                pr.nama_produk,
                COUNT(*) AS jumlah_dibeli
            FROM
                penjualan pj
            JOIN
                detail_penjualan dp ON pj.penjualan_id = dp.penjualan_id
            JOIN
                produk pr ON dp.produk_id = pr.produk_id
            WHERE
                pj.customer_id IS NULL
            GROUP BY
                pr.produk_id
            ORDER BY
                jumlah_dibeli DESC
            LIMIT ?
        ";
        $result = $this->db->query($sql, [$limit])->result_array();
        return $result;
    }
}