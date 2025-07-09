<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model');
        $this->load->model('Customer_model');
        $this->load->model('Produk_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
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

    public function penjualan()
    {
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $customer_id = $this->input->get('customer');
        $status_bayar = $this->input->get('status_bayar');

        $data['penjualan'] = $this->Penjualan_model->get_penjualan_filtered($date_start, $date_end, $customer_id, $status_bayar);
        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['users'] = $this->User_model->get_all_users();
        $data['produk'] = $this->Produk_model->get_all_produk();
        $data['title'] = 'Daftar Penjualan';
        // Card summary data
        $data['total_produk_terjual_bulan_ini'] = $this->Penjualan_model->get_total_produk_terjual_bulan_ini();
        $data['jumlah_transaksi_bulan_ini'] = $this->Penjualan_model->get_jumlah_transaksi_bulan_ini();
        $data['total_penjualan_bulan_ini'] = $this->Penjualan_model->get_total_penjualan_bulan_ini();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('penjualan', $data);
        $this->load->view('template/footer');
    }

    public function pos()
    {
        $data['title'] = 'Point of Sale';
        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['produk'] = $this->Produk_model->get_available_produk();
        
        if ($this->input->post()) {
            $this->_process_penjualan();
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('penjualan/pos', $data);
            $this->load->view('template/footer');
        }
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Penjualan';
        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['produk'] = $this->Produk_model->get_available_produk();
        
        if ($this->input->post()) {
            $this->_process_penjualan();
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('penjualan/form', $data);
            $this->load->view('template/footer');
        }
    }

    public function detail($id)
    {
        $data['penjualan'] = $this->Penjualan_model->get_penjualan_by_id($id);
        $data['detail_penjualan'] = $this->Penjualan_model->get_detail_penjualan($id);
        $data['title'] = 'Detail Penjualan';
        if (!$data['penjualan']) {
            show_404();
        }
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('penjualan/detail', $data);
        $this->load->view('template/footer');
    }

    public function invoice($id)
    {
        $data['title'] = 'Invoice';
        $data['penjualan'] = $this->Penjualan_model->get_penjualan_by_id($id);
        $data['detail_penjualan'] = $this->Penjualan_model->get_detail_penjualan($id);
        
        if (!$data['penjualan']) {
            show_404();
        }

        $this->load->view('index.php/penjualan/penjualan/invoice', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Penjualan';
        $data['penjualan'] = $this->Penjualan_model->get_penjualan_by_id($id);
        $data['customers'] = $this->Customer_model->get_all_customers();
        $data['produk'] = $this->Produk_model->get_available_produk();
        $data['detail_penjualan'] = $this->Penjualan_model->get_detail_penjualan($id);
        
        if (!$data['penjualan']) {
            show_404();
        }

        // Only allow edit if not paid yet
        if ($data['penjualan']->status_bayar == 'lunas') {
            $this->session->set_flashdata('error', 'Penjualan yang sudah lunas tidak dapat diedit');
            redirect('index.php/penjualan/penjualan');
        }

        if ($this->input->post()) {
            $this->_process_penjualan($id);
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('penjualan/form', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id)
    {
        // Hanya izinkan request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_404();
        }
        log_message('debug', 'Hapus penjualan id: ' . $id);
        $penjualan = $this->Penjualan_model->get_penjualan_by_id($id);
        if (!$penjualan) {
            show_404();
        }
        if ($penjualan->status_bayar == 'lunas') {
            $this->session->set_flashdata('error', 'Penjualan yang sudah lunas tidak dapat dihapus');
            redirect('index.php/penjualan/penjualan');
        }
        if ($this->Penjualan_model->delete_penjualan($id)) {
            $this->session->set_flashdata('success', 'Penjualan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus penjualan');
        }
        redirect('index.php/penjualan/penjualan');
    }

    public function bayar($id)
    {
        // Hanya izinkan request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            show_404();
        }

        $penjualan = $this->Penjualan_model->get_penjualan_by_id($id);
        
        if (!$penjualan) {
            show_404();
        }

        // Hanya bisa bayar jika status masih belum lunas
        if ($penjualan->status_bayar == 'lunas') {
            $this->session->set_flashdata('error', 'Penjualan ini sudah lunas');
            redirect('index.php/penjualan/penjualan');
        }

        // Update status pembayaran
        $data_bayar = array(
            'status_bayar' => 'lunas',
            'metode_bayar' => $this->input->post('metode_bayar')
        );

        if ($this->Penjualan_model->update_penjualan($id, $data_bayar)) {
            // Update total pembelian customer jika ada
            if ($penjualan->customer_id) {
                $this->Customer_model->update_total_pembelian($penjualan->customer_id, $penjualan->total_bayar);
                // Tambah 1 poin loyalty untuk member
                if ($this->input->post('is_member') == '1') {
                    $this->db->set('poin_loyalty', 'poin_loyalty+1', FALSE);
                    $this->db->where('customer_id', $penjualan->customer_id);
                    $this->db->update('customers');
                }
            }
            
            $this->session->set_flashdata('success', 'Status pembayaran berhasil diupdate');
            redirect('index.php/penjualan/penjualan');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate status pembayaran');
            redirect('index.php/penjualan/penjualan');
        }
    }

    private function _process_penjualan($id = null)
    {
        $this->form_validation->set_rules('produk_id[]', 'Produk', 'required');
        $this->form_validation->set_rules('jumlah[]', 'Jumlah', 'required');
        $this->form_validation->set_rules('metode_bayar', 'Metode Pembayaran', 'required');
        $this->form_validation->set_rules('tanggal_jual', 'Tanggal Jual', 'required');

        $is_member = $this->input->post('is_member');
        $customer_id = $this->input->post('customer_id');
        if ($is_member == '1' && empty($customer_id)) {
            $this->session->set_flashdata('error', 'Pilih member untuk transaksi member!');
            redirect('index.php/penjualan/penjualan');
        }

        if ($this->form_validation->run() === FALSE) {
            return;
        }

        // Validate stock availability
        $produk_ids = $this->input->post('produk_id');
        $jumlahs = $this->input->post('jumlah');
        for ($i = 0; $i < count($produk_ids); $i++) {
            $produk = $this->Produk_model->get_produk_by_id($produk_ids[$i]);
            if ($produk['jumlah_stok'] < $jumlahs[$i]) {
                $this->session->set_flashdata('error', 'Stok ' . $produk['nama_produk'] . ' tidak mencukupi');
                return;
            }
        }

        $poin_dipakai = (int) $this->input->post('poin_dipakai');
        // Hapus tax dan diskon otomatis, hanya diskon dari loyalty
        $data_penjualan = array(
            'customer_id' => ($is_member == '1' && $customer_id) ? $customer_id : null,
            'metode_bayar' => $this->input->post('metode_bayar'),
            'status_bayar' => $this->input->post('status_bayar', true) ?: 'lunas',
            'diskon' => ($is_member == '1' && $customer_id && $poin_dipakai == 5) ? 50000 : 0,
            'pajak' => 0,
            'catatan' => $this->input->post('catatan'),
            'dilayani_oleh' => $this->session->userdata('user_id'),
            'tanggal_jual' => $this->input->post('tanggal_jual') ?: date('Y-m-d H:i:s'),
            'bayar' => $this->input->post('bayar'),
            'kembali' => $this->input->post('kembalian'),
        );

        if ($id) {
            $this->Penjualan_model->restore_stock_penjualan($id);
            // Ambil nomor invoice lama dari database agar tidak hilang
            $old_penjualan = $this->Penjualan_model->get_penjualan_by_id($id);
            $data_penjualan['nomor_invoice'] = $old_penjualan->nomor_invoice;
            $result = $this->Penjualan_model->update_penjualan($id, $data_penjualan);
        } else {
            $data_penjualan['nomor_invoice'] = $this->_generate_invoice_number();
            $result = $this->Penjualan_model->create_penjualan($data_penjualan);
            $id = $result;
        }

        if ($result) {
            $detail_data = array();
            $subtotal = 0;
            for ($i = 0; $i < count($produk_ids); $i++) {
                $produk = $this->Produk_model->get_produk_by_id($produk_ids[$i]);
                $item_subtotal = $jumlahs[$i] * $produk['harga_jual'];
                $detail_data[] = array(
                    'penjualan_id' => $id,
                    'produk_id' => $produk_ids[$i],
                    'jumlah' => $jumlahs[$i],
                    'harga_satuan' => $produk['harga_jual']
                );
                $subtotal += $item_subtotal;
            }
            $diskon = $this->input->post('diskon') ?: 0;
            $pajak = $this->input->post('pajak') ?: 0;
            $total_bayar = $subtotal - $diskon + $pajak;
            $this->Penjualan_model->save_detail_penjualan($id, $detail_data);
            $this->Penjualan_model->update_total_penjualan($id, $subtotal, $diskon, $pajak, $total_bayar);
            $this->Penjualan_model->update_stock_penjualan($id);
            if ($data_penjualan['status_bayar'] == 'lunas' && $data_penjualan['customer_id']) {
                $this->Customer_model->update_total_pembelian($data_penjualan['customer_id'], $total_bayar);
                // Tambah 1 poin loyalty untuk member
                if ($this->input->post('is_member') == '1') {
                    $this->db->set('poin_loyalty', 'poin_loyalty+1', FALSE);
                    $this->db->where('customer_id', $data_penjualan['customer_id']);
                    $this->db->update('customers');
                }
                // Kurangi 5 poin jika redeem
                if ($is_member == '1' && $poin_dipakai == 5) {
                    $this->db->set('poin_loyalty', 'poin_loyalty-5', FALSE);
                    $this->db->where('customer_id', $data_penjualan['customer_id']);
                    $this->db->update('customers');
                }
            }
            $this->session->set_flashdata('success', 'Penjualan berhasil disimpan');
            redirect('index.php/penjualan/penjualan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan penjualan');
            redirect('index.php/penjualan/penjualan');
        }
    }

    private function _generate_invoice_number()
    {
        $date = date('Ymd');
        $last_invoice = $this->Penjualan_model->get_last_invoice_number($date);
        
        if ($last_invoice) {
            $last_number = intval(substr($last_invoice->nomor_invoice, -4));
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        return 'INV' . $date . sprintf('%04d', $new_number);
    }

    public function get_produk_info()
    {
        $produk_id = $this->input->post('produk_id');
        $produk = $this->Produk_model->get_produk_by_id($produk_id);
        
        if ($produk) {
            echo json_encode(array(
                'status' => 'success',
                'data' => array(
                    'harga_jual' => $produk['harga_jual'],
                    'stok_tersedia' => $produk['jumlah_stok'],
                    'nama_produk' => $produk['nama_produk']
                )
            ));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    public function cari_produk()
    {
        $keyword = $this->input->get('q');
        $produk = $this->Produk_model->search_produk($keyword);
        
        $result = array();
        foreach ($produk as $p) {
            $result[] = array(
                'id' => $p->produk_id,
                'text' => $p->kode_produk . ' - ' . $p->nama_produk . ' (Stok: ' . $p->jumlah_stok . ')',
                'harga' => $p->harga_jual,
                'stok' => $p->jumlah_stok
            );
        }
        
        echo json_encode($result);
    }

    public function get_sale($id)
    {
        $penjualan = $this->Penjualan_model->get_penjualan_by_id($id);
        $detail = $this->Penjualan_model->get_detail_penjualan($id);
        if ($penjualan) {
            $items = [];
            foreach ($detail as $d) {
                $items[] = [
                    'produk_id' => $d->produk_id,
                    'jumlah' => $d->jumlah,
                    'harga_satuan' => $d->harga_satuan
                ];
            }
            echo json_encode([
                'success' => true,
                'sale' => [
                    'customer_id' => $penjualan->customer_id,
                    'tanggal_jual' => $penjualan->tanggal_jual,
                    'metode_bayar' => $penjualan->metode_bayar,
                    'status_bayar' => $penjualan->status_bayar,
                    'catatan' => $penjualan->catatan,
                    'items' => $items
                ]
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function export()
    {
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $customer_id = $this->input->get('customer');
        $status_bayar = $this->input->get('status_bayar');
        $kasir_id = $this->input->get('kasir');
        $penjualan = $this->Penjualan_model->get_penjualan_filtered($date_start, $date_end, $customer_id, $status_bayar, $kasir_id);

        require_once FCPATH.'vendor/autoload.php';
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Invoice No');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'Date');
        $sheet->setCellValue('D1', 'Total');
        $sheet->setCellValue('E1', 'Payment Status');
        $sheet->setCellValue('F1', 'Cashier');
        $row = 2;
        foreach ($penjualan as $sale) {
            $sheet->setCellValue('A'.$row, $sale->nomor_invoice);
            $sheet->setCellValue('B'.$row, $sale->nama_customer);
            $sheet->setCellValue('C'.$row, $sale->tanggal_jual);
            $sheet->setCellValue('D'.$row, $sale->total_bayar);
            $sheet->setCellValue('E'.$row, $sale->status_bayar);
            $sheet->setCellValue('F'.$row, $sale->kasir_nama);
            $row++;
        }
        $filename = 'Sales_Report_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function print()
    {
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $customer_id = $this->input->get('customer');
        $status_bayar = $this->input->get('status_bayar');
        $kasir_id = $this->input->get('kasir');
        $data['penjualan'] = $this->Penjualan_model->get_penjualan_filtered($date_start, $date_end, $customer_id, $status_bayar, $kasir_id);
        $data['title'] = 'Print Sales Report';
        $this->load->view('penjualan_print', $data);
    }
}