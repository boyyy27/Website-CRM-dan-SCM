<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan CRM</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin-style.css'); ?>">
    <style>
        .crm-report-container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 2.5rem 2rem;
        }
        .crm-summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .crm-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 120px;
        }
        .crm-tabs {
            display: flex;
            gap: 0;
            margin-bottom: 2rem;
            background: rgb(222, 225, 241);
            border-radius: 8px;
            justify-content: center;
            padding: 0.3rem 0.2rem;
            box-shadow: none;
        }
        .crm-tab {
            background: none;
            border: none;
            font-size: 1.1rem;
            font-weight: 500;
            color: rgb(49, 50, 52);
            padding: 0.9rem 7.4rem;
            cursor: pointer;
            border-radius: 6px;
            margin: 0 18px;
            background: transparent;
            transition: background 0.2s, color 0.2s, font-weight 0.2s;
            outline: none;
            box-shadow: none;
        }
        .crm-tab.active {
            background: #fff;
            color: #111827;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            z-index: 2;
        }
        .crm-tab:not(.active):hover {
            background: rgb(255,255,255);
            color: rgb(103, 105, 228);
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
        @media (max-width: 900px) {
            .crm-summary-cards {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 600px) {
            .crm-summary-cards {
                grid-template-columns: 1fr;
            }
        }
        .crm-overview-tabs {
            display: flex;
            gap: 0;
            margin-bottom: 2rem;
            background: rgb(222, 225, 241);
            border-radius: 8px;
            justify-content: center;
            padding: 0.3rem 0.2rem;
            box-shadow: none;
        }
        .crm-overview-tab {
            background: none;
            border: none;
            font-size: 1.1rem;
            font-weight: 500;
            color: rgb(49, 50, 52);
            padding: 0.9rem 4.5rem;
            cursor: pointer;
            border-radius: 6px;
            margin: 0 18px;
            background: transparent;
            transition: background 0.2s, color 0.2s, font-weight 0.2s;
            outline: none;
            box-shadow: none;
        }
        .crm-overview-tab.active {
            background: #fff;
            color: #111827;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            z-index: 2;
        }
        .crm-overview-tab:not(.active):hover {
            background: rgb(255,255,255);
            color: rgb(103, 105, 228);
        }
        .overview-content {transition: opacity 0.3s, transform 0.3s;}
        .overview-content:not(.active) {opacity:0;pointer-events:none;position:absolute;z-index:-1;}
        .overview-content.active {opacity:1;pointer-events:auto;position:relative;z-index:1;}
        .crm-card.table-section {
            margin-bottom: 2.5rem;
            padding: 2rem 0 1.5rem 0 !important;
        }
        .crm-table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        #memberTable, #salesTable {
            width: 100% !important;
            min-width: 900px;
        }
    </style>
</head>
<body>
    <?php $this->load->view('template/header'); ?>
    <?php $this->load->view('template/sidebar'); ?>
    <div class="main-content">
        <div class="content-header">
            <h1>Customer Relationship Management</h1>
            <p>Dashboard Laporan CRM</p>
        </div>
        <div class="crm-toolbar" style="display:flex;gap:1rem;align-items:center;justify-content:center;margin-bottom:1.5rem;flex-wrap:wrap;">
            <form method="get" style="display:flex;gap:1rem;align-items:center;margin-bottom:0;flex-wrap:wrap;">
                <label for="tanggal_awal" style="font-weight:600;color:#64748b;">Periode:</label>
                <input type="date" id="tanggal_awal" name="tanggal_awal" value="<?= htmlspecialchars($tanggal_awal ?? '') ?>" style="padding:0.4rem 0.7rem;border-radius:8px;border:1px solid #e5e7eb;">
                <span style="font-weight:600;">s/d</span>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="<?= htmlspecialchars($tanggal_akhir ?? '') ?>" style="padding:0.4rem 0.7rem;border-radius:8px;border:1px solid #e5e7eb;">
                <button class="crm-btn" type="submit" style="padding:0.5rem 1.2rem;border-radius:8px;background:#6366f1;color:#fff;font-weight:600;">Filter</button>
                <a href="<?= site_url('index.php/Crm/laporan') ?>" class="crm-btn" style="background:#ef4444;color:#fff;padding:0.5rem 1.2rem;border-radius:8px;font-weight:600;text-decoration:none;">Reset Filter</a>
            </form>
            <button class="crm-btn" id="btnPrintCRM" title="Print" style="display:flex;align-items:center;gap:0.5rem;padding:0.5rem 1.3rem;border-radius:8px;background:#6366f1;color:#fff;border:none;font-weight:600;font-size:1rem;transition:background 0.2s;">🖨️ <span>Print</span></button>
            <button class="crm-btn-export" id="btnExportCRM" title="Export CSV" style="display:flex;align-items:center;gap:0.5rem;padding:0.5rem 1.3rem;border-radius:8px;background:#059669;color:#fff;border:none;font-weight:600;font-size:1rem;transition:background 0.2s;">📥 <span>Export CSV</span></button>
        </div>
        <div style="margin-bottom:1.2rem;display:flex;align-items:center;gap:1rem;justify-content:center;">
            <span class="periode-label" style="font-weight:600;color:#64748b;">Periode:</span>
            <span class="periode-value" style="font-weight:600;color:#222;">
                <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)): ?>
                    <?= date('d M Y', strtotime($tanggal_awal)) ?> - <?= date('d M Y', strtotime($tanggal_akhir)) ?>
                <?php else: ?>
                    Semua Periode
                <?php endif; ?>
            </span>
        </div>
        <div class="crm-summary-cards">
            <div class="crm-card">
                <div style="font-size:1.1rem;color:#64748b;">Member Aktif</div>
                <div style="font-size:2.2rem;font-weight:700;">
                    <?php echo number_format($jumlah_member_aktif); ?>
                </div>
            </div>
            <div class="crm-card">
                <div style="font-size:1.1rem;color:#64748b;">Keluhan Baru</div>
                <div style="font-size:2.2rem;font-weight:700;">
                    <?php echo number_format($jumlah_keluhan_baru); ?>
                </div>
            </div>
            <div class="crm-card">
                <div style="font-size:1.1rem;color:#64748b;">Member Terbaik</div>
                <div style="font-size:1.2rem;font-weight:700;">
                    <?php echo (!empty($pelanggan_terbaik) && !empty($pelanggan_terbaik->nama_lengkap)) ? htmlspecialchars($pelanggan_terbaik->nama_lengkap) : '-'; ?>
                </div>
                <div style="color:#10b981;font-size:0.95rem;">
                    <?php echo (!empty($pelanggan_terbaik) && is_numeric($pelanggan_terbaik->total_pembelian)) ? 'Rp ' . number_format($pelanggan_terbaik->total_pembelian,0,',','.') : '-'; ?>
                </div>
            </div>
            <div class="crm-card">
                <div style="font-size:1.1rem;color:#64748b;">Total Pendapatan</div>
                <div style="font-size:2.2rem;font-weight:700;">
                    <?php
                    $total_pendapatan = 0;
                    if (!empty($pendapatan_per_bulan)) {
                        foreach ($pendapatan_per_bulan as $row) {
                            if (isset($row['total']) && is_numeric($row['total'])) {
                                $total_pendapatan += $row['total'];
                            }
                        }
                    }
                    ?>
                    <?= $total_pendapatan > 0 ? 'Rp ' . number_format($total_pendapatan,0,',','.') : '-' ?>
                </div>
            </div>
        </div>
        <div class="crm-tabs">
            <button class="crm-tab active" onclick="showTab('overview')" id="tab-overview">Overview</button>
            <button class="crm-tab" onclick="showTab('member')" id="tab-member">Member</button>
            <button class="crm-tab" onclick="showTab('sales')" id="tab-sales">Sales</button>
        </div>
        <div id="tab-content-overview" class="tab-content active" style="display:block;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
                <div class="crm-card" style="min-height:260px;">
                    <div style="font-size:1.2rem;font-weight:600;margin-bottom:0.5rem;">Pendapatan per Bulan</div>
                    <div style="color:#64748b;font-size:0.95rem;margin-bottom:1rem;">Total pendapatan penjualan per bulan</div>
                    <canvas id="revenueChart" height="180"></canvas>
                </div>
                <div class="crm-card" style="min-height:180px;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                    <div style="font-size:1.2rem;font-weight:600;margin-bottom:0.5rem;">Customer Segments</div>
                    <div style="color:#64748b;font-size:0.95rem;margin-bottom:0.1rem;">Distribusi customer berdasarkan segmen</div>
                    <canvas id="segmenChart" style="width:100%;max-width:400px;height:160px;margin:auto;"></canvas>
                </div>
            </div>
        </div>
        <div id="tab-content-member" class="tab-content" style="display:none;">
            <div class="crm-card table-section">
                <div style="font-size:1.5rem;font-weight:800;margin-bottom:0.5rem;">Top Member</div>
                <div style="color:#64748b;font-size:1rem;margin-bottom:1.5rem;">10 pelanggan dengan jumlah transaksi terbanyak</div>
                <div class="crm-table-responsive">
                <table id="memberTable" style="border-collapse:collapse;">
                    <thead>
                        <tr style="background:#64748b;">
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Nama</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Telepon</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Jumlah Transaksi</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Total Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($top_member as $row): ?>
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:10px 8px;"> <?= !empty($row['nama_lengkap']) ? htmlspecialchars($row['nama_lengkap']) : '-' ?> </td>
                            <td style="padding:10px 8px;"> <?= !empty($row['telepon']) ? htmlspecialchars($row['telepon']) : '-' ?> </td>
                            <td style="padding:10px 8px;"> <?= is_numeric($row['jumlah_transaksi']) ? number_format($row['jumlah_transaksi']) : '-' ?> </td>
                            <td style="padding:10px 8px;">Rp <?= is_numeric($row['total_pembelian']) ? number_format($row['total_pembelian'],0,',','.') : '-' ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div id="tab-content-sales" class="tab-content" style="display:none;">
            <div class="crm-card table-section">
                <div style="font-size:1.5rem;font-weight:800;margin-bottom:0.5rem;">List Penjualan</div>
                <div style="color:#64748b;font-size:1rem;margin-bottom:1.5rem;">Data transaksi penjualan</div>
                <div class="crm-table-responsive">
                <table id="salesTable" style="border-collapse:collapse;">
                    <thead>
                        <tr style="background:#64748b;">
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">No</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Nomor Invoice</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Customer</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Tanggal</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Total Bayar</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Status Bayar</th>
                            <th style="text-align:left;padding:10px 8px;font-weight:600;color:#fff;">Kasir</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach($sales_list as $row): ?>
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:10px 8px;"> <?= $no++ ?> </td>
                            <td style="padding:10px 8px;"> <?= !empty($row['nomor_invoice']) ? htmlspecialchars($row['nomor_invoice']) : '-' ?> </td>
                            <td style="padding:10px 8px;"> <?= !empty($row['nama_customer']) ? htmlspecialchars($row['nama_customer']) : 'Non Member' ?> </td>
                            <td style="padding:10px 8px;"> <?= !empty($row['tanggal_jual']) ? htmlspecialchars($row['tanggal_jual']) : '-' ?> </td>
                            <td style="padding:10px 8px;">Rp <?= is_numeric($row['total_bayar']) ? number_format($row['total_bayar'],0,',','.') : '-' ?> </td>
                            <td style="padding:10px 8px;">
                                <?php if($row['status_bayar']=='lunas'): ?>
                                    <span style="background:#10b981;color:#fff;padding:4px 16px;border-radius:16px;font-weight:700;font-size:0.95rem;">Lunas</span>
                                <?php else: ?>
                                    <span style="background:#ef4444;color:#fff;padding:4px 16px;border-radius:16px;font-weight:700;font-size:0.95rem;">Belum Lunas</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding:10px 8px;"> <?= !empty($row['kasir_nama']) ? htmlspecialchars($row['kasir_nama']) : '-' ?> </td>
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
        document.querySelectorAll('.crm-tab').forEach(el => el.classList.remove('active'));
        const tabEl = document.getElementById('tab-content-' + tab);
        tabEl.style.display = '';
        void tabEl.offsetWidth;
        tabEl.classList.add('active');
        document.getElementById('tab-' + tab).classList.add('active');
    }
    // Tab dalam Overview
    function showOverviewTab(tab) {
        document.querySelectorAll('.overview-content').forEach(el => {
            el.classList.remove('active');
            el.style.display = 'none';
        });
        document.querySelectorAll('.crm-overview-tab').forEach(el => el.classList.remove('active'));
        const tabEl = document.getElementById('overview-content-' + tab);
        tabEl.style.display = '';
        void tabEl.offsetWidth;
        tabEl.classList.add('active');
        document.getElementById('overview-tab-' + tab).classList.add('active');
    }
    // Chart.js: Customer Segments (Pie/Donut)
    const segmenData = <?php echo json_encode($segmen); ?>;
    const ctxSegmen = document.getElementById('segmenChart').getContext('2d');
    new Chart(ctxSegmen, {
        type: 'doughnut',
        data: {
            labels: ['Member', 'Non Member'],
            datasets: [{
                data: [parseInt(segmenData.member), parseInt(segmenData.non_member)],
                backgroundColor: ['#3b82f6', '#10b981'],
                borderWidth: 2
            }]
        },
        options: {
            plugins: { legend: { display: true } }
        }
    });
    // Chart.js: Revenue per Month
    const revenueData = <?php echo json_encode($pendapatan_per_bulan); ?>;
    const revenueLabels = revenueData.map(item => item.bulan);
    const revenueTotals = revenueData.map(item => parseFloat(item.total));
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan',
                data: revenueTotals,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#10b981',
            }]
        },
        options: {
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });
    // Tab default aktif saat load
    document.addEventListener('DOMContentLoaded', function() {
        showTab('overview');
    });
    // Print & Export CRM
    function getFilterParams() {
        const tanggal_awal = document.getElementById('tanggal_awal').value;
        const tanggal_akhir = document.getElementById('tanggal_akhir').value;
        let params = '';
        if (tanggal_awal) params += 'tanggal_awal=' + encodeURIComponent(tanggal_awal);
        if (tanggal_akhir) params += (params ? '&' : '') + 'tanggal_akhir=' + encodeURIComponent(tanggal_akhir);
        return params;
    }
    document.getElementById('btnPrintCRM').onclick = function() {
        let params = getFilterParams();
        let url = '<?= site_url('index.php/Crm/print_laporan_crm') ?>';
        if (params) url += '?' + params;
        window.open(url, '_blank', 'width=900,height=600');
    };
    document.getElementById('btnExportCRM').onclick = function() {
        let params = getFilterParams();
        let url = '<?= site_url('index.php/Crm/export_laporan_crm_csv') ?>';
        if (params) url += '?' + params;
        window.location.href = url;
    };
    $(document).ready(function() {
        $('#memberTable').DataTable({
            pageLength: 10,
            order: [[2, 'desc']],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ entri',
                zeroRecords: 'Tidak ada data ditemukan',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                infoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                infoFiltered: '(disaring dari _MAX_ total entri)'
            }
        });
        $('#salesTable').DataTable({
            pageLength: 10,
            order: [[0, 'desc']],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ entri',
                zeroRecords: 'Tidak ada data ditemukan',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                infoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                infoFiltered: '(disaring dari _MAX_ total entri)'
            }
        });
    });
    </script>
    <?php $this->load->view('template/footer'); ?>
</body>
</html> 