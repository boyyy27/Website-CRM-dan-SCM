<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?php echo $penjualan->nama_customer ? $penjualan->nama_customer : 'Customer'; ?> <?php echo date('Y-m-d', strtotime($penjualan->tanggal_jual)); ?></title>
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
        
        /* Header */
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .store-logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: #333;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .store-logo svg {
            width: 35px;
            height: 35px;
            fill: white;
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
        
        /* Divider */
        .divider {
            border-top: 1px dashed #999;
            margin: 15px 0;
        }
        
        /* Transaction Info */
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
        
        /* Customer Info */
        .customer-info {
            margin-bottom: 15px;
            font-size: 12px;
            color: #333;
        }
        
        .customer-name {
            margin-bottom: 2px;
        }
        
        .customer-address {
            color: #666;
        }
        
        /* Items */
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
        
        /* Total QTY Box */
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
        
        /* Payment Summary */
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
        
        /* Footer */
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
        
        /* Action Buttons */
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
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .btn-secondary:hover {
            background: #ccc;
        }
        
        /* Print Styles */
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
        
        /* Mobile Responsive */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .receipt-container {
                padding: 20px 15px;
            }
        }

        .btn-whatsapp {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
}

.btn-whatsapp:hover {
    background: linear-gradient(135deg, #128C7E 0%, #075E54 100%);
    color: white;
}

    </style>
</head>
<body>
    <div class="receipt-wrapper">
        <div class="receipt-container">
            <!-- Header -->
            <div class="receipt-header">
                <div class="store-logo" style="background:none; margin:0 auto 15px; display:flex; align-items:center; justify-content:center;">
                    <img src="<?php echo base_url('assets/gambar/vape.png'); ?>" alt="Logo Toko" style="width:60px; height:60px; border-radius:50%; object-fit:cover; box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                </div>
                <div class="store-name">ZE VapeStore</div>
                <div class="store-address">
                    Jalan MT. Haryono kp serang No.9,<br>
                    RT.1/RW.3, Taman Rahayu, Kec. Setu, Kabupaten Bekasi, Jawa Barat 17320<br>
                    Bekasi
                </div>
                <div class="store-phone">No. Telp 0812-3456-7890</div>
                <div class="invoice-id">
                    <?php echo !empty($penjualan->nomor_invoice) ? $penjualan->nomor_invoice : 'INV' . $penjualan->penjualan_id; ?>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Transaction Info -->
            <div class="transaction-info">
                <div class="info-row">
                    <span><?php echo date('Y-m-d', strtotime($penjualan->tanggal_jual)); ?></span>
                    <span><?php echo $penjualan->kasir_nama; ?></span>
                </div>
                <div class="info-row">
                    <span><?php echo date('H:i:s', strtotime($penjualan->tanggal_jual)); ?></span>
                    <span><?php echo $penjualan->customer_id ? $penjualan->nama_customer : 'Customer Umum'; ?></span>
                </div>
                <?php if (!empty($penjualan->customer_alamat)): ?>
                <div class="customer-address"><?php echo $penjualan->customer_alamat; ?></div>
                <?php endif; ?>
                
                <div class="transaction-number">No.<?php echo substr($penjualan->penjualan_id ?? $penjualan->nomor_invoice, -3); ?></div>
            </div>

            <div class="divider"></div>

            <!-- Items List -->
            <div class="items-list">
                <?php $no = 1; $total_qty = 0; foreach ($detail_penjualan as $item): ?>
                <div class="item">
                    <div class="item-header">
                        <span class="item-number"><?php echo $no++; ?>.</span>
                        <span class="item-name"><?php echo $item->nama_produk; ?></span>
                        <span class="item-total">Rp <?php echo number_format($item->harga_satuan * $item->jumlah, 0, ',', '.'); ?></span>
                    </div>
                    <div class="item-details">
                        <?php echo $item->jumlah; ?> <?php echo $item->satuan ?? 'pcs'; ?> x <?php echo number_format($item->harga_satuan, 0, ',', '.'); ?>
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
                    <span>Rp <?php echo number_format($penjualan->subtotal, 0, ',', '.'); ?></span>
                </div>
                <?php if (!empty($penjualan->diskon) && $penjualan->diskon > 0): ?>
                <div class="summary-row">
                    <span>Diskon</span>
                    <span>-Rp <?php echo number_format($penjualan->diskon, 0, ',', '.'); ?></span>
                </div>
                <?php endif; ?>
                <div class="summary-row">
                    <span>PPN (11%)</span>
                    <span>Rp <?php
                        $pajak = isset($penjualan->pajak) ? $penjualan->pajak : round(($penjualan->subtotal - ($penjualan->diskon ?? 0)) * 0.11);
                        echo number_format($pajak, 0, ',', '.');
                    ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp <?php echo number_format($penjualan->total_bayar, 0, ',', '.'); ?></span>
                </div>
                <div class="summary-row payment">
                    <span>Bayar (<?php echo ucfirst($penjualan->metode_bayar ?? 'Tunai'); ?>)</span>
                    <span>Rp <?php
                        $bayar = isset($penjualan->bayar) ? $penjualan->bayar : $penjualan->total_bayar;
                        echo number_format($bayar, 0, ',', '.');
                    ?></span>
                </div>
                <div class="summary-row change">
                    <span>Kembali</span>
                    <span>Rp <?php
                        $kembali = isset($penjualan->kembali) ? $penjualan->kembali : (($bayar ?? 0) - $penjualan->total_bayar);
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
            <button onclick="window.print()" class="btn btn-primary"title="Cetak Struk">Cetak Struk</button>
            <a href="<?php echo site_url('index.php/penjualan/penjualan'); ?>" class="btn btn-secondary" title="Kembali">Kembali</a>
            <?php if (!empty($penjualan->customer_telepon)): ?>
                <?php
                    $wa_number = preg_replace('/[^0-9]/', '', $penjualan->customer_telepon);
                    if (substr($wa_number, 0, 1) === '0') {
                        $wa_number = '62' . substr($wa_number, 1);
                    }
                    $customer_name = isset($penjualan->nama_customer) && $penjualan->nama_customer ? $penjualan->nama_customer : '';
                    $wa_message = "Halo kak";
                    if ($customer_name) {
                        $wa_message .= ", {$customer_name}";
                    }
                    $wa_message .= ", berikut struk pembelian Anda di ZE VapeStore:\n";
                    $wa_message .= "Invoice: " . ($penjualan->nomor_invoice ? $penjualan->nomor_invoice : '-') . "\n";
                    $wa_message .= "Tanggal: " . date('Y-m-d H:i', strtotime($penjualan->tanggal_jual)) . "\n";
                    $wa_message .= "Total: Rp " . number_format($penjualan->total_bayar, 0, ',', '.') . "\n";
                    $wa_message .= "Terima kasih telah berbelanja di ZE VapeStore!";
                    $wa_url = "https://wa.me/{$wa_number}?text=" . rawurlencode($wa_message);
                ?>
                 <a href="<?php echo $wa_url; ?>" target="_blank" class="btn btn-whatsapp" title="Kirim via WhatsApp">
            <!-- Simple WhatsApp Logo SVG -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.567-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516" fill="currentColor"/>
            </svg>
        </a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>