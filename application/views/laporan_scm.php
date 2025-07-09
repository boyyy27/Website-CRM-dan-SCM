<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SCM</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin-style.css'); ?>">
    <style>
        .scm-report-container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 2.5rem 2rem;
        }
        .scm-report-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .scm-report-placeholder {
            color: #888;
            font-size: 1.2rem;
            text-align: center;
            margin-top: 2rem;
        }
        .scm-toolbar {
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .scm-toolbar form {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 0;
            flex-wrap: wrap;
        }
        .scm-toolbar .scm-btn, .scm-toolbar .scm-btn-export {
            margin: 0;
        }
        @media (max-width: 700px) {
            .scm-toolbar { flex-direction: column; gap: 0.7rem; }
            .scm-toolbar form { flex-direction: column; gap: 0.7rem; }
        }
        .tab-content {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
            transition: opacity 0.35s cubic-bezier(.4,0,.2,1), transform 0.35s cubic-bezier(.4,0,.2,1);
            min-height: 320px;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            padding-top: 0.5rem;
        }
        .tab-content.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            z-index: 1;
        }
        .scm-charts, .scm-card, .scm-summary-cards {
            margin-bottom: 2rem !important;
        }
        .scm-card {
            margin-bottom: 1.5rem;
        }
        @media (max-width: 900px) {
            .scm-charts { grid-template-columns: 1fr !important; }
        }
        .scm-tabs {
            display: flex;
            gap: 0;
            margin-bottom: 2rem;
            background:rgb(222, 225, 241);
            border-radius: 8px;
            justify-content: center;
            padding: 0.3rem 0.2rem;
            box-shadow: none;
        }
        .scm-tab {
            background: none;
            border: none;
            font-size: 1.1rem;
            font-weight: 500;
            color:rgb(49, 50, 52);
            padding: 0.9rem 7.4rem;
            cursor: pointer;
            border-radius: 6px;
            margin: 0 18px;
            background: transparent;
            transition: background 0.2s, color 0.2s, font-weight 0.2s;
            outline: none;
            box-shadow: none;
        }
        .scm-tab.active {
            background: #fff;
            color: #111827;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            z-index: 2;
        }
        .scm-tab:not(.active):hover {
            background:rgb(255, 255, 255);
            color:rgb(103, 105, 228);
        }
        @media (max-width: 900px) {
            .scm-tab { padding: 0.8rem 0; margin: 0 2px; }
        }
        @media (max-width: 700px) {
            .scm-tabs { flex-direction: column; gap: 0.5rem; padding: 0.2rem; }
            .scm-tab { width: 100%; text-align: center; padding: 0.8rem 0; }
        }
    </style>
</head>
<body>
    <?php $this->load->view('template/header'); ?>
    <?php $this->load->view('template/sidebar'); ?>
    <div class="main-content">
        <div class="content-header">
            <h1>Supply Chain Management</h1>
            <p>Dashboard Laporan SCM</p>
        </div>
        <div class="scm-toolbar" style="display:flex;gap:1rem;align-items:center;justify-content:center;margin-bottom:1.5rem;flex-wrap:wrap;">
            <form method="get" style="display:flex;gap:1rem;align-items:center;margin-bottom:0;flex-wrap:wrap;">
                <label for="tanggal_awal" style="font-weight:600;color:#64748b;">Periode:</label>
                <input type="date" id="tanggal_awal" name="tanggal_awal" value="<?= htmlspecialchars($tanggal_awal ?? '') ?>" style="padding:0.4rem 0.7rem;border-radius:8px;border:1px solid #e5e7eb;">
                <span style="font-weight:600;">s/d</span>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="<?= htmlspecialchars($tanggal_akhir ?? '') ?>" style="padding:0.4rem 0.7rem;border-radius:8px;border:1px solid #e5e7eb;">
                <button class="scm-btn" type="submit" style="padding:0.5rem 1.2rem;border-radius:8px;background:#6366f1;color:#fff;font-weight:600;">Filter</button>
                <a href="<?= site_url('index.php/Scm/laporan') ?>" class="scm-btn" style="background:#ef4444;color:#fff;padding:0.5rem 1.2rem;border-radius:8px;font-weight:600;text-decoration:none;">Reset Filter</a>
            </form>
            <button class="scm-btn" id="btnPrintSCM" title="Print Semua Data" style="display:flex;align-items:center;gap:0.5rem;padding:0.5rem 1.3rem;border-radius:8px;background:#6366f1;color:#fff;border:none;font-weight:600;font-size:1rem;transition:background 0.2s;">🖨️ <span>Print</span></button>
            <button class="scm-btn-export" id="btnExportSCM" title="Export Semua Data (CSV)" style="display:flex;align-items:center;gap:0.5rem;padding:0.5rem 1.3rem;border-radius:8px;background:#059669;color:#fff;border:none;font-weight:600;font-size:1rem;transition:background 0.2s;">📥 <span>Export CSV</span></button>
        </div>
        <div class="scm-summary-cards" style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-bottom:2rem;">
            <div class="scm-card">
                <div style="font-size:1.1rem;color:#64748b;">Total Purchase Orders</div>
                <div style="font-size:2.2rem;font-weight:700;">
                    <?php echo isset($total_orders) ? number_format($total_orders) : '0'; ?>
                </div>
                <div style="color:#10b981;font-size:0.95rem;">&nbsp;</div>
            </div>
            <div class="scm-card">
                <div style="font-size:1.1rem;color:#64748b;">Active Suppliers</div>
                <div style="font-size:2.2rem;font-weight:700;">
                    <?php echo isset($active_suppliers) ? number_format($active_suppliers) : '0'; ?>
                </div>
                <div style="color:#10b981;font-size:0.95rem;">&nbsp;</div>
            </div>
            <div class="scm-card">
                <div style="font-size:1.1rem;color:#64748b;">Pengeluaran</div>
                <div style="font-size:2.2rem;font-weight:700;">
                    Rp <?= isset($total_pengeluaran) ? number_format($total_pengeluaran,0,',','.') : '0' ?>
                </div>
                <div style="color:#ef4444;font-size:0.95rem;">
                    <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)): ?>
                        <?= date('d M Y', strtotime($tanggal_awal)) ?> - <?= date('d M Y', strtotime($tanggal_akhir)) ?>
                    <?php else: ?>
                        <span>Semua Periode (Total keseluruhan pengeluaran)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="scm-card">
                <div style="font-size:1.1rem;color:#64748b;">Critical Stock</div>
                <div style="font-size:2.2rem;font-weight:700;">
                    <?php echo isset($critical_stock) ? number_format($critical_stock) : '0'; ?>
                </div>
                <div style="color:#f59e42;font-size:0.95rem;">&nbsp;</div>
            </div>
        </div>
        <div class="scm-tabs">
            <button class="scm-tab active" onclick="showTab('overview')" id="tab-overview">Overview</button>
            <button class="scm-tab" onclick="showTab('inventory')" id="tab-inventory">Inventory</button>
            <button class="scm-tab" onclick="showTab('suppliers')" id="tab-suppliers">Fast/Slow Moving</button>
            <button class="scm-tab" onclick="showTab('orders')" id="tab-orders">Orders</button>
        </div>
        <div id="tab-content-overview" class="tab-content active" style="display:block;">
            <div class="scm-charts" style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
                <div class="scm-card" style="min-height:320px;">
                    <div style="font-size:1.2rem;font-weight:600;margin-bottom:0.5rem;">Purchase Order</div>
                    <div style="color:#64748b;font-size:0.95rem;margin-bottom:1rem;">Total Pembelian vs Jumlah PO per bulan</div>
                    <canvas id="inventoryChart" height="180"></canvas>
                </div>
                <div class="scm-card" style="min-height:320px;">
                    <div style="font-size:1.2rem;font-weight:600;margin-bottom:0.5rem;">Produk Terlaris per Bulan</div>
                    <div style="color:#64748b;font-size:0.95rem;margin-bottom:1rem;">Tren produk terlaris setiap bulan (12 bulan terakhir)</div>
                    <canvas id="produkTerlarisChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <div id="tab-content-inventory" class="tab-content" style="display:none;">
            <div class="scm-card" style="min-height:200px; width:100%; max-width:none; margin:auto;">
                <div style="font-size:1.5rem;font-weight:800;margin-bottom:0.5rem;">Inventory Levels</div>
                <div style="color:#64748b;font-size:1rem;margin-bottom:1.5rem;">Stok produk saat ini</div>
                <canvas id="inventoryLevelsChart" style="width:100%;max-width:100%;" height="220"></canvas>
            </div>
        </div>
        <div id="tab-content-suppliers" class="tab-content" style="display:none;">
            <div class="scm-card" style="padding:2rem 2rem 1.5rem 2rem;">
               
                <div style="margin-top:2.5rem;">
                    <div style="font-size:1.2rem;font-weight:700;margin-bottom:0.7rem;">Tabel Fast/Slow Moving Produk</div>
                    <div style="overflow-x:auto;">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="background:#64748b;">
                                    <th style="color:#fff;padding:10px 8px;font-weight:600;">Nama Produk</th>
                                    <th style="color:#fff;padding:10px 8px;font-weight:600;">Total Terjual</th>
                                    <th style="color:#fff;padding:10px 8px;font-weight:600;">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($fast_slow_moving)): foreach($fast_slow_moving as $row): ?>
                                <tr style="border-bottom:1px solid #f1f5f9;">
                                    <td style="padding:10px 8px;"> <?= htmlspecialchars($row['nama_produk']) ?> </td>
                                    <td style="padding:10px 8px;"> <?= number_format($row['total_terjual']) ?> </td>
                                    <td style="padding:10px 8px;">
                                        <?php if($row['kategori']==='Fast Moving'): ?>
                                            <span style="background:#10b981;color:#fff;padding:4px 16px;border-radius:16px;font-weight:700;font-size:0.95rem;">Fast Moving</span>
                                        <?php else: ?>
                                            <span style="background:#fbbf24;color:#fff;padding:4px 16px;border-radius:16px;font-weight:700;font-size:0.95rem;">Slow Moving</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="3" style="text-align:center;color:#888;padding:1.5rem;">Tidak ada data penjualan pada periode ini.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab-content-orders" class="tab-content" style="display:none;">
            <div class="scm-card" style="padding:2rem 2rem 1.5rem 2rem;">
                <div style="font-size:1.5rem;font-weight:800;margin-bottom:0.5rem;">Orders (Pembelian)</div>
                <div style="color:#64748b;font-size:1rem;margin-bottom:1.5rem;">Daftar pembelian/PO dari supplier</div>
                <div style="display:flex;gap:1rem;justify-content:flex-end;margin-bottom:1.2rem;">
                    <button type="button" class="scm-btn" onclick="printOrders()" style="background:#2563eb;color:#fff;">Print</button>
                    <button type="button" class="scm-btn-export" onclick="exportOrders()">Export CSV</button>
                </div>
                <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#64748b;">
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">No</th>
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">Nomor PO</th>
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">Supplier</th>
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">Tanggal Pesan</th>
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">Tanggal Terima</th>
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">Total Harga</th>
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">Status</th>
                            <th style="color:#fff;padding:10px 8px;font-weight:600;">Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach($orders_list as $order): ?>
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:10px 8px;"> <?= $no++ ?> </td>
                            <td style="padding:10px 8px;"> <?= htmlspecialchars($order->nomor_po) ?> </td>
                            <td style="padding:10px 8px;"> <?= htmlspecialchars($order->nama_supplier) ?> </td>
                            <td style="padding:10px 8px;"> <?= htmlspecialchars($order->tanggal_pesan) ?> </td>
                            <td style="padding:10px 8px;"> <?= $order->tanggal_terima ? htmlspecialchars($order->tanggal_terima) : '-' ?> </td>
                            <td style="padding:10px 8px;">Rp <?= number_format($order->total_harga,0,',','.') ?> </td>
                            <td style="padding:10px 8px;">
                                <?php if($order->status=='diterima'): ?>
                                    <span style="background:#10b981;color:#fff;padding:4px 16px;border-radius:16px;font-weight:700;font-size:0.95rem;">Diterima</span>
                                <?php elseif($order->status=='dipesan'): ?>
                                    <span style="background:#fbbf24;color:#fff;padding:4px 16px;border-radius:16px;font-weight:700;font-size:0.95rem;">Dipesan</span>
                                <?php else: ?>
                                    <span style="background:#ef4444;color:#fff;padding:4px 16px;border-radius:16px;font-weight:700;font-size:0.95rem;">Batal</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding:10px 8px;"> <?= htmlspecialchars($order->dibuat_oleh_nama) ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.remove('active');
            el.style.display = 'none';
        });
        document.querySelectorAll('.scm-tab').forEach(el => el.classList.remove('active'));
        const tabEl = document.getElementById('tab-content-' + tab);
        tabEl.style.display = '';
        // Trigger reflow for animation
        void tabEl.offsetWidth;
        tabEl.classList.add('active');
        document.getElementById('tab-' + tab).classList.add('active');
    }
    // Inventory Chart Data from PHP
    const inventoryData = <?php echo json_encode($inventory_chart); ?>;
    const inventoryLabels = inventoryData.map(item => item.bulan);
    const inventoryTotals = inventoryData.map(item => parseFloat(item.total_pembelian));
    const inventoryPOs = inventoryData.map(item => parseInt(item.jumlah_po));
    const ctx1 = document.getElementById('inventoryChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: inventoryLabels,
            datasets: [{
                label: 'Total Pembelian',
                data: inventoryTotals,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#6366f1',
            }, {
                label: 'Jumlah PO',
                data: inventoryPOs,
                borderColor: '#f59e42',
                borderDash: [5,5],
                fill: false,
                pointRadius: 4,
                pointBackgroundColor: '#f59e42',
            }]
        },
        options: {
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });
    // Produk Terlaris Chart Data from PHP
    const produkTerlarisData = <?php echo json_encode($produk_terlaris_chart); ?>;
    const produkTerlarisLabels = produkTerlarisData.map(item => item.bulan);
    const produkTerlarisJumlah = produkTerlarisData.map(item => parseInt(item.total_terjual));
    const produkTerlarisNama = produkTerlarisData.map(item => item.nama_produk);
    const ctxProduk = document.getElementById('produkTerlarisChart').getContext('2d');
    new Chart(ctxProduk, {
        type: 'bar',
        data: {
            labels: produkTerlarisLabels,
            datasets: [{
                label: 'Jumlah Terjual',
                data: produkTerlarisJumlah,
                backgroundColor: '#6366f1',
                borderRadius: 8,
                barPercentage: 0.6,
                categoryPercentage: 0.6
            }]
        },
        options: {
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const idx = context[0].dataIndex;
                            return produkTerlarisLabels[idx] + ' - ' + produkTerlarisNama[idx];
                        },
                        label: function(context) {
                            return 'Jumlah Terjual: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: { y: { beginAtZero: true } }
        }
    });
    // Inventory Levels Chart (Bar)
    const inventoryLevels = <?php echo json_encode($inventory_levels); ?>;
    const labelsLevels = inventoryLevels.map(item => item.nama_produk);
    const stokLevels = inventoryLevels.map(item => parseInt(item.jumlah_stok));
    const ctxLevels = document.getElementById('inventoryLevelsChart').getContext('2d');
    new Chart(ctxLevels, {
        type: 'bar',
        data: {
            labels: labelsLevels,
            datasets: [{
                label: 'Stok Produk',
                data: stokLevels,
                backgroundColor: '#10b981',
                borderRadius: 8,
                barPercentage: 0.5,
                categoryPercentage: 0.5
            }]
        },
        options: {
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });
    // Print & Export Orders
    function printOrders() {
        // Ganti URL sesuai endpoint print orders SCM
        window.open('<?php echo site_url('index.php/Scm/print_orders'); ?>' + window.location.search, '_blank', 'width=900,height=600');
    }
    function exportOrders() {
        // Ganti URL sesuai endpoint export orders SCM
        window.location.href = '<?php echo site_url('index.php/Scm/export_orders_csv'); ?>' + window.location.search;
    }
    // Print & Export SCM Report sesuai filter periode
    function getFilterParams() {
        const tanggal_awal = document.getElementById('tanggal_awal').value;
        const tanggal_akhir = document.getElementById('tanggal_akhir').value;
        let params = '';
        if (tanggal_awal) params += 'tanggal_awal=' + encodeURIComponent(tanggal_awal);
        if (tanggal_akhir) params += (params ? '&' : '') + 'tanggal_akhir=' + encodeURIComponent(tanggal_akhir);
        return params;
    }

    document.getElementById('btnPrintSCM').onclick = function() {
        let params = getFilterParams();
        let url = '<?php echo site_url('index.php/Scm/print_laporan_scm'); ?>';
        if (params) url += '?' + params;
        window.open(url, '_blank', 'width=900,height=600');
    };

    document.getElementById('btnExportSCM').onclick = function() {
        let params = getFilterParams();
        let url = '<?php echo site_url('index.php/Scm/export_laporan_scm_csv'); ?>';
        if (params) url += '?' + params;
        window.location.href = url;
    };
    // Pastikan tab Overview aktif saat load
    document.addEventListener('DOMContentLoaded', function() {
        showTab('overview');
    });
    </script>
    <?php $this->load->view('template/footer'); ?>
    <style>
    .scm-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 0;
    }
    .scm-summary-cards .scm-card {
        align-items: flex-start;
        min-height: 120px;
    }
    .scm-toolbar .scm-btn, .scm-toolbar .scm-btn-export, .scm-toolbar .scm-select {
        font-size: 1rem;
    }
    .scm-btn-export {
        background: #111827;
        color: #fff;
    }
    .scm-btn:hover { background: #4f46e5 !important; }
    .scm-btn-export:hover { background: #047857 !important; }
    </style>
</body>
</html> 