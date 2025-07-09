<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Penjualan_model');
        $this->load->database();
        $this->load->library('session');
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

    public function laporan()
    {
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        // Filter member aktif
        if ($tanggal_awal && $tanggal_akhir) {
            $jumlah_member_aktif = $this->db->where('status', 'aktif')
                ->where('tanggal_daftar >=', $tanggal_awal)
                ->where('tanggal_daftar <=', $tanggal_akhir)
                ->count_all_results('customers');
            $member_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_daftar, "%Y-%m") as bulan, COUNT(*) as jumlah
                FROM customers
                WHERE status = "aktif" AND tanggal_daftar >= "' . $tanggal_awal . '" AND tanggal_daftar <= "' . $tanggal_akhir . '"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
        } else {
            $jumlah_member_aktif = $this->db->where('status', 'aktif')->count_all_results('customers');
            $member_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_daftar, "%Y-%m") as bulan, COUNT(*) as jumlah
                FROM customers
                WHERE status = "aktif"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
        }
        // Keluhan baru (tidak ada tanggal di complaints_suggestions, jadi tidak bisa filter periode kecuali pakai created_at)
        if ($tanggal_awal && $tanggal_akhir) {
            $jumlah_keluhan_baru = $this->db->where('created_at >=', $tanggal_awal.' 00:00:00')
                ->where('created_at <=', $tanggal_akhir.' 23:59:59')
                ->count_all_results('complaints_suggestions');
        } else {
            $jumlah_keluhan_baru = $this->db->count_all('complaints_suggestions');
        }
        // Pelanggan terbaik (berdasarkan total pembelian, filter tanggal_jual jika filter diisi)
        if ($tanggal_awal && $tanggal_akhir) {
            $pelanggan_terbaik = $this->db->query('
                SELECT c.nama_lengkap, SUM(p.total_bayar) as total_pembelian
                FROM customers c
                JOIN penjualan p ON c.customer_id = p.customer_id
                WHERE c.status = "aktif" AND p.tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND p.tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY c.customer_id
                ORDER BY total_pembelian DESC
                LIMIT 1
            ')->row();
        } else {
            $pelanggan_terbaik = $this->db->select('nama_lengkap, total_pembelian')
                ->where('status', 'aktif')
                ->order_by('total_pembelian', 'DESC')
                ->limit(1)
                ->get('customers')->row();
        }
        // Rekap transaksi member & non member (filter tanggal_jual jika filter diisi)
        if ($tanggal_awal && $tanggal_akhir) {
            $rekap = $this->db->query('
                SELECT 
                    CASE WHEN customer_id IS NULL THEN "Non Member" ELSE "Member" END as tipe_pelanggan,
                    COUNT(*) as jumlah_transaksi,
                    SUM(total_bayar) as keuntungan
                FROM penjualan
                WHERE tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY tipe_pelanggan
            ')->result_array();
        } else {
            $rekap = $this->db->query('
                SELECT 
                    CASE WHEN customer_id IS NULL THEN "Non Member" ELSE "Member" END as tipe_pelanggan,
                    COUNT(*) as jumlah_transaksi,
                    SUM(total_bayar) as keuntungan
                FROM penjualan
                GROUP BY tipe_pelanggan
            ')->result_array();
        }
        // Data pendapatan per bulan (total penjualan per bulan)
        if ($tanggal_awal && $tanggal_akhir) {
            $pendapatan_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_jual, "%Y-%m") as bulan, SUM(total_bayar) as total
                FROM penjualan
                WHERE tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
        } else {
            $pendapatan_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_jual, "%Y-%m") as bulan, SUM(total_bayar) as total
                FROM penjualan
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
        }
        // Data customer segments (jumlah transaksi member vs non member)
        if ($tanggal_awal && $tanggal_akhir) {
            $segmen = $this->db->query('
                SELECT 
                    SUM(CASE WHEN customer_id IS NULL THEN 1 ELSE 0 END) as non_member,
                    SUM(CASE WHEN customer_id IS NOT NULL THEN 1 ELSE 0 END) as member
                FROM penjualan
                WHERE tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
            ')->row_array();
        } else {
            $segmen = $this->db->query('
                SELECT 
                    SUM(CASE WHEN customer_id IS NULL THEN 1 ELSE 0 END) as non_member,
                    SUM(CASE WHEN customer_id IS NOT NULL THEN 1 ELSE 0 END) as member
                FROM penjualan
            ')->row_array();
        }
        // Top member (berdasarkan jumlah transaksi)
        if ($tanggal_awal && $tanggal_akhir) {
            $top_member = $this->db->query('
                SELECT c.nama_lengkap, c.telepon, COUNT(p.penjualan_id) as jumlah_transaksi, SUM(p.total_bayar) as total_pembelian
                FROM customers c
                LEFT JOIN penjualan p ON c.customer_id = p.customer_id
                WHERE c.status = "aktif" AND p.tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND p.tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY c.customer_id
                ORDER BY jumlah_transaksi DESC, total_pembelian DESC
                LIMIT 10
            ')->result_array();
        } else {
            $top_member = $this->db->query('
                SELECT c.nama_lengkap, c.telepon, COUNT(p.penjualan_id) as jumlah_transaksi, SUM(p.total_bayar) as total_pembelian
                FROM customers c
                LEFT JOIN penjualan p ON c.customer_id = p.customer_id
                WHERE c.status = "aktif"
                GROUP BY c.customer_id
                ORDER BY jumlah_transaksi DESC, total_pembelian DESC
                LIMIT 10
            ')->result_array();
        }
        // List penjualan
        if ($tanggal_awal && $tanggal_akhir) {
            $sales_list = $this->db->query('
                SELECT p.*, c.nama_lengkap as nama_customer, u.nama_lengkap as kasir_nama
                FROM penjualan p
                LEFT JOIN customers c ON p.customer_id = c.customer_id
                LEFT JOIN users u ON p.dilayani_oleh = u.user_id
                WHERE p.tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND p.tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                ORDER BY p.tanggal_jual DESC
            ')->result_array();
        } else {
            $sales_list = $this->db->query('
                SELECT p.*, c.nama_lengkap as nama_customer, u.nama_lengkap as kasir_nama
                FROM penjualan p
                LEFT JOIN customers c ON p.customer_id = c.customer_id
                LEFT JOIN users u ON p.dilayani_oleh = u.user_id
                ORDER BY p.tanggal_jual DESC
            ')->result_array();
        }
        $data = [
            'jumlah_member_aktif' => $jumlah_member_aktif,
            'jumlah_keluhan_baru' => $jumlah_keluhan_baru,
            'pelanggan_terbaik' => $pelanggan_terbaik,
            'member_per_bulan' => $member_per_bulan,
            'rekap' => $rekap,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'pendapatan_per_bulan' => $pendapatan_per_bulan,
            'segmen' => $segmen,
            'top_member' => $top_member,
            'sales_list' => $sales_list
        ];
        $this->load->view('template/header');

        $this->load->view('laporan_crm', $data);
    }

    public function export_laporan_crm_csv()
    {
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        // Data summary
        if ($tanggal_awal && $tanggal_akhir) {
            $jumlah_member_aktif = $this->db->where('status', 'aktif')
                ->where('tanggal_daftar >=', $tanggal_awal)
                ->where('tanggal_daftar <=', $tanggal_akhir)
                ->count_all_results('customers');
            $member_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_daftar, "%Y-%m") as bulan, COUNT(*) as jumlah
                FROM customers
                WHERE status = "aktif" AND tanggal_daftar >= "' . $tanggal_awal . '" AND tanggal_daftar <= "' . $tanggal_akhir . '"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
            $jumlah_keluhan_baru = $this->db->where('created_at >=', $tanggal_awal.' 00:00:00')
                ->where('created_at <=', $tanggal_akhir.' 23:59:59')
                ->count_all_results('complaints_suggestions');
            $pelanggan_terbaik = $this->db->select('nama_lengkap, total_pembelian')
                ->where('status', 'aktif')
                ->where('tanggal_daftar >=', $tanggal_awal)
                ->where('tanggal_daftar <=', $tanggal_akhir)
                ->order_by('total_pembelian', 'DESC')
                ->limit(1)
                ->get('customers')->row();
            $rekap = $this->db->query('
                SELECT 
                    CASE WHEN customer_id IS NULL THEN "Non Member" ELSE "Member" END as tipe_pelanggan,
                    COUNT(*) as jumlah_transaksi,
                    SUM(total_bayar) as keuntungan
                FROM penjualan
                WHERE tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY tipe_pelanggan
            ')->result_array();
        } else {
            $jumlah_member_aktif = $this->db->where('status', 'aktif')->count_all_results('customers');
            $member_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_daftar, "%Y-%m") as bulan, COUNT(*) as jumlah
                FROM customers
                WHERE status = "aktif"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
            $jumlah_keluhan_baru = $this->db->count_all('complaints_suggestions');
            $pelanggan_terbaik = $this->db->select('nama_lengkap, total_pembelian')
                ->where('status', 'aktif')
                ->order_by('total_pembelian', 'DESC')
                ->limit(1)
                ->get('customers')->row();
            $rekap = $this->db->query('
                SELECT 
                    CASE WHEN customer_id IS NULL THEN "Non Member" ELSE "Member" END as tipe_pelanggan,
                    COUNT(*) as jumlah_transaksi,
                    SUM(total_bayar) as keuntungan
                FROM penjualan
                GROUP BY tipe_pelanggan
            ')->result_array();
        }
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="laporan_crm.csv"');
        $output = fopen('php://output', 'w');
        // Judul
        if ($tanggal_awal && $tanggal_akhir) {
            fputcsv($output, ['LAPORAN CRM - PERIODE: ' . date('d M Y', strtotime($tanggal_awal)) . ' - ' . date('d M Y', strtotime($tanggal_akhir))]);
        } else {
            fputcsv($output, ['LAPORAN CRM - SEMUA PERIODE']);
        }
        // Summary
        fputcsv($output, []);
        fputcsv($output, ['SUMMARY']);
        fputcsv($output, ['Member Aktif', $jumlah_member_aktif]);
        fputcsv($output, ['Keluhan Baru', $jumlah_keluhan_baru]);
        fputcsv($output, ['Pelanggan Terbaik', $pelanggan_terbaik ? $pelanggan_terbaik->nama_lengkap : '-']);
        fputcsv($output, ['Total Pembelian Pelanggan Terbaik', $pelanggan_terbaik ? $pelanggan_terbaik->total_pembelian : 0]);
        // Grafik member per bulan
        fputcsv($output, []);
        fputcsv($output, ['GRAFIK MEMBER PER BULAN']);
        fputcsv($output, ['Bulan', 'Jumlah Member']);
        foreach ($member_per_bulan as $row) {
            fputcsv($output, [$row['bulan'], $row['jumlah']]);
        }
        // Rekap transaksi
        fputcsv($output, []);
        fputcsv($output, ['REKAP TRANSAKSI MEMBER & NON MEMBER']);
        fputcsv($output, ['Tipe Pelanggan', 'Jumlah Transaksi', 'Keuntungan']);
        foreach ($rekap as $row) {
            fputcsv($output, [
                $row['tipe_pelanggan'], $row['jumlah_transaksi'], $row['keuntungan']
            ]);
        }
        fclose($output);
        exit;
    }

    public function print_laporan_crm()
    {
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        // Filter member aktif
        if ($tanggal_awal && $tanggal_akhir) {
            $jumlah_member_aktif = $this->db->where('status', 'aktif')
                ->where('tanggal_daftar >=', $tanggal_awal)
                ->where('tanggal_daftar <=', $tanggal_akhir)
                ->count_all_results('customers');
            $jumlah_keluhan_baru = $this->db->where('created_at >=', $tanggal_awal.' 00:00:00')
                ->where('created_at <=', $tanggal_akhir.' 23:59:59')
                ->count_all_results('complaints_suggestions');
            // Member terbaik berdasarkan total pembelian di periode
            $pelanggan_terbaik = $this->db->query('
                SELECT c.nama_lengkap, SUM(p.total_bayar) as total_pembelian
                FROM customers c
                JOIN penjualan p ON c.customer_id = p.customer_id
                WHERE c.status = "aktif" AND p.tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND p.tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY c.customer_id
                ORDER BY total_pembelian DESC
                LIMIT 1
            ')->row();
            $member_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_daftar, "%Y-%m") as bulan, COUNT(*) as jumlah
                FROM customers
                WHERE status = "aktif" AND tanggal_daftar >= "' . $tanggal_awal . ' 00:00:00" AND tanggal_daftar <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
            $pendapatan_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_jual, "%Y-%m") as bulan, SUM(total_bayar) as total
                FROM penjualan
                WHERE tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
            $segmen = [
                'member' => $this->db->where('customer_id IS NOT NULL')->where('tanggal_jual >=', $tanggal_awal . ' 00:00:00')->where('tanggal_jual <=', $tanggal_akhir . ' 23:59:59')->count_all_results('penjualan'),
                'non_member' => $this->db->where('customer_id IS NULL')->where('tanggal_jual >=', $tanggal_awal . ' 00:00:00')->where('tanggal_jual <=', $tanggal_akhir . ' 23:59:59')->count_all_results('penjualan'),
            ];
            $top_member = $this->db->query('
                SELECT c.nama_lengkap, c.telepon, COUNT(p.penjualan_id) as jumlah_transaksi, SUM(p.total_bayar) as total_pembelian
                FROM customers c
                LEFT JOIN penjualan p ON c.customer_id = p.customer_id
                WHERE c.status = "aktif" AND p.tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND p.tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                GROUP BY c.customer_id
                ORDER BY jumlah_transaksi DESC, total_pembelian DESC
                LIMIT 10
            ')->result_array();
            $sales_list = $this->db->query('
                SELECT p.*, c.nama_lengkap as nama_customer, u.nama_lengkap as kasir_nama
                FROM penjualan p
                LEFT JOIN customers c ON p.customer_id = c.customer_id
                LEFT JOIN users u ON p.dilayani_oleh = u.user_id
                WHERE p.tanggal_jual >= "' . $tanggal_awal . ' 00:00:00" AND p.tanggal_jual <= "' . $tanggal_akhir . ' 23:59:59"
                ORDER BY p.tanggal_jual DESC
            ')->result_array();
        } else {
            $jumlah_member_aktif = $this->db->where('status', 'aktif')->count_all_results('customers');
            $jumlah_keluhan_baru = $this->db->count_all('complaints_suggestions');
            $pelanggan_terbaik = $this->db->select('nama_lengkap, total_pembelian')
                ->where('status', 'aktif')
                ->order_by('total_pembelian', 'DESC')
                ->limit(1)
                ->get('customers')->row();
            $member_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_daftar, "%Y-%m") as bulan, COUNT(*) as jumlah
                FROM customers
                WHERE status = "aktif"
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
            $pendapatan_per_bulan = $this->db->query('
                SELECT DATE_FORMAT(tanggal_jual, "%Y-%m") as bulan, SUM(total_bayar) as total
                FROM penjualan
                GROUP BY bulan
                ORDER BY bulan ASC
            ')->result_array();
            $segmen = [
                'member' => $this->db->where('customer_id IS NOT NULL')->count_all_results('penjualan'),
                'non_member' => $this->db->where('customer_id IS NULL')->count_all_results('penjualan'),
            ];
            $top_member = $this->db->query('
                SELECT c.nama_lengkap, c.telepon, COUNT(p.penjualan_id) as jumlah_transaksi, SUM(p.total_bayar) as total_pembelian
                FROM customers c
                LEFT JOIN penjualan p ON c.customer_id = p.customer_id
                WHERE c.status = "aktif"
                GROUP BY c.customer_id
                ORDER BY jumlah_transaksi DESC, total_pembelian DESC
                LIMIT 10
            ')->result_array();
            $sales_list = $this->db->query('
                SELECT p.*, c.nama_lengkap as nama_customer, u.nama_lengkap as kasir_nama
                FROM penjualan p
                LEFT JOIN customers c ON p.customer_id = c.customer_id
                LEFT JOIN users u ON p.dilayani_oleh = u.user_id
                ORDER BY p.tanggal_jual DESC
            ')->result_array();
        }
        // Hitung total pendapatan
        $total_pendapatan = 0;
        if (!empty($pendapatan_per_bulan)) {
            foreach ($pendapatan_per_bulan as $row) {
                if (isset($row['total']) && is_numeric($row['total'])) {
                    $total_pendapatan += $row['total'];
                }
            }
        }
        $data = [
            'jumlah_member_aktif' => $jumlah_member_aktif,
            'jumlah_keluhan_baru' => $jumlah_keluhan_baru,
            'pelanggan_terbaik' => $pelanggan_terbaik,
            'pendapatan_per_bulan' => $pendapatan_per_bulan,
            'segmen' => $segmen,
            'top_member' => $top_member,
            'sales_list' => $sales_list,
            'total_pendapatan' => $total_pendapatan,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ];
        $this->load->view('laporan_crm_print', $data);
    }
} 