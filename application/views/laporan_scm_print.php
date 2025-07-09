<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Laporan SCM</title>
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
        @media print { .print-btn { display: none; } .container { box-shadow: none; border-radius: 0; } }
    </style>
</head>
<body>
<div class="container">
    <button class="print-btn" onclick="window.print()">Print</button>
    <h1>Laporan Supply Chain Management</h1>
    <div style="margin-bottom:1.2rem;display:flex;align-items:center;gap:1rem;">
        <span class="periode-label">Periode:</span>
        <span class="periode-value">
            <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)): ?>
                <?= date('d M Y', strtotime($tanggal_awal)) ?> - <?= date('d M Y', strtotime($tanggal_akhir)) ?>
            <?php else: ?>
                Semua Periode (Total keseluruhan pengeluaran)
            <?php endif; ?>
        </span>
    </div>
    <h2>Summary</h2>
    <table class="summary-table">
        <tr><td>Total Purchase Orders</td><td><?php echo number_format($total_orders); ?></td></tr>
        <tr><td>Active Suppliers</td><td><?php echo number_format($active_suppliers); ?></td></tr>
        <tr><td>Pengeluaran</td><td>Rp <?php echo isset($total_pengeluaran) ? number_format($total_pengeluaran,0,',','.') : '0'; ?></td></tr>
        <tr><td>Critical Stock</td><td><?php echo number_format($critical_stock); ?></td></tr>
    </table>
    
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
    <h2>Produk Terlaris per Bulan</h2>
    <table>
        <thead>
            <tr><th>Bulan</th><th>Produk</th><th>Jumlah Terjual</th></tr>
        </thead>
        <tbody>
        <?php foreach($produk_terlaris_chart as $row): ?>
            <tr>
                <td><?= htmlspecialchars(isset($row['bulan']) ? $row['bulan'] : '') ?></td>
                <td><?= htmlspecialchars(isset($row['nama_produk']) ? $row['nama_produk'] : '') ?></td>
                <td><?= isset($row['total_terjual']) ? number_format($row['total_terjual']) : '0' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Inventory Levels</h2>
    <table>
        <thead>
            <tr><th>Produk</th><th>Stok</th></tr>
        </thead>
        <tbody>
        <?php foreach($inventory_levels as $row): ?>
            <tr>
                <td><?= htmlspecialchars(isset($row['nama_produk']) ? $row['nama_produk'] : '') ?></td>
                <td><?= isset($row['jumlah_stok']) ? number_format($row['jumlah_stok']) : '0' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Orders List</h2>
    <table>
        <thead>
            <tr><th>No</th><th>Nomor PO</th><th>Supplier</th><th>Tanggal Pesan</th><th>Tanggal Terima</th><th>Total Harga</th><th>Status</th><th>Dibuat Oleh</th></tr>
        </thead>
        <tbody>
        <?php $no=1; foreach($orders_list as $order): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($order->nomor_po) ?></td>
                <td><?= htmlspecialchars($order->nama_supplier) ?></td>
                <td><?= htmlspecialchars($order->tanggal_pesan) ?></td>
                <td><?= $order->tanggal_terima ? htmlspecialchars($order->tanggal_terima) : '-' ?></td>
                <td>Rp <?= number_format($order->total_harga,0,',','.') ?></td>
                <td><?= htmlspecialchars($order->status) ?></td>
                <td><?= htmlspecialchars($order->dibuat_oleh_nama) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 