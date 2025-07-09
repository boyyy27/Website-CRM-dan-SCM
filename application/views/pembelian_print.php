<!DOCTYPE html>
<html>
<head>
    <title>Purchase Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filter-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .filter-info p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-dipesan {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-diterima {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-dibatalkan {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        @media print {
            body {
                margin: 0;
                padding: 20px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Purchase Report</h1>
        <p>Vapestore - Purchase Order Management System</p>
    </div>

    <div class="filter-info">
        <?php if ($date_start && $date_end): ?>
            <p><strong>Period:</strong> <?php echo date('d M Y', strtotime($date_start)); ?> to <?php echo date('d M Y', strtotime($date_end)); ?></p>
        <?php endif; ?>
        
        <?php if (isset($supplier)): ?>
            <p><strong>Supplier:</strong> <?php echo htmlspecialchars($supplier->nama_supplier ?? ''); ?></p>
        <?php endif; ?>
        
        <?php if ($status && $status !== 'all'): ?>
            <p><strong>Status:</strong> <?php echo ucfirst($status); ?></p>
        <?php endif; ?>
        
        <p><strong>Generated:</strong> <?php echo date('d M Y H:i:s'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Supplier</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $subtotal = 0;
            if (!empty($pembelian)): ?>
                <?php foreach ($pembelian as $purchase): 
                    $subtotal += $purchase->total_harga;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($purchase->nomor_po ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($purchase->nama_supplier ?? ''); ?></td>
                        <td><?php echo date('d M Y', strtotime($purchase->tanggal_pesan)); ?></td>
                        <td>Rp <?php echo number_format($purchase->total_harga, 0, ',', '.'); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo $purchase->status; ?>">
                                <?php echo ucfirst($purchase->status); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($purchase->dibuat_oleh_nama ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($purchase->catatan ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="font-weight:bold; background:#f3f4f6;">
                    <td colspan="3" style="text-align:right;">Sub Total</td>
                    <td colspan="2">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td colspan="3"></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No purchase orders found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated from Vapestore Purchase Order Management System</p>
        <p>© <?php echo date('Y'); ?> Vapestore. All rights reserved.</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Report
        </button>
    </div>
</body>
</html> 