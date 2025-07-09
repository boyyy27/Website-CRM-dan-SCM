<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Sales Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; background: #f3f4f6; }
        .main-content { min-height: 100vh; }
        .print-container { background: #fff; border-radius: 12px; box-shadow: 0 4px 24px #e5e7eb; padding: 40px 32px; max-width: 900px; margin: 32px auto; }
        h2 { color: #2563eb; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f3f4f6; color: #1f2937; font-weight: 700; }
        tr:last-child td { border-bottom: none; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .status-lunas { background: #d1fae5; color: #065f46; }
        .status-belum_lunas { background: #fee2e2; color: #dc2626; }
        @media print { .print-btn { display: none !important; } .print-container { box-shadow: none; margin: 0; border-radius: 0; } body { background: #fff; } }
        @media (max-width: 700px) { .print-container { padding: 10px 2vw; } }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="print-container">
            <h2>Sales Report</h2>
            <table>
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Payment Status</th>
                        <th>Cashier</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $subtotal = 0; if (!empty($penjualan)): ?>
                        <?php foreach ($penjualan as $sale): $subtotal += $sale->total_bayar; ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sale->nomor_invoice ?? ''); ?></td>
                            <td><?php echo !empty($sale->nama_customer) ? htmlspecialchars($sale->nama_customer) : 'Non Member'; ?></td>
                            <td><?php echo date('d M Y H:i', strtotime($sale->tanggal_jual)); ?></td>
                            <td>Rp <?php echo number_format($sale->total_bayar, 0, ',', '.'); ?></td>
                            <td><span class="status-badge status-<?php echo $sale->status_bayar; ?>"><?php echo ucfirst($sale->status_bayar); ?></span></td>
                            <td><?php echo htmlspecialchars($sale->kasir_nama ?? ''); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr style="font-weight:bold; background:#f3f4f6;">
                            <td colspan="3" style="text-align:right;">Sub Total</td>
                            <td colspan="3">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No sales found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <button class="print-btn" onclick="window.print()">🖨️ Print Report</button>
        </div>
    </div>
</body>
</html> 