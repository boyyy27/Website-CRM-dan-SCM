<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scm extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model');
        $this->load->model('Pembelian_model');
        $this->load->model('Produk_model');
        $this->load->model('Supplier_model');
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
        
        if ($tanggal_awal && $tanggal_akhir) {
            // Filter data berdasarkan periode yang dipilih
            $pembelian_filtered = $this->Pembelian_model->get_pembelian_by_date_range($tanggal_awal, $tanggal_akhir);
            $total_orders = count($pembelian_filtered);
            $total_pengeluaran = 0;
            foreach ($pembelian_filtered as $pb) {
                $total_pengeluaran += $pb->total_harga;
            }
            $orders_list = $pembelian_filtered;
            
            // Filter supplier performance berdasarkan periode yang sama
            $suppliers = $this->Supplier_model->get_active_suppliers();
            $supplier_performance = [];
            foreach ($suppliers as $supplier) {
                $all_po = $this->Pembelian_model->get_pembelian_by_supplier_and_date($supplier['supplier_id'], $tanggal_awal, $tanggal_akhir);
                $total_orders_supplier = count($all_po);
                $on_time = 0;
                foreach ($all_po as $po) {
                    if ($po->status == 'diterima') $on_time++;
                }
                $on_time_delivery = $total_orders_supplier > 0 ? round(($on_time/$total_orders_supplier)*100) : 0;
                $performance_score = $on_time_delivery;
                if ($performance_score >= 90) {
                    $status = 'Excellent';
                } elseif ($performance_score >= 80) {
                    $status = 'Good';
                } elseif ($performance_score >= 70) {
                    $status = 'Average';
                } else {
                    $status = 'Needs Improvement';
                }
                $supplier_performance[] = [
                    'nama_supplier' => $supplier['nama_supplier'],
                    'performance_score' => $performance_score,
                    'total_orders' => $total_orders_supplier,
                    'on_time_delivery' => $on_time_delivery,
                    'status' => $status
                ];
            }
            
            // Filter produk terlaris berdasarkan periode yang sama
            $produk_terlaris_chart = $this->Penjualan_model->get_produk_terlaris_by_date_range($tanggal_awal, $tanggal_akhir);
            
        } else {
            // Default: jika tidak ada filter, total_pengeluaran = semua pembelian
            $this_month = date('Y-m-01');
            $next_month = date('Y-m-01', strtotime('+1 month'));
            $pembelian_bulan_ini = $this->Pembelian_model->get_pembelian_by_date_range($this_month, $next_month);
            $total_orders = count($pembelian_bulan_ini);
            $total_pengeluaran = $this->Pembelian_model->get_total_pembelian_all();
            $orders_list = $this->Pembelian_model->get_all_pembelian();
            
            // Supplier performance untuk bulan ini
            $suppliers = $this->Supplier_model->get_active_suppliers();
            $supplier_performance = [];
            foreach ($suppliers as $supplier) {
                $all_po = $this->Pembelian_model->get_pembelian_by_supplier_and_date($supplier['supplier_id'], $this_month, $next_month);
                $total_orders_supplier = count($all_po);
                $on_time = 0;
                foreach ($all_po as $po) {
                    if ($po->status == 'diterima') $on_time++;
                }
                $on_time_delivery = $total_orders_supplier > 0 ? round(($on_time/$total_orders_supplier)*100) : 0;
                $performance_score = $on_time_delivery;
                if ($performance_score >= 90) {
                    $status = 'Excellent';
                } elseif ($performance_score >= 80) {
                    $status = 'Good';
                } elseif ($performance_score >= 70) {
                    $status = 'Average';
                } else {
                    $status = 'Needs Improvement';
                }
                $supplier_performance[] = [
                    'nama_supplier' => $supplier['nama_supplier'],
                    'performance_score' => $performance_score,
                    'total_orders' => $total_orders_supplier,
                    'on_time_delivery' => $on_time_delivery,
                    'status' => $status
                ];
            }
            
            $produk_terlaris_chart = $this->Penjualan_model->get_produk_terlaris_per_bulan(12);
        }
        
        $active_suppliers = $this->Supplier_model->count_suppliers_by_status('aktif');
        
        // Critical stock - filter berdasarkan periode yang dipilih
        if ($tanggal_awal && $tanggal_akhir) {
            // Untuk critical stock, kita perlu melihat stok produk yang dipesan dalam periode tersebut
            // yang sekarang memiliki stok <= 3
            $this->db->select('DISTINCT(p.produk_id)');
            $this->db->from('detail_pembelian dp');
            $this->db->join('pembelian p', 'dp.pembelian_id = p.pembelian_id');
            $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
            $this->db->where('p.tanggal_pesan >=', $tanggal_awal);
            $this->db->where('p.tanggal_pesan <=', $tanggal_akhir);
            $this->db->where('pr.jumlah_stok <=', 3);
            $this->db->where('pr.status', 'aktif');
            $critical_stock = $this->db->count_all_results();
        } else {
            // Default critical stock untuk bulan ini
            $this->db->where('jumlah_stok <=', 3);
            $this->db->where('status', 'aktif');
            $critical_stock = $this->db->count_all_results('produk');
        }
        
        // Grafik: Inventory Levels (pembelian per bulan)
        $inventory_chart = $this->Pembelian_model->get_pembelian_chart_data(12);
        // Grafik: Order Status Distribution (penjualan per status)
        $order_status_chart = $this->Penjualan_model->get_penjualan_chart_data(12);
        $inventory_levels = $this->Produk_model->get_active_produk();
        
        // Fast/Slow Moving Produk
        if ($tanggal_awal && $tanggal_akhir) {
            $fast_slow_moving = $this->Penjualan_model->get_fast_slow_moving($tanggal_awal, $tanggal_akhir);
        } else {
            $start = date('Y-m-01');
            $end = date('Y-m-t');
            $fast_slow_moving = $this->Penjualan_model->get_fast_slow_moving($start, $end);
        }
        
        $data = [
            'total_orders' => $total_orders,
            'active_suppliers' => $active_suppliers,
            'critical_stock' => $critical_stock,
            'inventory_chart' => $inventory_chart,
            'order_status_chart' => $order_status_chart,
            'inventory_levels' => $inventory_levels,
            'supplier_performance' => $supplier_performance,
            'orders_list' => $orders_list,
            'produk_terlaris_chart' => $produk_terlaris_chart,
            'total_pengeluaran' => $total_pengeluaran,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'fast_slow_moving' => $fast_slow_moving
        ];
        $this->load->view('template/header');
        $this->load->view('laporan_scm', $data);
    }

    public function print_orders()
    {
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $status = $this->input->get('status');
        $supplier = null;
        if ($tanggal_awal && $tanggal_akhir) {
            $pembelian = $this->Pembelian_model->get_pembelian_filtered($tanggal_awal, $tanggal_akhir, null, $status);
        } else {
            $pembelian = $this->Pembelian_model->get_all_pembelian();
        }
        $data = [
            'pembelian' => $pembelian,
            'date_start' => $tanggal_awal,
            'date_end' => $tanggal_akhir,
            'status' => $status,
            'supplier' => $supplier
        ];
        $this->load->view('pembelian_print', $data);
    }

    public function print_laporan_scm()
    {
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        
        if ($tanggal_awal && $tanggal_akhir) {
            // Filter data berdasarkan periode yang dipilih
            $pembelian_filtered = $this->Pembelian_model->get_pembelian_by_date_range($tanggal_awal, $tanggal_akhir);
            $total_orders = count($pembelian_filtered);
            $total_pengeluaran = 0;
            foreach ($pembelian_filtered as $pb) {
                $total_pengeluaran += $pb->total_harga;
            }
            $orders_list = $pembelian_filtered;
            
            // Filter supplier performance berdasarkan periode yang sama
            $suppliers = $this->Supplier_model->get_active_suppliers();
            $supplier_performance = [];
            foreach ($suppliers as $supplier) {
                $all_po = $this->Pembelian_model->get_pembelian_by_supplier_and_date($supplier['supplier_id'], $tanggal_awal, $tanggal_akhir);
                $total_orders_supplier = count($all_po);
                $on_time = 0;
                foreach ($all_po as $po) {
                    if ($po->status == 'diterima') $on_time++;
                }
                $on_time_delivery = $total_orders_supplier > 0 ? round(($on_time/$total_orders_supplier)*100) : 0;
                $performance_score = $on_time_delivery;
                if ($performance_score >= 90) {
                    $status = 'Excellent';
                } elseif ($performance_score >= 80) {
                    $status = 'Good';
                } elseif ($performance_score >= 70) {
                    $status = 'Average';
                } else {
                    $status = 'Needs Improvement';
                }
                $supplier_performance[] = [
                    'nama_supplier' => $supplier['nama_supplier'],
                    'performance_score' => $performance_score,
                    'total_orders' => $total_orders_supplier,
                    'on_time_delivery' => $on_time_delivery,
                    'status' => $status
                ];
            }
            
            // Filter produk terlaris berdasarkan periode yang sama
            $produk_terlaris_chart = $this->Penjualan_model->get_produk_terlaris_by_date_range($tanggal_awal, $tanggal_akhir);
            
        } else {
            // Default: jika tidak ada filter, total_pengeluaran = semua pembelian
            $this_month = date('Y-m-01');
            $next_month = date('Y-m-01', strtotime('+1 month'));
            $pembelian_bulan_ini = $this->Pembelian_model->get_pembelian_by_date_range($this_month, $next_month);
            $total_orders = count($pembelian_bulan_ini);
            $total_pengeluaran = $this->Pembelian_model->get_total_pembelian_all();
            $orders_list = $this->Pembelian_model->get_all_pembelian();
            
            // Supplier performance untuk bulan ini
            $suppliers = $this->Supplier_model->get_active_suppliers();
            $supplier_performance = [];
            foreach ($suppliers as $supplier) {
                $all_po = $this->Pembelian_model->get_pembelian_by_supplier_and_date($supplier['supplier_id'], $this_month, $next_month);
                $total_orders_supplier = count($all_po);
                $on_time = 0;
                foreach ($all_po as $po) {
                    if ($po->status == 'diterima') $on_time++;
                }
                $on_time_delivery = $total_orders_supplier > 0 ? round(($on_time/$total_orders_supplier)*100) : 0;
                $performance_score = $on_time_delivery;
                if ($performance_score >= 90) {
                    $status = 'Excellent';
                } elseif ($performance_score >= 80) {
                    $status = 'Good';
                } elseif ($performance_score >= 70) {
                    $status = 'Average';
                } else {
                    $status = 'Needs Improvement';
                }
                $supplier_performance[] = [
                    'nama_supplier' => $supplier['nama_supplier'],
                    'performance_score' => $performance_score,
                    'total_orders' => $total_orders_supplier,
                    'on_time_delivery' => $on_time_delivery,
                    'status' => $status
                ];
            }
            
            $produk_terlaris_chart = $this->Penjualan_model->get_produk_terlaris_per_bulan(12);
        }
        
        $active_suppliers = $this->Supplier_model->count_suppliers_by_status('aktif');
        
        // Critical stock - filter berdasarkan periode yang dipilih
        if ($tanggal_awal && $tanggal_akhir) {
            // Untuk critical stock, kita perlu melihat stok produk yang dipesan dalam periode tersebut
            // yang sekarang memiliki stok <= 3
            $this->db->select('DISTINCT(p.produk_id)');
            $this->db->from('detail_pembelian dp');
            $this->db->join('pembelian p', 'dp.pembelian_id = p.pembelian_id');
            $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
            $this->db->where('p.tanggal_pesan >=', $tanggal_awal);
            $this->db->where('p.tanggal_pesan <=', $tanggal_akhir);
            $this->db->where('pr.jumlah_stok <=', 3);
            $this->db->where('pr.status', 'aktif');
            $critical_stock = $this->db->count_all_results();
        } else {
            // Default critical stock untuk bulan ini
            $this->db->where('jumlah_stok <=', 3);
            $this->db->where('status', 'aktif');
            $critical_stock = $this->db->count_all_results('produk');
        }
        
        $inventory_levels = $this->Produk_model->get_active_produk();
        
        // Fast/Slow Moving Produk
        if ($tanggal_awal && $tanggal_akhir) {
            $fast_slow_moving = $this->Penjualan_model->get_fast_slow_moving($tanggal_awal, $tanggal_akhir);
        } else {
            $start = date('Y-m-01');
            $end = date('Y-m-t');
            $fast_slow_moving = $this->Penjualan_model->get_fast_slow_moving($start, $end);
        }
        
        $data = [
            'total_orders' => $total_orders,
            'active_suppliers' => $active_suppliers,
            'critical_stock' => $critical_stock,
            'produk_terlaris_chart' => $produk_terlaris_chart,
            'inventory_levels' => $inventory_levels,
            'supplier_performance' => $supplier_performance,
            'orders_list' => $orders_list,
            'total_pengeluaran' => $total_pengeluaran,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'fast_slow_moving' => $fast_slow_moving
        ];
        $this->load->view('laporan_scm_print', $data);
    }

    public function export_laporan_scm_csv()
    {
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        
        if ($tanggal_awal && $tanggal_akhir) {
            $pembelian_filtered = $this->Pembelian_model->get_pembelian_by_date_range($tanggal_awal, $tanggal_akhir);
            $total_orders = count($pembelian_filtered);
            $total_pengeluaran = 0;
            foreach ($pembelian_filtered as $pb) {
                $total_pengeluaran += $pb->total_harga;
            }
            $orders_list = $pembelian_filtered;
            $produk_terlaris_chart = $this->Penjualan_model->get_produk_terlaris_by_date_range($tanggal_awal, $tanggal_akhir);
        } else {
            $this_month = date('Y-m-01');
            $next_month = date('Y-m-01', strtotime('+1 month'));
            $pembelian_bulan_ini = $this->Pembelian_model->get_pembelian_by_date_range($this_month, $next_month);
            $total_orders = count($pembelian_bulan_ini);
            $total_pengeluaran = $this->Pembelian_model->get_total_pembelian_all();
            $orders_list = $this->Pembelian_model->get_all_pembelian();
            $produk_terlaris_chart = $this->Penjualan_model->get_produk_terlaris_per_bulan(12);
        }
        $active_suppliers = $this->Supplier_model->count_suppliers_by_status('aktif');
        $critical_stock = 0;
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->select('DISTINCT(p.produk_id)');
            $this->db->from('detail_pembelian dp');
            $this->db->join('pembelian p', 'dp.pembelian_id = p.pembelian_id');
            $this->db->join('produk pr', 'dp.produk_id = pr.produk_id');
            $this->db->where('p.tanggal_pesan >=', $tanggal_awal);
            $this->db->where('p.tanggal_pesan <=', $tanggal_akhir);
            $this->db->where('pr.jumlah_stok <=', 3);
            $this->db->where('pr.status', 'aktif');
            $critical_stock = $this->db->count_all_results();
        } else {
            $this->db->where('jumlah_stok <=', 3);
            $this->db->where('status', 'aktif');
            $critical_stock = $this->db->count_all_results('produk');
        }
        $inventory_levels = $this->Produk_model->get_active_produk();
        $suppliers = $this->Supplier_model->get_active_suppliers();
        $supplier_performance = [];
        foreach ($suppliers as $supplier) {
            if ($tanggal_awal && $tanggal_akhir) {
                $all_po = $this->Pembelian_model->get_pembelian_by_supplier_and_date($supplier['supplier_id'], $tanggal_awal, $tanggal_akhir);
            } else {
                $this_month = date('Y-m-01');
                $next_month = date('Y-m-01', strtotime('+1 month'));
                $all_po = $this->Pembelian_model->get_pembelian_by_supplier_and_date($supplier['supplier_id'], $this_month, $next_month);
            }
            $total_orders_supplier = count($all_po);
            $on_time = 0;
            foreach ($all_po as $po) {
                if ($po->status == 'diterima') $on_time++;
            }
            $on_time_delivery = $total_orders_supplier > 0 ? round(($on_time/$total_orders_supplier)*100) : 0;
            $performance_score = $on_time_delivery;
            if ($performance_score >= 90) {
                $status = 'Excellent';
            } elseif ($performance_score >= 80) {
                $status = 'Good';
            } elseif ($performance_score >= 70) {
                $status = 'Average';
            } else {
                $status = 'Needs Improvement';
            }
            $supplier_performance[] = [
                'nama_supplier' => $supplier['nama_supplier'],
                'performance_score' => $performance_score,
                'total_orders' => $total_orders_supplier,
                'on_time_delivery' => $on_time_delivery,
                'status' => $status
            ];
        }
        // Mulai export CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="laporan_scm.csv"');
        $output = fopen('php://output', 'w');
        // Judul
        if ($tanggal_awal && $tanggal_akhir) {
            fputcsv($output, ['LAPORAN SCM - PERIODE: ' . date('d M Y', strtotime($tanggal_awal)) . ' - ' . date('d M Y', strtotime($tanggal_akhir))]);
        } else {
            fputcsv($output, ['LAPORAN SCM - SEMUA PERIODE']);
        }
        // Summary
        fputcsv($output, []);
        fputcsv($output, ['SUMMARY']);
        fputcsv($output, ['Total Purchase Orders', $total_orders]);
        fputcsv($output, ['Active Suppliers', $active_suppliers]);
        fputcsv($output, ['Pengeluaran', 'Rp ' . number_format($total_pengeluaran, 0, ',', '.')]);
        fputcsv($output, ['Critical Stock', $critical_stock]);
        // Produk Terlaris per Bulan
        fputcsv($output, []);
        fputcsv($output, ['PRODUK TERLARIS PER BULAN']);
        fputcsv($output, ['Bulan', 'Produk', 'Jumlah Terjual']);
        foreach ($produk_terlaris_chart as $row) {
            fputcsv($output, [
                isset($row['bulan']) ? $row['bulan'] : (isset($row->bulan) ? $row->bulan : ''),
                isset($row['nama_produk']) ? $row['nama_produk'] : (isset($row->nama_produk) ? $row->nama_produk : ''),
                isset($row['total_terjual']) ? $row['total_terjual'] : (isset($row->total_terjual) ? $row->total_terjual : 0)
            ]);
        }
        // Inventory Levels
        fputcsv($output, []);
        fputcsv($output, ['INVENTORY LEVELS']);
        fputcsv($output, ['Produk', 'Stok']);
        foreach ($inventory_levels as $row) {
            fputcsv($output, [
                isset($row->nama_produk) ? $row->nama_produk : (isset($row['nama_produk']) ? $row['nama_produk'] : ''),
                isset($row->jumlah_stok) ? $row->jumlah_stok : (isset($row['jumlah_stok']) ? $row['jumlah_stok'] : 0)
            ]);
        }
        // Supplier Performance
        fputcsv($output, []);
        fputcsv($output, ['SUPPLIER PERFORMANCE']);
        fputcsv($output, ['Supplier', 'Performance Score', 'Total Orders', 'On-Time Delivery', 'Status']);
        foreach ($supplier_performance as $sp) {
            fputcsv($output, [
                $sp['nama_supplier'], $sp['performance_score'], $sp['total_orders'], $sp['on_time_delivery'], $sp['status']
            ]);
        }
        // Orders List
        fputcsv($output, []);
        fputcsv($output, ['ORDERS LIST']);
        fputcsv($output, ['No', 'Nomor PO', 'Supplier', 'Tanggal Pesan', 'Tanggal Terima', 'Total Harga', 'Status', 'Dibuat Oleh']);
        $no = 1;
        foreach ($orders_list as $order) {
            fputcsv($output, [
                $no++, 
                isset($order->nomor_po) ? $order->nomor_po : '',
                isset($order->nama_supplier) ? $order->nama_supplier : '',
                isset($order->tanggal_pesan) ? $order->tanggal_pesan : '',
                isset($order->tanggal_terima) ? ($order->tanggal_terima ?: '-') : '-',
                isset($order->total_harga) ? $order->total_harga : 0,
                isset($order->status) ? $order->status : '',
                isset($order->dibuat_oleh_nama) ? $order->dibuat_oleh_nama : ''
            ]);
        }
        fclose($output);
        exit;
    }
} 