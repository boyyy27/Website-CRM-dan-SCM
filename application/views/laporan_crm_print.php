<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Laporan CRM</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; color: #222; margin: 0; padding: 0; }
        .container { max-width: 1100px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); padding: 2.5rem 2rem; }
        h1 { font-size: 2rem; margin-bottom: 0.5rem; }
        h2 { font-size: 1.3rem; margin-top: 2.2rem; margin-bottom: 0.7rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.2rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        th, td { border: 1px solid #e5e7eb; padding: 8px 10px; text-align: left; }
        th { background: #f3f4f6; font-weight: 700; }
        .summary-table td { border: none; padding: 6px 10px; }
        .print-btn { display: inline-block; margin-bottom: 1.5rem; padding: 0.5rem 1.5rem; background: #6366f1; color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; }
        .periode-label { font-weight:600; color:#64748b; margin-right:0.5rem; }
        .periode-value { font-weight:600; color:#222; }
        .status-badge { padding: 4px 16px; border-radius: 16px; font-weight:700; font-size:0.95rem; }
        .status-lunas { background:#10b981; color:#fff; }
        .status-belum_lunas { background:#ef4444; color:#fff; }
        @media print { .print-btn { display: none; } .container { box-shadow: none; border-radius: 0; } }
    </style>
</head>
<body>
<div class="container">
    <button class="print-btn" onclick="window.print()">Print</button>
    <h1>Laporan Customer Relationship Management</h1>
    <div style="margin-bottom:1.2rem;display:flex;align-items:center;gap:1rem;">
        <span class="periode-label">Periode:</span>
        <span class="periode-value">
            <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)): ?>
                <?= date('d M Y', strtotime($tanggal_awal)) ?> - <?= date('d M Y', strtotime($tanggal_akhir)) ?>
            <?php else: ?>
                Semua Periode
            <?php endif; ?>
        </span>
    </div>
    <h2>Summary</h2>
    <table class="summary-table">
        <tr><td>Member Aktif</td><td><?= isset($jumlah_member_aktif) ? number_format($jumlah_member_aktif) : '-' ?></td></tr>
        <tr><td>Keluhan Baru</td><td><?= isset($jumlah_keluhan_baru) ? number_format($jumlah_keluhan_baru) : '-' ?></td></tr>
        <tr><td>Member Terbaik</td><td><?= isset($pelanggan_terbaik->nama_lengkap) ? htmlspecialchars($pelanggan_terbaik->nama_lengkap) : '-' ?></td></tr>
        <tr><td>Total Pembelian Member Terbaik</td><td><?= (isset($pelanggan_terbaik->total_pembelian) && is_numeric($pelanggan_terbaik->total_pembelian)) ? 'Rp ' . number_format($pelanggan_terbaik->total_pembelian,0,',','.') : '-' ?></td></tr>
        <tr><td>Total Pendapatan</td><td><?= isset($total_pendapatan) && is_numeric($total_pendapatan) ? 'Rp ' . number_format($total_pendapatan,0,',','.') : '-' ?></td></tr>
    </table>
    <h2>Top Member</h2>
    <table>
        <thead>
            <tr><th>Nama</th><th>Telepon</th><th>Jumlah Transaksi</th><th>Total Pembelian</th></tr>
        </thead>
        <tbody>
        <?php if (!empty($top_member)): foreach($top_member as $row): ?>
            <tr>
                <td><?= !empty($row['nama_lengkap']) ? htmlspecialchars($row['nama_lengkap']) : '-' ?></td>
                <td><?= !empty($row['telepon']) ? htmlspecialchars($row['telepon']) : '-' ?></td>
                <td><?= is_numeric($row['jumlah_transaksi']) ? number_format($row['jumlah_transaksi']) : '-' ?></td>
                <td><?= is_numeric($row['total_pembelian']) ? 'Rp ' . number_format($row['total_pembelian'],0,',','.') : '-' ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="4" style="text-align:center;">Tidak ada data</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <h2>List Penjualan</h2>
    <table>
        <thead>
            <tr><th>No</th><th>Nomor Invoice</th><th>Customer</th><th>Tanggal</th><th>Total Bayar</th><th>Status Bayar</th><th>Kasir</th></tr>
        </thead>
        <tbody>
        <?php if (!empty($sales_list)): $no=1; foreach($sales_list as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= !empty($row['nomor_invoice']) ? htmlspecialchars($row['nomor_invoice']) : '-' ?></td>
                <td><?= !empty($row['nama_customer']) ? htmlspecialchars($row['nama_customer']) : 'Non Member' ?></td>
                <td><?= !empty($row['tanggal_jual']) ? htmlspecialchars($row['tanggal_jual']) : '-' ?></td>
                <td><?= is_numeric($row['total_bayar']) ? 'Rp ' . number_format($row['total_bayar'],0,',','.') : '-' ?></td>
                <td><span class="status-badge status-<?= $row['status_bayar']=='lunas'?'lunas':'belum_lunas' ?>"><?php echo $row['status_bayar']=='lunas'?'Lunas':'Belum Lunas'; ?></span></td>
                <td><?= !empty($row['kasir_nama']) ? htmlspecialchars($row['kasir_nama']) : '-' ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="7" style="text-align:center;">Tidak ada data</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html> 