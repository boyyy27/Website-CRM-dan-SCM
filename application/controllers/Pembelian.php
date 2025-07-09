<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pembelian_model');
        $this->load->model('Supplier_model');
        $this->load->model('Produk_model');
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

    public function pembelian()
    {
        $data['title'] = 'Daftar Pembelian';
        
        // Get filter parameters
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $supplier_id = $this->input->get('supplier');
        $status = $this->input->get('status');
        
        // Apply filters
        if ($date_start && $date_end) {
            $data['pembelian'] = $this->Pembelian_model->get_pembelian_by_date_range($date_start, $date_end);
        } elseif ($supplier_id) {
            $data['pembelian'] = $this->Pembelian_model->get_pembelian_by_supplier($supplier_id);
        } elseif ($status) {
            $data['pembelian'] = $this->Pembelian_model->get_pembelian_by_status($status);
        } else {
        $data['pembelian'] = $this->Pembelian_model->get_all_pembelian();
        }
        
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        $data['produk'] = $this->Produk_model->get_all_produk();
        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('pembelian', $data);
        $this->load->view('template/footer');
        
    }

    public function create()
    {
        // Set response header untuk JSON
        header('Content-Type: application/json');
        log_message('debug', 'Pembelian create() dipanggil. POST: ' . print_r($_POST, true));
        
        try {
            // Debug: Log received data
            log_message('debug', 'POST data: ' . print_r($this->input->post(), true));
            // Set validation rules dengan pesan error yang lebih jelas
            $this->form_validation->set_rules('supplier_id', 'Supplier', 'required|numeric', array(
                'required' => 'Supplier harus dipilih',
                'numeric' => 'Supplier ID tidak valid'
            ));
            $this->form_validation->set_rules('tanggal_pesan', 'Tanggal Pesan', 'required', array(
                'required' => 'Tanggal pesan harus diisi'
            ));
            // Validasi array produk
            $produk_ids = $this->input->post('produk_id');
            $jumlahs = $this->input->post('jumlah');
            $harga_satuans = $this->input->post('harga_satuan');
            log_message('debug', 'produk_id: ' . print_r($produk_ids, true));
            log_message('debug', 'jumlah: ' . print_r($jumlahs, true));
            log_message('debug', 'harga_satuan: ' . print_r($harga_satuans, true));
            if (empty($produk_ids) || !is_array($produk_ids)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Minimal satu produk harus dipilih'
                );
                log_message('error', 'Pembelian create error: produk_id kosong atau bukan array.');
                echo json_encode($response);
                return;
            }
            // Validasi setiap item
            for ($i = 0; $i < count($produk_ids); $i++) {
                if (empty($produk_ids[$i]) || empty($jumlahs[$i]) || empty($harga_satuans[$i])) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Semua field produk harus diisi'
                    );
                    log_message('error', 'Pembelian create error: Ada field produk kosong.');
                    echo json_encode($response);
                    return;
                }
                if (!is_numeric($jumlahs[$i]) || $jumlahs[$i] <= 0) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Jumlah harus berupa angka positif'
                    );
                    log_message('error', 'Pembelian create error: jumlah bukan angka positif.');
                    echo json_encode($response);
                    return;
                }
                if (!is_numeric($harga_satuans[$i]) || $harga_satuans[$i] <= 0) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Harga satuan harus berupa angka positif'
                    );
                    log_message('error', 'Pembelian create error: harga_satuan bukan angka positif.');
                    echo json_encode($response);
                    return;
                }
            }
            if ($this->form_validation->run() === FALSE) {
                $response = array(
                    'status' => 'error',
                    'message' => strip_tags(validation_errors())
                );
                log_message('error', 'Pembelian create error: validasi gagal. ' . print_r($response, true));
            } else {
                // Mulai transaction
                $this->db->trans_start();
                $data_pembelian = array(
                    'supplier_id' => $this->input->post('supplier_id'),
                    'tanggal_pesan' => $this->input->post('tanggal_pesan'),
                    'catatan' => $this->input->post('catatan') ? $this->input->post('catatan') : null,
                    'nomor_po' => $this->_generate_po_number(),
                    'dibuat_oleh' => $this->session->userdata('user_id'),
                    'status' => 'dipesan',
                    'total_harga' => 0.00 // akan diupdate setelah detail disimpan
                );
                log_message('debug', 'Data pembelian: ' . print_r($data_pembelian, true));
                $pembelian_id = $this->Pembelian_model->create_pembelian($data_pembelian);
                if ($pembelian_id) {
                    // Process detail pembelian
                    $total_harga = $this->_save_detail_pembelian($pembelian_id);
                    // Update total harga
                    $this->Pembelian_model->update_total_pembelian($pembelian_id, $total_harga);
                    // Complete transaction
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'Gagal menyimpan data pembelian'
                        );
                        log_message('error', 'Pembelian create error: transaksi gagal.');
                    } else {
                        $response = array(
                            'status' => 'success',
                            'message' => 'Pembelian berhasil ditambahkan dengan nomor PO: ' . $data_pembelian['nomor_po']
                        );
                        log_message('debug', 'Pembelian create success: ' . print_r($response, true));
                        // --- MULAI TAMBAHAN UNTUK WHATSAPP ---
                        // Ambil data supplier
                        $supplier = $this->Supplier_model->get_supplier_by_id($data_pembelian['supplier_id']);
                        $produk_ids = $this->input->post('produk_id');
                        $jumlahs = $this->input->post('jumlah');
                        $produk_nama = [];
                        foreach ($produk_ids as $i => $pid) {
                            $produk = $this->Produk_model->get_produk_by_id($pid);
                            $produk_nama[] = $produk['nama_produk'] . ' x ' . $jumlahs[$i];
                        }
                        $pesan = "Halo " . $supplier['nama_supplier'] . ", saya ingin melakukan pemesanan:%0A";
                        foreach ($produk_nama as $row) {
                            $pesan .= "- " . $row . "%0A";
                        }
                        if (!empty($data_pembelian['catatan'])) {
                            $pesan .= "%0ACatatan: " . urlencode($data_pembelian['catatan']) . "%0A";
                        }
                        $pesan .= "Terima kasih.";
                        // Format nomor telepon (hilangkan non-digit, ganti 0 di depan dengan 62)
                        $no_wa = preg_replace('/[^0-9]/', '', $supplier['telepon']);
                        if (substr($no_wa, 0, 1) == '0') {
                            $no_wa = '62' . substr($no_wa, 1);
                        }
                        $wa_url = "https://wa.me/" . $no_wa . "?text=" . $pesan;
                        $response['wa_url'] = $wa_url;
                        // --- END TAMBAHAN UNTUK WHATSAPP ---
                    }
                } else {
                    $this->db->trans_rollback();
                    $response = array(
                        'status' => 'error',
                        'message' => 'Gagal menambah pembelian ke database'
                    );
                    log_message('error', 'Pembelian create error: gagal insert pembelian.');
                }
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error in create pembelian: ' . $e->getMessage() . ' | POST: ' . print_r($_POST, true));
            $response = array(
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            );
        }
        log_message('debug', 'Pembelian create() selesai. Response: ' . print_r($response, true));
        echo json_encode($response);
    }

   public function update($id)
{
    header('Content-Type: application/json');
    
    try {
            // Get JSON data from request body
            $json_data = json_decode(file_get_contents('php://input'), true);
            
        // Debug: Log received data
            log_message('debug', 'Update JSON data: ' . print_r($json_data, true));
        log_message('debug', 'Update ID: ' . $id);
        
        // Set validation rules dengan pesan error yang lebih jelas
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required|numeric', array(
            'required' => 'Supplier harus dipilih',
            'numeric' => 'Supplier ID tidak valid'
        ));
        
        $this->form_validation->set_rules('tanggal_pesan', 'Tanggal Pesan', 'required', array(
            'required' => 'Tanggal pesan harus diisi'
        ));
        
            // Set data untuk validasi
            $this->form_validation->set_data($json_data);
            
            // Validasi array produk
            $produk_ids = $json_data['produk_id'] ?? [];
            $jumlahs = $json_data['jumlah'] ?? [];
            $harga_satuans = $json_data['harga_satuan'] ?? [];
        
        if (empty($produk_ids) || !is_array($produk_ids)) {
            $response = array(
                'status' => 'error',
                'message' => 'Minimal satu produk harus dipilih'
            );
            echo json_encode($response);
            return;
        }
        
            // Validasi setiap item
        for ($i = 0; $i < count($produk_ids); $i++) {
            if (empty($produk_ids[$i]) || empty($jumlahs[$i]) || empty($harga_satuans[$i])) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Semua field produk harus diisi pada item ke-' . ($i + 1)
                );
                echo json_encode($response);
                return;
            }
            
            if (!is_numeric($jumlahs[$i]) || $jumlahs[$i] <= 0) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Jumlah harus berupa angka positif pada item ke-' . ($i + 1)
                );
                echo json_encode($response);
                return;
            }
            
            if (!is_numeric($harga_satuans[$i]) || $harga_satuans[$i] <= 0) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Harga satuan harus berupa angka positif pada item ke-' . ($i + 1)
                );
                echo json_encode($response);
                return;
            }
        }

        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'status' => 'error',
                'message' => strip_tags(validation_errors())
            );
        } else {
            $pembelian = $this->Pembelian_model->get_pembelian_by_id($id);
            
            if (!$pembelian) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Data pembelian tidak ditemukan'
                );
            } elseif ($pembelian->status != 'dipesan') {
                $response = array(
                    'status' => 'error',
                    'message' => 'Pembelian yang sudah diterima tidak dapat diubah'
                );
            } else {
                $this->db->trans_start();
                
                $data_pembelian = array(
                        'supplier_id' => $json_data['supplier_id'],
                        'tanggal_pesan' => $json_data['tanggal_pesan'],
                        'catatan' => $json_data['catatan'] ? $json_data['catatan'] : null
                );

                // Debug: Log data pembelian
                log_message('debug', 'Update data pembelian: ' . print_r($data_pembelian, true));

                $result = $this->Pembelian_model->update_pembelian($id, $data_pembelian);

                if ($result) {
                    // Delete existing details first
                    $this->Pembelian_model->delete_detail_pembelian($id);
                    
                    // Process detail pembelian
                        $total_harga = $this->_save_detail_pembelian_from_json($id, $json_data);
                    
                    // Update total harga
                    $this->Pembelian_model->update_total_pembelian($id, $total_harga);
                    
                    $this->db->trans_complete();
                    
                    if ($this->db->trans_status() === FALSE) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'Gagal memperbarui pembelian - Transaction failed'
                        );
                    } else {
                        $response = array(
                            'status' => 'success',
                            'message' => 'Pembelian berhasil diperbarui'
                        );
                    }
                } else {
                    $this->db->trans_rollback();
                    $response = array(
                        'status' => 'error',
                        'message' => 'Gagal memperbarui data pembelian'
                    );
                }
            }
        }
    } catch (Exception $e) {
        $this->db->trans_rollback();
        log_message('error', 'Error in update pembelian: ' . $e->getMessage());
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
        );
    }

    echo json_encode($response);
}

    private function _save_detail_pembelian_from_json($pembelian_id, $json_data)
    {
        $produk_ids = $json_data['produk_id'];
        $jumlahs = $json_data['jumlah'];
        $harga_satuans = $json_data['harga_satuan'];

        $detail_data = array();
        $total_harga = 0;

        for ($i = 0; $i < count($produk_ids); $i++) {
            $subtotal = floatval($jumlahs[$i]) * floatval($harga_satuans[$i]);
            $detail_data[] = array(
                'pembelian_id' => $pembelian_id,
                'produk_id' => intval($produk_ids[$i]),
                'jumlah' => intval($jumlahs[$i]),
                'harga_satuan' => floatval($harga_satuans[$i])
            );
            $total_harga += $subtotal;
        }

        // Save detail
        $result = $this->Pembelian_model->save_detail_pembelian($pembelian_id, $detail_data);
        
        if (!$result) {
            throw new Exception('Gagal menyimpan detail pembelian');
        }
        
        return $total_harga;
    }

   public function get_data($id)
{
    header('Content-Type: application/json');

    // Validasi jika ID tidak valid (misalnya tidak berupa angka)
    if (!is_numeric($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid ID format'
        ]);
        return;
    }

    // Ambil data pembelian berdasarkan ID
    $pembelian = $this->Pembelian_model->get_pembelian_by_id($id);
    $detail_pembelian = $this->Pembelian_model->get_detail_pembelian($id);

    // Cek apakah data pembelian ditemukan
    if ($pembelian && $detail_pembelian) {
        // Data ditemukan, kirimkan response success
        $response = array(
            'status' => 'success',
            'data' => array(
                'pembelian' => $pembelian,
                'detail' => $detail_pembelian
            )
        );
    } else {
        // Data tidak ditemukan, kirimkan response error
        $response = array(
            'status' => 'error',
            'message' => 'Data tidak ditemukan'
        );
    }

    // Encode response menjadi JSON dan kirimkan ke client
    echo json_encode($response);
}

    public function detail($id)
    {
        $data['title'] = 'Detail Pembelian';
        $data['pembelian'] = $this->Pembelian_model->get_pembelian_by_id($id);
        $data['detail_pembelian'] = $this->Pembelian_model->get_detail_pembelian($id);
        
        if (!$data['pembelian']) {
            show_404();
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('pembelian/detail', $data);
        $this->load->view('template/footer');
    }

    public function delete($id)
    {
        header('Content-Type: application/json');
        
        $pembelian = $this->Pembelian_model->get_pembelian_by_id($id);
        
        if (!$pembelian) {
            $response = array(
                'status' => 'error',
                'message' => 'Data pembelian tidak ditemukan'
            );
        } elseif ($pembelian->status == 'diterima') {
            $response = array(
                'status' => 'error',
                'message' => 'Pembelian yang sudah diterima tidak dapat dihapus'
            );
        } else {
            if ($this->Pembelian_model->delete_pembelian($id)) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Pembelian berhasil dihapus'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal menghapus pembelian'
                );
            }
        }

        echo json_encode($response);
    }

    public function terima($id)
    {
        header('Content-Type: application/json');
        
        $pembelian = $this->Pembelian_model->get_pembelian_by_id($id);
        
        if (!$pembelian) {
            $response = array(
                'status' => 'error',
                'message' => 'Data pembelian tidak ditemukan'
            );
        } elseif ($pembelian->status != 'dipesan') {
            $response = array(
                'status' => 'error',
                'message' => 'Pembelian tidak dapat diterima'
            );
        } else {
            if ($this->Pembelian_model->terima_pembelian($id)) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Pembelian berhasil diterima dan stok telah diperbarui'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal menerima pembelian'
                );
            }
        }

        echo json_encode($response);
    }

    private function _save_detail_pembelian($pembelian_id)
    {
        $produk_ids = $this->input->post('produk_id');
        $jumlahs = $this->input->post('jumlah');
        $harga_satuans = $this->input->post('harga_satuan');

        $detail_data = array();
        $total_harga = 0;

        for ($i = 0; $i < count($produk_ids); $i++) {
            $subtotal = floatval($jumlahs[$i]) * floatval($harga_satuans[$i]);
            $detail_data[] = array(
                'pembelian_id' => $pembelian_id,
                'produk_id' => $produk_ids[$i],
                'jumlah' => intval($jumlahs[$i]),
                'harga_satuan' => floatval($harga_satuans[$i])
            );
            $total_harga += $subtotal;
        }

        // Save detail
        $result = $this->Pembelian_model->save_detail_pembelian($pembelian_id, $detail_data);
        
        if (!$result) {
            throw new Exception('Gagal menyimpan detail pembelian');
        }
        
        return $total_harga;
    }

    private function _generate_po_number()
    {
        $date = date('Ymd');
        $last_po = $this->Pembelian_model->get_last_po_number($date);
        
        if ($last_po) {
            $last_number = intval(substr($last_po->nomor_po, -3));
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        return 'PO' . $date . sprintf('%03d', $new_number);
    }

    public function get_produk_info()
    {
        header('Content-Type: application/json');
        
        $produk_id = $this->input->post('produk_id');
        $produk = $this->Produk_model->get_produk_by_id($produk_id);
        
        if ($produk) {
            echo json_encode(array(
                'status' => 'success',
                'data' => array(
                    'harga_beli' => $produk->harga_beli,
                    'stok_current' => $produk->jumlah_stok
                )
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Produk tidak ditemukan'));
        }
    }

    public function export()
    {
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $supplier_id = $this->input->get('supplier');
        $status = $this->input->get('status');

        // Ambil data dengan filter kombinasi
        $data = $this->Pembelian_model->get_pembelian_filtered($date_start, $date_end, $supplier_id, $status);

        // Load library
        $this->load->library('excel');
        $spreadsheet = $this->excel->createSpreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title
        $sheet->setCellValue('A1', 'Purchase Report');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set filter info
        $row = 3;
        if ($date_start && $date_end) {
            $sheet->setCellValue('A' . $row, 'Period: ' . $date_start . ' to ' . $date_end);
            $row++;
        }
        if ($supplier_id) {
            $supplier = $this->Supplier_model->get_supplier_by_id($supplier_id);
            $sheet->setCellValue('A' . $row, 'Supplier: ' . $supplier->nama_supplier);
            $row++;
        }
        if ($status && $status !== 'all') {
            $sheet->setCellValue('A' . $row, 'Status: ' . ucfirst($status));
            $row++;
        }

        // Set headers
        $row += 2;
        $sheet->setCellValue('A' . $row, 'PO Number');
        $sheet->setCellValue('B' . $row, 'Supplier');
        $sheet->setCellValue('C' . $row, 'Order Date');
        $sheet->setCellValue('D' . $row, 'Total Amount');
        $sheet->setCellValue('E' . $row, 'Status');
        $sheet->setCellValue('F' . $row, 'Created By');
        $sheet->setCellValue('G' . $row, 'Notes');

        // Style headers
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'CCCCCC']
            ]
        ];
        $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($headerStyle);

        // Add data
        $row++;
        foreach ($data as $purchase) {
            $sheet->setCellValue('A' . $row, $purchase->nomor_po);
            $sheet->setCellValue('B' . $row, $purchase->nama_supplier);
            $sheet->setCellValue('C' . $row, date('Y-m-d', strtotime($purchase->tanggal_pesan)));
            $sheet->setCellValue('D' . $row, number_format($purchase->total_harga, 0, ',', '.'));
            $sheet->setCellValue('E' . $row, ucfirst($purchase->status));
            $sheet->setCellValue('F' . $row, $purchase->dibuat_oleh_nama);
            $sheet->setCellValue('G' . $row, $purchase->catatan);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set filename
        $filename = 'Purchase_Report_' . date('Y-m-d_His') . '.xlsx';

        // Redirect output to client browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = $this->excel->createWriter($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function print()
    {
        $date_start = $this->input->get('date_start');
        $date_end = $this->input->get('date_end');
        $supplier_id = $this->input->get('supplier');
        $status = $this->input->get('status');

        // Ambil data dengan filter kombinasi
        $data['pembelian'] = $this->Pembelian_model->get_pembelian_filtered($date_start, $date_end, $supplier_id, $status);
        
        // Set data untuk view
        $data['date_start'] = $date_start;
        $data['date_end'] = $date_end;
        if ($supplier_id) {
            $data['supplier'] = $this->Supplier_model->get_supplier_by_id($supplier_id);
        }
        $data['status'] = $status;

        // Load view khusus untuk print
        $this->load->view('pembelian_print', $data);
    }

    public function get_produk_by_supplier() {
        $supplier_id = $this->input->post('supplier_id');
        $produk = $this->Produk_model->get_produk_by_supplier($supplier_id);
        echo json_encode(['status' => 'success', 'produk' => $produk]);
    }
}