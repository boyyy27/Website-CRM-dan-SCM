<!DOCTYPE html>
<html>
<head>
    <title>Struk Penjualan - <?php echo $detail_pembelian->penjualan_id; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
            padding: 20px;
            line-height: 1.4;
        }
        .receipt-wrapper {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .receipt-container {
            padding: 25px 20px;
            font-size: 14px;
            color: #333;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .store-logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: block;
        }
        .store-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        .store-address {
            font-size: 12px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 5px;
        }
        .store-phone {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .invoice-id {
            font-size: 12px;
            color: #666;
        }
        .divider {
            border-top: 1px dashed #999;
            margin: 15px 0;
        }
        .transaction-info {
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 3px;
            color: #333;
        }
        .transaction-number {
            font-size: 12px;
            color: #333;
            margin-top: 8px;
        }
        .customer-address {
            color: #666;
        }
        .items-list {
            margin-bottom: 15px;
        }
        .item {
            margin-bottom: 12px;
            font-size: 13px;
        }
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2px;
        }
        .item-number {
            font-weight: bold;
            color: #333;
            margin-right: 5px;
        }
        .item-name {
            flex: 1;
            font-weight: bold;
            color: #333;
        }
        .item-total {
            font-weight: bold;
            color: #333;
            text-align: right;
            min-width: 80px;
        }
        .item-details {
            font-size: 12px;
            color: #666;
            margin-left: 15px;
        }
        .total-qty-box {
            border: 2px solid #4CAF50;
            padding: 8px 12px;
            margin: 15px 0;
            background: #f8fff8;
            border-radius: 4px;
        }
        .total-qty {
            font-weight: bold;
            font-size: 14px;
            color: #2E7D32;
            text-align: center;
        }
        .payment-summary {
            margin-bottom: 15px;
            font-size: 13px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            color: #333;
        }
        .summary-row.total {
            font-weight: bold;
            font-size: 15px;
            padding-top: 5px;
            border-top: 1px solid #999;
            margin-top: 8px;
        }
        .summary-row.payment,
        .summary-row.change {
            color: #666;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #999;
        }
        .thank-you {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .contact-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 3px;
        }
        .feedback-link {
            font-size: 10px;
            color: #999;
            margin-top: 8px;
            padding: 5px;
            background: #f9f9f9;
            border-radius: 3px;
        }
        .action-buttons {
            padding: 20px;
            background: #f8f9fa;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }
        .btn-primary {
            background: #333;
            color: white;
        }
        .btn-primary:hover {
            background: #555;
        }
        .btn-secondary {
            background: #ddd;
            color: #333;
        }
        .btn-secondary:hover {
            background: #ccc;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt-wrapper {
                box-shadow: none;
                border-radius: 0;
                max-width: none;
            }
            .action-buttons {
                display: none !important;
            }
            .receipt-container {
                padding: 10px;
            }
        }
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            .receipt-container {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-wrapper">
        <div class="receipt-container">
            <!-- Header -->
            <div class="receipt-header">
                <img src="<?php echo base_url('assets/gambar/vape.png'); ?>" alt="Logo Toko" class="store-logo">
                <div class="store-name">ZE VapeStore</div>
                <div class="store-address">
                    Jalan MT. Haryono kp serang No.9,<br>
                    RT.1/RW.3, Taman Rahayu, Kec. Setu, Kabupaten Bekasi, Jawa Barat 17320<br>
                    Bekasi
                </div>
                <div class="store-phone">No. Telp 0812-3456-7890</div>
                <div class="invoice-id">
                    <?php echo !empty($detail_pembelian->nomor_invoice) ? $detail_pembelian->nomor_invoice : 'INV' . $detail_pembelian->penjualan_id; ?>
                </div>
            </div>
            <div class="divider"></div>
            <!-- Transaction Info -->
            <div class="transaction-info">
                <div class="info-row">
                    <span><?php echo date('Y-m-d', strtotime($detail_pembelian->tanggal_jual)); ?></span>
                    <span><?php echo $detail_pembelian->nama_kasir; ?></span>
                </div>
                <div class="info-row">
                    <span><?php echo date('H:i:s', strtotime($detail_pembelian->tanggal_jual)); ?></span>
                    <span><?php echo $detail_pembelian->nama_customer ? $detail_pembelian->nama_customer : 'Customer Umum'; ?></span>
                </div>
                <?php if (!empty($detail_pembelian->alamat_customer)): ?>
                <div class="customer-address"><?php echo $detail_pembelian->alamat_customer; ?></div>
                <?php endif; ?>
                <div class="transaction-number">No.<?php echo substr($detail_pembelian->penjualan_id, -3); ?></div>
            </div>
            <div class="divider"></div>
            <!-- Items List -->
            <div class="items-list">
                <?php $no = 1; $total_qty = 0; foreach ($detail_pembelian->items as $item): ?>
                <div class="item">
                    <div class="item-header">
                        <span class="item-number"><?php echo $no++; ?>.</span>
                        <span class="item-name"><?php echo $item->nama_produk; ?></span>
                        <span class="item-total">Rp <?php echo number_format($item->harga_jual * $item->jumlah, 0, ',', '.'); ?></span>
                    </div>
                    <div class="item-details">
                        <?php echo $item->jumlah; ?> <?php echo $item->satuan ?? 'pcs'; ?> x <?php echo number_format($item->harga_jual, 0, ',', '.'); ?>
                        <?php $total_qty += $item->jumlah; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="divider"></div>
            <!-- Total QTY -->
            <div class="total-qty-box">
                <div class="total-qty">Total QTY : <?php echo $total_qty; ?></div>
            </div>
            <!-- Payment Summary -->
            <div class="payment-summary">
                <div class="summary-row">
                    <span>Sub Total</span>
                    <span>Rp <?php echo number_format($detail_pembelian->subtotal, 0, ',', '.'); ?></span>
                </div>
                <?php if (!empty($detail_pembelian->diskon) && $detail_pembelian->diskon > 0): ?>
                <div class="summary-row">
                    <span>Diskon</span>
                    <span>-Rp <?php echo number_format($detail_pembelian->diskon, 0, ',', '.'); ?></span>
                </div>
                <?php endif; ?>
                <div class="summary-row">
                    <span>PPN (11%)</span>
                    <span>Rp <?php
                        $pajak = isset($detail_pembelian->pajak) ? $detail_pembelian->pajak : round(($detail_pembelian->subtotal - ($detail_pembelian->diskon ?? 0)) * 0.11);
                        echo number_format($pajak, 0, ',', '.');
                    ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp <?php echo number_format($detail_pembelian->total_bayar, 0, ',', '.'); ?></span>
                </div>
                <div class="summary-row payment">
                    <span>Bayar (<?php echo ucfirst($detail_pembelian->metode_bayar ?? 'Tunai'); ?>)</span>
                    <span>Rp <?php
                        $bayar = isset($detail_pembelian->bayar) ? $detail_pembelian->bayar : $detail_pembelian->total_bayar;
                        echo number_format($bayar, 0, ',', '.');
                    ?></span>
                </div>
                <div class="summary-row change">
                    <span>Kembali</span>
                    <span>Rp <?php
                        $kembali = isset($detail_pembelian->kembali) ? $detail_pembelian->kembali : (($bayar ?? 0) - $detail_pembelian->total_bayar);
                        echo number_format($kembali > 0 ? $kembali : 0, 0, ',', '.');
                    ?></span>
                </div>
            </div>
            <!-- Footer -->
            <div class="receipt-footer">
                <div class="thank-you">Terimakasih Telah Berbelanja</div>
                <div class="contact-info">Link Kritik dan Saran:</div>
                <div class="feedback-link">zevapestore.com</div>
                <div class="feedback-link">instagram.com/ze_vapestore</div>
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
        </div>
    </div>
</body>
</html> 