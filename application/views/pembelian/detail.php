<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; background: #f3f4f6; }
        .main-content { min-height: 100vh; }
        .invoice-container { background: #fff; border-radius: 12px; box-shadow: 0 4px 24px #e5e7eb; padding: 40px 32px; max-width: 900px; margin: 32px auto; }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 18px;
            margin-bottom: 28px;
        }
        .company-info {
            font-size: 1.1rem;
            color: #374151;
        }
        .company-info .company-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 4px;
        }
        .invoice-title {
            font-size: 2rem;
            font-weight: bold;
            color: #3730a3;
            margin-bottom: 6px;
        }
        .invoice-meta {
            text-align: right;
            color: #64748b;
            font-size: 1rem;
        }
        .invoice-meta .po-number {
            color: #6366f1;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .invoice-meta .status-badge { display: inline-block; margin-left: 8px; margin-top: 6px; vertical-align: middle; }
        .invoice-meta > div { margin-bottom: 6px; }
        .section {
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 1.1rem;
            color: #2563eb;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 4px 8px;
            color: #374151;
        }
        .info-table td.label {
            font-weight: bold;
            width: 140px;
            color: #64748b;
        }
        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: bold;
            margin-left: 8px;
            letter-spacing: 1px;
        }
        .status-dipesan { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .status-diterima { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-dibatalkan { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 4px #e5e7eb;
        }
        .detail-table th, .detail-table td {
            border: 1px solid #e5e7eb;
            padding: 10px 8px;
            text-align: left;
        }
        .detail-table th {
            background: #f1f5f9;
            color: #374151;
            font-size: 1rem;
        }
        .detail-table tfoot td {
            font-weight: bold;
            background: #f3f4f6;
            font-size: 1.1rem;
            color: #2563eb;
        }
        .footer {
            margin-top: 32px;
            color: #64748b;
            font-size: 0.98rem;
            text-align: right;
        }
        .print-btn {
            display: inline-block;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 28px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 24px;
            margin-right: 8px;
            transition: background 0.2s;
        }
        .print-btn:hover { background: #1d4ed8; }
        @media print {
            .print-btn, .back-link { display: none !important; }
            .invoice-container { box-shadow: none; margin: 0; border-radius: 0; }
            body { background: #fff; }
        }
        @media (max-width: 700px) {
            .invoice-container { padding: 10px 2vw; }
            .invoice-header { flex-direction: column; align-items: flex-start; }
            .invoice-meta { text-align: left; margin-top: 10px; }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="invoice-container">
            <a href="<?php echo site_url('index.php/pembelian/pembelian'); ?>" class="back-link">&larr; Back to Purchase List</a>
            <div class="invoice-header">
                <div class="company-info">
                    <div class="company-name">ZE Vapestore</div>
                    <div>Jalan MT. Haryono kp serang No.9,RT.1/RW.3, Taman Rahayu, Kec. Setu, Kabupaten Bekasi, Jawa Barat 17320</div>
                    <div>Telp: 0812-3456-7890</div>
                    <div>Email: info@vapestore.com</div>
                </div>
                <div class="invoice-meta">
                    <div class="invoice-title">PURCHASE ORDER</div>
                    <div class="po-number">#<?php echo htmlspecialchars($pembelian->nomor_po); ?></div>
                    <div>Status: <span class="status-badge status-<?php echo $pembelian->status; ?>"><?php echo ucfirst($pembelian->status); ?></span></div>
                    <div>Order Date: <?php echo date('d M Y', strtotime($pembelian->tanggal_pesan)); ?></div>
                    <div>Received Date: <?php echo $pembelian->tanggal_terima ? date('d M Y', strtotime($pembelian->tanggal_terima)) : '<span style=\'color:#f59e42;\'>Pending</span>'; ?></div>
                </div>
            </div>
            <div class="section">
                <div class="section-title">Supplier Information</div>
                <table class="info-table">
                    <tr><td class="label">Supplier</td><td><?php echo htmlspecialchars($pembelian->nama_supplier); ?></td></tr>
                    <tr><td class="label">Contact Person</td><td><?php echo htmlspecialchars($pembelian->kontak_person ?? '-'); ?></td></tr>
                    <tr><td class="label">Phone</td><td><?php echo htmlspecialchars($pembelian->supplier_telepon ?? '-'); ?></td></tr>
                </table>
            </div>
            <div class="section">
                <div class="section-title">Purchase Items</div>
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $total = 0; foreach ($detail_pembelian as $i => $item): $total += $item->subtotal; ?>
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo htmlspecialchars($item->nama_produk); ?></td>
                            <td><?php echo htmlspecialchars($item->nama_kategori); ?></td>
                            <td><?php echo $item->jumlah; ?></td>
                            <td>Rp <?php echo number_format($item->harga_satuan, 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($item->subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align:right;">Total</td>
                            <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="section">
                <div class="section-title">Notes</div>
                <div style="background:#f8fafc; border-radius:6px; padding:10px 14px; color:#334155; min-height:32px;">
                    <?php echo $pembelian->catatan ? htmlspecialchars($pembelian->catatan) : '-'; ?>
                </div>
            </div>
            <div class="footer">
                Printed on: <?php echo date('d M Y H:i'); ?> &nbsp; | &nbsp; Vapestore Purchase Order System
            </div>
            <button class="print-btn" onclick="window.print()">🖨️ Print Invoice</button>
        </div>
    </div>
</body>
</html> 