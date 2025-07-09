<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sales Management - ZE Vapestore</title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/Fkx7FzKJ/Pngtree-vape-device-8133386.png" />
    
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        th {
            background-color: #667eea;
            font-weight: 600;
            color: white;
        }
        
        tr:hover {
            background-color: #f9fafb;
        }

        /* Status badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-lunas {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-belum_lunas {
            background-color: #fee2e2;
            color: #dc2626;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn-action {
            background: none;
            border: none;
            padding: 6px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
        }
        
        .btn-action:hover {
            background-color: #f3f4f6;
        }
        
        .btn-view {
            color: #3b82f6;
        }
        
        .btn-view:hover {
            background-color: #dbeafe;
        }
        
        .btn-delete {
            color: #dc2626;
        }
        
        .btn-delete:hover {
            background-color: #fee2e2;
        }

        /* Filter Section Styles */
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-form {
            width: 90%;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .filter-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .btn-filter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-filter:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
        }

        .btn-export {
            background-color: #059669;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-export:hover {
            background-color: #047857;
            transform: translateY(-1px);
        }

        .btn-print {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-print:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .filter-row {
                grid-template-columns: 1fr;
            }

            .filter-actions {
                flex-direction: column;
                width: 100%;
            }

            .filter-actions button {
                width: 100%;
            }
        }
        .btn-reset {
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-reset:hover {
            background-color: #e5e7eb;
        }

       

        .btn-add-sale {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
            text-decoration: none;
            display: inline-block;
        }
        .btn-add-sale:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 14px;
            margin-top: 24px;
        }
        .btn-cancel {
            background: none;
            color: #dc2626;
            border: 2px solid #dc2626;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .btn-cancel:hover {
            background: #dc2626;
            color: #fff;
        }
        .btn-submit {
            background: #059669 !important;
            color: #fff !important;
            border: none !important;
            padding: 10px 28px !important;
            border-radius: 8px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            transition: background 0.2s;
            box-shadow: 0 2px 8px #05966922;
            text-decoration: none !important;
            display: inline-block;
        }
        .btn-submit:hover {
            background: #047857 !important;
            color: #fff !important;
        }
       
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-warning {
            background: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #34d399;
        }
        .notes-section textarea,
        .form-textarea {
            min-height: 120px;
            height: 120px;
            resize: vertical;
            font-size: 15px;
        }
    </style>

<style>
            .sale-form-wrapper {
                max-width: 100%;
                padding: 20px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background: #f8fafc;
                border-radius: 12px;
            }

            .form-group {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .form-label {
                font-weight: 600;
                color: #374151;
                font-size: 14px;
                margin-bottom: 4px;
            }

            .form-input,
            .form-select,
            .form-textarea {
                padding: 12px 16px;
                border: 2px solid #e5e7eb;
                border-radius: 8px;
                font-size: 14px;
                background: white;
                transition: all 0.2s ease;
            }

            .form-input:focus,
            .form-select:focus,
            .form-textarea:focus {
                outline: none;
                border-color: #059669;
                box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
            }

            .form-textarea {
                resize: vertical;
                font-family: inherit;
            }

            .radio-container {
                display: flex;
                gap: 16px;
                flex-wrap: wrap;
            }

            .radio-item {
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                padding: 8px 12px;
                border-radius: 6px;
                transition: background-color 0.2s ease;
            }

            .radio-item:hover {
                background: #f3f4f6;
            }

            .radio-item input[type="radio"] {
                width: 18px;
                height: 18px;
                accent-color: #059669;
            }

            .radio-text {
                font-size: 14px;
                color: #374151;
                font-weight: 500;
            }

            .sale-items-section,
            .loyalty-section,
            .totals-section,
            .notes-section {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;
            }

            .section-title {
                margin: 0;
                font-size: 16px;
                font-weight: 600;
                color: #1f2937;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .btn-add-item {
                display: flex;
                align-items: center;
                gap: 8px;
                background: linear-gradient(135deg, #059669, #047857);
                color: white;
                border: none;
                padding: 10px 16px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 14px;
                font-weight: 600;
                transition: all 0.2s ease;
                box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);
            }

            .btn-add-item:hover {
                background: linear-gradient(135deg, #047857, #065f46);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3);
            }

            .btn-add-item:active {
                transform: translateY(0);
            }

            .btn-icon {
                font-size: 16px;
                font-weight: bold;
            }

            .items-container {
                min-height: 80px;
                border: 2px dashed #d1d5db;
                border-radius: 8px;
                background: #f9fafb;
            }

            .empty-state {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 40px 20px;
                color: #6b7280;
                text-align: center;
            }

            .empty-icon {
                font-size: 32px;
                margin-bottom: 12px;
                opacity: 0.5;
            }

            .loyalty-content {
                background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
                border: 1px solid #bbf7d0;
                border-radius: 8px;
                padding: 16px;
            }

            .loyalty-balance {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .balance-label {
                font-weight: 600;
                color: #065f46;
            }

            .balance-value {
                font-weight: bold;
                color: #059669;
                font-size: 20px;
                background: white;
                padding: 4px 12px;
                border-radius: 20px;
                border: 2px solid #059669;
            }

            .loyalty-info {
                margin-top: 12px;
                padding: 8px 12px;
                background: rgba(5, 150, 105, 0.1);
                border-radius: 6px;
                color: #065f46;
            }

            .totals-grid {
                background: #f8fafc;
                border-radius: 8px;
                padding: 20px;
                border: 1px solid #e5e7eb;
            }

            .total-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .total-row:last-child {
                margin-bottom: 0;
            }

            .final-row {
                border-top: 2px solid #e5e7eb;
                padding-top: 16px;
                margin-top: 16px;
            }

            .total-label {
                font-weight: 500;
                color: #374151;
                font-size: 14px;
            }

            .final-label {
                font-weight: 700;
                font-size: 16px;
                color: #1f2937;
            }

            .total-input {
                width: 140px;
                text-align: right;
                padding: 8px 12px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                background: white;
                font-weight: 500;
            }

            .discount-input {
                color: #dc2626;
            }

            .final-input {
                background: linear-gradient(135deg, #059669, #047857);
                color: white;
                border: none;
                font-weight: bold;
                font-size: 16px;
                width: 160px;
            }

            /* Responsive Design */
            @media (max-width: 1200px) {
                .form-row {
                    grid-template-columns: repeat(3, 1fr) !important;
                }
            }

            @media (max-width: 768px) {
                .sale-form-wrapper {
                    padding: 16px;
                }

                .form-row {
                    grid-template-columns: 1fr !important;
                    gap: 12px !important;
                }

                .section-header {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 12px;
                }

                .radio-container {
                    flex-direction: column;
                    gap: 8px;
                }

                .total-row {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 8px;
                }

                .total-input,
                .final-input {
                    width: 100%;
                }

                .loyalty-balance {
                    flex-direction: column;
                    gap: 12px;
                    text-align: center;
                }
            }

            @media (max-width: 480px) {
                .sale-form-wrapper {
                    padding: 12px;
                }

                .sale-items-section,
                .loyalty-section,
                .totals-section,
                .notes-section {
                    padding: 16px;
                }
        }
    </style>
</head>

<body>
  
    <div class="main-content">
      
        <div class="content-header">
            <h1>Sales Management</h1>
            <p>Manage your sales transactions and customer orders</p>
        </div>
        <!-- Summary Cards -->
        <div class="summary-cards" style="display: flex; gap: 24px; margin-bottom: 28px; flex-wrap: wrap;">
            <div style="flex:1; min-width:220px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 14px; padding: 28px 24px; box-shadow: 0 2px 8px #667eea22; display: flex; flex-direction: column; align-items: flex-start;">
                <div style="font-size: 15px; font-weight: 500; opacity: 0.9; margin-bottom: 8px;">Total Produk Terjual Bulan Ini</div>
                <div style="font-size: 2.2rem; font-weight: bold; letter-spacing: 1px;">
                    <?php echo number_format($total_produk_terjual_bulan_ini, 0, ',', '.'); ?>
                </div>
            </div>
            <div style="flex:1; min-width:220px; background: linear-gradient(135deg, #059669 0%, #34d399 100%); color: white; border-radius: 14px; padding: 28px 24px; box-shadow: 0 2px 8px #05966922; display: flex; flex-direction: column; align-items: flex-start;">
                <div style="font-size: 15px; font-weight: 500; opacity: 0.9; margin-bottom: 8px;">Jumlah Transaksi Bulan Ini</div>
                <div style="font-size: 2.2rem; font-weight: bold; letter-spacing: 1px;">
                    <?php echo number_format($jumlah_transaksi_bulan_ini, 0, ',', '.'); ?>
                </div>
            </div>
            <div style="flex:1; min-width:220px; background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%); color: white; border-radius: 14px; padding: 28px 24px; box-shadow: 0 2px 8px #f59e4222; display: flex; flex-direction: column; align-items: flex-start;">
                <div style="font-size: 15px; font-weight: 500; opacity: 0.9; margin-bottom: 8px;">Total Penjualan Bulan Ini</div>
                <div style="font-size: 2.2rem; font-weight: bold; letter-spacing: 1px;">
                    Rp <?php echo number_format($total_penjualan_bulan_ini, 0, ',', '.'); ?>
                </div>
            </div>
        </div>
        <!-- Filter Section -->
        <div class="filter-section">
            <form id="filter-form" class="filter-form">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="date_start">Start Date</label>
                        <input type="date" id="date_start" name="date_start" class="filter-input"
                               value="<?php echo isset($_GET['date_start']) ? htmlspecialchars($_GET['date_start']) : ''; ?>">
                    </div>
                    <div class="filter-group">
                        <label for="date_end">End Date</label>
                        <input type="date" id="date_end" name="date_end" class="filter-input"
                               value="<?php echo isset($_GET['date_end']) ? htmlspecialchars($_GET['date_end']) : ''; ?>">
                    </div>
                    <div class="filter-group">
                        <label for="customer">Member</label>
                        <select id="customer" name="customer" class="filter-input">
                            <option value="">All Member</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?php echo $customer->customer_id; ?>" <?php echo (isset($_GET['customer']) && $_GET['customer'] == $customer->customer_id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($customer->nama_lengkap); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="status_bayar">Payment Status</label>
                        <select id="status_bayar" name="status_bayar" class="filter-input">
                            <option value="">All Status</option>
                            <option value="lunas" <?php echo (isset($_GET['status_bayar']) && $_GET['status_bayar'] == 'lunas') ? 'selected' : ''; ?>>Paid</option>
                            <option value="belum_lunas" <?php echo (isset($_GET['status_bayar']) && $_GET['status_bayar'] == 'belum_lunas') ? 'selected' : ''; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">Apply Filter</button>
                        <button type="button" onclick="resetFilter()" class="btn-reset">Reset</button>
                        <button type="button" onclick="exportReport()" class="btn-export">Export Report</button>
                        <button type="button" onclick="printReport()" class="btn-print">Print Report</button>
                    </div>
                </div>
            </form>
        </div>
        <button onclick="openSaleModal('add')" class="btn-add-sale">➕ Add New Sale</button>

        <?php if (
            $this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                ✅ <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-warning">
                ⚠️ <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Table with Sales Data -->
        <div class="table-container">
            <table id="salesTable">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Payment Status</th>
                        <th>Cashier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penjualan)): ?>
                        <?php foreach ($penjualan as $sale): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($sale->nomor_invoice); ?></td>
                                <td><?php echo $sale->nama_customer ? htmlspecialchars($sale->nama_customer) : '-'; ?></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($sale->tanggal_jual)); ?></td>
                                <td>Rp <?php echo number_format($sale->total_bayar, 0, ',', '.'); ?></td>
                                <td><span class="status-badge status-<?php echo $sale->status_bayar; ?>"><?php echo ucfirst($sale->status_bayar); ?></span></td>
                                <td><?php echo htmlspecialchars($sale->kasir_nama); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo site_url('index.php/penjualan/detail/' . $sale->penjualan_id); ?>" class="btn-action btn-view" title="View Details">👁️</a>
                                        <?php if ($sale->status_bayar == 'belum_lunas'): ?>
                                            <button onclick="openPaymentModal(<?php echo $sale->penjualan_id; ?>, '<?php echo htmlspecialchars($sale->nomor_invoice); ?>')" class="btn-action btn-pay" title="Mark as Paid">💰</button>
                                            <button onclick="openSaleModal('edit', <?php echo $sale->penjualan_id; ?>)" class="btn-action btn-edit" title="Edit Sale">✏️</button>
                                            <button onclick="openDeleteSaleModal(<?php echo $sale->penjualan_id; ?>, '<?php echo htmlspecialchars($sale->nomor_invoice); ?>')" class="btn-action btn-delete" title="Delete Sale">🗑️</button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                                No sales found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add/Edit/Delete Sale -->
    <div id="saleModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.2);">
        <div class="modal-content" style="background:#fff; border-radius:10px; width:90vw; max-width:1400px; margin:60px auto; padding:32px; position:relative; box-shadow:0 8px 32px #0001;">
            <div class="modal-header" style="display:flex; justify-content:space-between; align-items:center;">
                <h2 id="sale-modal-title" style="margin:0; font-size:1.3rem; color:#fff;">Add New Sale</h2>
                <span class="close" onclick="closeSaleModal()" style="font-size:2rem; cursor:pointer;">&times;</span>
            </div>
            <div id="sale-alert"></div>
            <form id="sale-modal-form" method="post" style="width:100%; max-width:100%; margin:0;">
                <div id="sale-form-fields"></div>
            </form>
            <div class="modal-footer">
                <button type="button" onclick="closeSaleModal()" class="btn-cancel">Cancel</button>
                <button type="submit" form="sale-modal-form" id="sale-modal-submit" class="btn-submit">Create Sale</button>
            </div>
        </div>
    </div>

    <!-- Modal Bayar -->
    <div id="payModal" class="modal" style="display:none; position:fixed; z-index:1001; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.2);">
        <div class="modal-content" style="background:#fff; border-radius:10px; max-width:400px; margin:100px auto; padding:32px; position:relative; box-shadow:0 8px 32px #0001;">
            <div class="modal-header" style="display:flex; justify-content:space-between; align-items:center;">
                <h2 style="margin:0; font-size:1.2rem; color:#059669;">Konfirmasi Pembayaran</h2>
                <span class="close" onclick="closePayModal()" style="font-size:2rem; cursor:pointer;">&times;</span>
            </div>
            <form id="pay-modal-form" method="post">
                <div style="margin-bottom:16px;">
                    <label for="pay_metode_bayar">Metode Bayar</label>
                    <select id="pay_metode_bayar" name="metode_bayar" required style="width:100%;padding:8px;margin-top:6px;">
                        <option value="tunai">Cash</option>
                        <option value="kartu">Card</option>
                        <option value="transfer">Transfer</option>
                        <option value="e_wallet">E-Wallet</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                <button type="submit" class="btn-action btn-pay" style="background:#059669;color:white;padding:10px 18px;border:none;border-radius:6px;">Tandai Lunas</button>
            </form>
        </div>
    </div>

    <script>
        // Filter form submit
        document.getElementById('filter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const params = new URLSearchParams();
            
            for (let [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }
            
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        });

        function resetFilter() {
            document.getElementById('date_start').value = '';
            document.getElementById('date_end').value = '';
            document.getElementById('customer').value = '';
            document.getElementById('status_bayar').value = '';
            window.location.href = window.location.pathname;
        }

        function exportReport() {
            const formData = new FormData(document.getElementById('filter-form'));
            const params = new URLSearchParams();
            
            for (let [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }
            
            window.location.href = `<?php echo site_url('index.php/penjualan/export'); ?>?${params.toString()}`;
        }

        function printReport() {
            const formData = new FormData(document.getElementById('filter-form'));
            const params = new URLSearchParams();
            
            for (let [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }
            
            window.open(`<?php echo site_url('index.php/penjualan/print'); ?>?${params.toString()}`, '_blank', 'width=800,height=600');
        }

        // Modal Elements
        const saleModal = document.getElementById("saleModal");
        const saleModalTitle = document.getElementById("sale-modal-title");
        const saleModalSubmit = document.getElementById("sale-modal-submit");
        const saleModalForm = document.getElementById("sale-modal-form");
        const saleFormFields = document.getElementById("sale-form-fields");
        let saleItemCount = 0;
        const produk = <?php echo json_encode($produk); ?>;
        const customers = <?php echo json_encode($customers); ?>;
        const users = <?php echo json_encode($users ?? []); ?>;

        function openDeleteSaleModal(saleId, invoiceNo) {
            saleModal.style.display = "block";
            document.body.style.overflow = "hidden";
            saleModalTitle.innerHTML = "🗑️ Delete Sale";
            saleModalSubmit.innerHTML = "Delete Sale";
            saleModalSubmit.className = "btn-action btn-delete";
            saleModalForm.action = "<?php echo site_url('index.php/penjualan/hapus/'); ?>" + saleId;
            saleFormFields.innerHTML = `
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 15px;">
                    <p style="color: #dc2626; margin: 0; font-weight: 500;">
                        ⚠️ Are you sure you want to delete this sale (Invoice: <b>${invoiceNo}</b>)? This action cannot be undone.
                    </p>
                </div>
                <input type="hidden" name="delete_confirm" value="1">
            `;
        }

        function openSaleModal(action, saleId = null) {
            saleModal.style.display = "block";
            document.body.style.overflow = "hidden";
            saleItemCount = 0;
            if (action === 'add') {
                saleModalTitle.innerHTML = "➕ Add New Sale";
                saleModalSubmit.innerHTML = "Create Sale";
                saleModalSubmit.className = "btn-action btn-view";
                saleModalForm.action = "<?php echo site_url('index.php/penjualan/tambah'); ?>";
                renderSaleForm();
                addSaleItem();
                updateTotalAmount();
            } else if (action === 'edit') {
                saleModalTitle.innerHTML = "✏️ Edit Sale";
                saleModalSubmit.innerHTML = "Update Sale";
                saleModalSubmit.className = "btn-action btn-edit";
                saleModalForm.action = "<?php echo site_url('index.php/penjualan/edit/'); ?>" + saleId;
                // AJAX load sale data
                fetch("<?php echo site_url('index.php/penjualan/get_sale/'); ?>" + saleId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            renderSaleForm();
                            document.getElementById('customer_id').value = data.sale.customer_id;
                            document.getElementById('tanggal_jual').value = data.sale.tanggal_jual.replace(' ', 'T');
                            document.getElementById('metode_bayar').value = data.sale.metode_bayar;
                            document.getElementById('status_bayar').value = data.sale.status_bayar;
                            document.getElementById('catatan').value = data.sale.catatan || '';
                            // Isi detail item
                            const itemsContainer = document.getElementById('sale-items-container');
                            itemsContainer.innerHTML = '';
                            saleItemCount = 0;
                            data.sale.items.forEach(item => {
                                addSaleItem();
                                const lastItem = itemsContainer.lastElementChild;
                                lastItem.querySelector('select[name="produk_id[]"]').value = item.produk_id;
                                lastItem.querySelector('input[name="jumlah[]"]').value = item.jumlah;
                                lastItem.querySelector('input[name="harga_satuan[]"]').value = item.harga_satuan;
                            });
                            updateTotalAmount();
                        }
                    });
            }
        }
        function closeSaleModal() {
            saleModal.style.display = "none";
            document.body.style.overflow = "auto";
        }
        function renderSaleForm() {
            saleFormFields.innerHTML = `
        <div class="sale-form-wrapper">
            <!-- Main Form Fields -->
            <div class="form-row" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
                <!-- Customer Type Selection -->
                    <div class="form-group">
                    <label class="form-label">Customer Type *</label>
                    <div class="radio-container">
                        <label class="radio-item">
                            <input 
                                type="radio" 
                                name="is_member" 
                                value="1" 
                                checked 
                                onchange="toggleMemberSelect(true)"
                            >
                            <span class="radio-text">Member</span>
                        </label>
                        <label class="radio-item">
                            <input 
                                type="radio" 
                                name="is_member" 
                                value="0" 
                                onchange="toggleMemberSelect(false)"
                            >
                            <span class="radio-text">Regular Customer</span>
                        </label>
                    </div>
                </div>

                <!-- Member Selection -->
                <div class="form-group" id="member-select-group">
                    <label for="customer_id" class="form-label">Select Member *</label>
                    <select id="customer_id" name="customer_id" class="form-select">
                        <option value="">Choose Member</option>
                            ${customers.map(c => `<option value="${c.customer_id}">${c.nama_lengkap}</option>`).join('')}
                        </select>
                    </div>

                <!-- Sale Date -->
                    <div class="form-group">
                    <label for="tanggal_jual" class="form-label">Sale Date *</label>
                    <input 
                        type="datetime-local" 
                        id="tanggal_jual" 
                        name="tanggal_jual" 
                        class="form-input"
                        required 
                        value="${new Date().toISOString().slice(0, 16)}"
                    >
                    </div>

                <!-- Payment Method -->
                    <div class="form-group">
                    <label for="metode_bayar" class="form-label">Payment Method *</label>
                    <select id="metode_bayar" name="metode_bayar" class="form-select" required>
                        <option value="">Select Payment</option>
                        <option value="tunai">💵 Cash</option>
                        <option value="kartu">💳 Card</option>
                        <option value="transfer">🏦 Bank Transfer</option>
                        <option value="e_wallet">📱 E-Wallet</option>
                        <option value="qris">🏧 QRIS</option>
                        </select>
                    </div>

                <!-- Payment Status -->
                    <div class="form-group">
                    <label for="status_bayar" class="form-label">Payment Status *</label>
                    <select id="status_bayar" name="status_bayar" class="form-select" required>
                        <option value="lunas">✅ Paid</option>
                        <option value="belum_lunas">⏳ Unpaid</option>
                        </select>
                    </div>
                </div>

            <!-- Sale Items Section -->
            <div class="sale-items-section">
                <div class="section-header">
                    <h4 class="section-title">📦 Sale Items</h4>
                    <button 
                        type="button" 
                        onclick="addSaleItem()" 
                        class="btn-add-item"
                    >
                        <span class="btn-icon">+</span>
                        Add Item
                    </button>
                    </div>
                <div class="sale-item-alert"></div>
                <div id="sale-items-container" class="items-container">
                    <div class="empty-state">
                        <span class="empty-icon">📋</span>
                        <p>No items added yet. Click "Add Item" to get started.</p>
                    </div>
                    </div>
                    </div>

            <!-- Loyalty Points Section -->
            <div class="loyalty-section" id="loyalty-point-group" style="display: none;">
                <div class="loyalty-header">
                    <h4 class="section-title">🏆 Loyalty Points</h4>
                </div>
                <div class="loyalty-content">
                    <div class="loyalty-balance">
                        <span class="balance-label">Available Points:</span>
                        <span id="loyalty-point-value" class="balance-value">0</span>
                </div>
                    <div id="loyalty-redeem-section" class="redeem-section"></div>
                    <div class="loyalty-info">
                        <small>💡 Minimum 5 points to redeem (5 points = Rp 50,000)</small>
                </div>
                </div>
            </div>

            <!-- Totals Section -->
            <div class="totals-section">
                <h4 class="section-title">💰 Order Summary</h4>
                <div class="totals-grid">
                    <div class="total-row">
                        <label class="total-label">Subtotal</label>
                        <input type="hidden" id="total_amount" name="total_amount">
                        <input type="text" id="total_amount_display" class="total-input" readonly placeholder="Rp 0">
                    </div>

                    <div class="total-row">
                        <label class="total-label">Loyalty Discount</label>
                        <input type="hidden" id="discount" name="diskon">
                        <input type="text" id="discount_display" class="total-input discount-input" readonly placeholder="Rp 0">
                    </div>

                     <!-- Tambahan: Field Bayar dan Kembalian -->
                    <div class="total-row" id="bayar-row">
                        <label class="total-label">Bayar</label>
                        <input type="number" id="bayar" name="bayar" class="total-input" min="0" placeholder="0" oninput="updateKembalian()">
                    </div>

                    <div class="total-row">
                        <label class="total-label">PPN (11%)</label>
                        <input type="hidden" id="pajak" name="pajak">
                        <input type="text" id="pajak_display" class="total-input" readonly placeholder="Rp 0">
                    </div>

                    <div class="total-row final-row">
                        <label class="total-label final-label">Final Total</label>
                        <input type="hidden" id="final_total" name="final_total">
                        <input type="text" id="final_total_display" class="total-input final-input" readonly placeholder="Rp 0">
                    </div>

                   
                    <div class="total-row" id="kembalian-row" style="display:none;">
                        <label class="total-label">Kembalian</label>
                        <input type="hidden" id="kembalian" name="kembalian">
                        <input type="text" id="kembalian_display" class="total-input" readonly placeholder="Rp 0">
                    </div>
                </div>
                <input type="hidden" id="poin_dipakai" name="poin_dipakai" value="0">
            </div>

            <!-- Notes Section -->
            <div class="notes-section">
                <label for="catatan" class="form-label">📝 Additional Notes</label>
                <textarea 
                    id="catatan" 
                    name="catatan" 
                    class="form-textarea"
                    placeholder="Enter any additional notes or special instructions..."
                    rows="3"
                ></textarea>
            </div>
        </div>

    `;

    // Initialize event listeners and update loyalty point information
    setTimeout(() => {
        const customerSelect = document.getElementById('customer_id');
        if (customerSelect) {
            customerSelect.addEventListener('change', updateLoyaltyPointInfo);
            updateLoyaltyPointInfo();
        }
        console.log('customers:', customers);
    }, 0);

    // Ambil ulang elemen DOM dan pasang event listener setelah render
    setTimeout(() => {
        const metodeBayar = document.getElementById('metode_bayar');
        const bayarInput = document.getElementById('bayar');
        const finalTotalInput = document.getElementById('final_total');
        const kembalianRow = document.getElementById('kembalian-row');
        function syncBayarReadonly() {
            if (!metodeBayar || !bayarInput || !finalTotalInput || !kembalianRow) return;
            if (metodeBayar.value !== 'tunai') {
                bayarInput.value = finalTotalInput.value;
                bayarInput.readOnly = true;
                bayarInput.setAttribute('tabindex', '-1');
                bayarInput.style.background = '#f3f4f6';
                bayarInput.style.pointerEvents = 'none';
                kembalianRow.style.display = 'none';
            } else {
                bayarInput.value = '';
                bayarInput.readOnly = false;
                bayarInput.removeAttribute('tabindex');
                bayarInput.style.background = '';
                bayarInput.style.pointerEvents = '';
                kembalianRow.style.display = '';
            }
            updateKembalian();
        }
        if (metodeBayar) {
            metodeBayar.addEventListener('change', syncBayarReadonly);
        }
        if (finalTotalInput) {
            finalTotalInput.addEventListener('input', syncBayarReadonly);
        }
        syncBayarReadonly();
    }, 0);
}
        function toggleMemberSelect(isMember) {
            var group = document.getElementById('member-select-group');
            var loyaltyGroup = document.getElementById('loyalty-point-group');
            var select = document.getElementById('customer_id');
            var discount = document.getElementById('discount');
            var inputPoin = document.getElementById('poin_dipakai');
            if (!group || !loyaltyGroup || !select || !discount || !inputPoin) return;
            if (isMember) {
                group.style.display = '';
                select.required = true;
                loyaltyGroup.style.display = '';
                updateLoyaltyPointInfo();
            } else {
                group.style.display = 'none';
                select.required = false;
                select.value = '';
                loyaltyGroup.style.display = 'none';
                discount.value = 0;
                inputPoin.value = 0;
                updateTotalAmount();
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleMemberSelect(true);
            document.getElementById('customer_id').addEventListener('change', updateLoyaltyPointInfo);
        });
        function addSaleItem() {
            saleItemCount++;
            const itemsContainer = document.getElementById('sale-items-container');
            const itemRow = document.createElement('div');
            itemRow.className = 'item-row';
            itemRow.id = `sale-item-${saleItemCount}`;
            itemRow.style = 'display:grid; grid-template-columns:2fr 1fr 1fr auto; gap:12px; align-items:end; margin-bottom:12px; padding:12px; border:1px solid #e5e7eb; border-radius:6px; background:#f9fafb;';
            itemRow.innerHTML = `
                <div class="form-group">
                    <label>Product *</label>
                    <select name="produk_id[]" required onchange="updateUnitPrice(this)">
                        <option value="">Select Product</option>
                        ${produk.map(product => `<option value="${product.produk_id}" data-price="${product.harga_jual}">${product.nama_produk}</option>`).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="jumlah[]" required min="1" onchange="calculateSaleSubtotal(this)">
                </div>
                <div class="form-group">
                    <label>Unit Price *</label>
                    <input type="text" name="harga_satuan[]" required readonly placeholder="Rp 0">
                </div>
                <button type="button" onclick="removeSaleItem(${saleItemCount})" class="btn-remove-item" style="background:#dc2626;color:white;border:none;padding:8px 12px;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            `;
            itemsContainer.appendChild(itemRow);
        }
        function updateUnitPrice(select) {
            const selectedOption = select.options[select.selectedIndex];
            const price = parseInt(selectedOption.getAttribute('data-price')) || '';
            const itemRow = select.closest('.item-row');
            if (itemRow) {
                const priceInput = itemRow.querySelector('input[name="harga_satuan[]"]');
                if (priceInput) {
                    priceInput.value = price ? formatRupiah(price) : '';
                }
            }
            // Cek stok produk
            const produkId = select.value;
            if (produkId) {
                const produkData = produk.find(p => p.produk_id == produkId);
                if (produkData && produkData.jumlah_stok == 0) {
                    showSaleAlert('Stok produk ini habis!');
                    select.value = '';
                    if (itemRow) {
                        const priceInput = itemRow.querySelector('input[name="harga_satuan[]"]');
                        if (priceInput) priceInput.value = '';
                    }
                }
            }
        }
        function calculateSaleSubtotal(input) {
            const itemRow = input.closest('.item-row');
            const quantity = parseInt(input.value) || 0;
            const priceInput = itemRow.querySelector('input[name="harga_satuan[]"]');
            const price = parseFloat(priceInput.value) || 0;
            const subtotal = quantity * price;
            // Update total amount
            updateTotalAmount();
        }
        function updateTotalAmount() {
            let total = 0;
            const itemRows = document.querySelectorAll('.item-row');
            itemRows.forEach(row => {
                const quantity = parseInt(row.querySelector('input[name="jumlah[]"]').value) || 0;
                const price = parseInt(row.querySelector('input[name="harga_satuan[]"]').value.replace(/[^\d]/g, '')) || 0;
                total += quantity * price;
            });
            document.getElementById('total_amount').value = total;
            document.getElementById('total_amount_display').value = formatRupiah(total);
            // Diskon hanya dari loyalty
            let discount = parseInt(document.getElementById('discount').value) || 0;
            document.getElementById('discount_display').value = formatRupiah(discount);
            // Pajak 11% dari (total - discount)
            let dpp = total - discount;
            let pajak = Math.round(dpp * 0.11);
            document.getElementById('pajak').value = pajak;
            document.getElementById('pajak_display').value = formatRupiah(pajak);
            // Final total
            const finalTotal = dpp + pajak;
            document.getElementById('final_total').value = finalTotal;
            document.getElementById('final_total_display').value = formatRupiah(finalTotal);
        }
        function removeSaleItem(itemId) {
            const itemRow = document.getElementById(`sale-item-${itemId}`);
            if (itemRow) {
                itemRow.remove();
                updateTotalAmount();
            }
        }
        saleModalForm.onsubmit = function(e) {
            updateTotalAmount();
            // Validasi pembayaran cash
            var metode = document.getElementById('metode_bayar')?.value;
            var bayar = parseInt(document.getElementById('bayar')?.value) || 0;
            var finalTotal = parseInt(document.getElementById('final_total')?.value) || 0;
            var bayarRow = document.getElementById('bayar-row');
            // Hapus pesan error lama
            var oldError = document.getElementById('bayar-error');
            if (oldError) oldError.remove();
            if (metode === 'tunai') {
                if (!bayar || bayar < finalTotal) {
                    if (bayarRow) {
                        var error = document.createElement('div');
                        error.id = 'bayar-error';
                        error.style.color = '#dc2626';
                        error.style.fontSize = '13px';
                        error.style.marginTop = '4px';
                        error.textContent = 'Nominal bayar harus diisi dan tidak boleh kurang dari total pembayaran.';
                        bayarRow.appendChild(error);
                    }
                    var bayarInput = document.getElementById('bayar');
                    if (bayarInput) bayarInput.focus();
                    return false;
                }
            }
            return true;
        };

        let paySaleId = null;
        function openPaymentModal(saleId, invoiceNo) {
            paySaleId = saleId;
            document.getElementById('payModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
            // Set form action
            document.getElementById('pay-modal-form').action = "<?php echo site_url('index.php/penjualan/bayar/'); ?>" + saleId;
        }
        function closePayModal() {
            document.getElementById('payModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Tutup modal jika klik di luar modal-content
        const saleModalOverlay = document.getElementById('saleModal');
        saleModalOverlay.addEventListener('mousedown', function(e) {
            if (e.target === saleModalOverlay) {
                closeSaleModal();
            }
        });

        $(document).ready(function() {
            $('#salesTable').DataTable({
                "pageLength": 10,
                "order": [[0, "desc"]],
                "columns": [
                    null, // ID
                    null, // Customer
                    { "type": "date" }, // Date
                    { "type": "num-fmt" }, // Total
                    null, // Payment Method
                    null, // Status
                    null  // Actions
                ],
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries per page",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });

        function updateLoyaltyPointInfo() {
            var select = document.getElementById('customer_id');
            var group = document.getElementById('loyalty-point-group');
            var value = document.getElementById('loyalty-point-value');
            var redeemSection = document.getElementById('loyalty-redeem-section');
            var inputPoin = document.getElementById('poin_dipakai');
            var discount = document.getElementById('discount');
            if (select && select.value) {
                var cust = customers.find(c => c.customer_id == select.value);
                if (cust) {
                    group.style.display = '';
                    value.textContent = cust.poin_loyalty;
                    if (cust.poin_loyalty >= 5) {
                        redeemSection.innerHTML = `<div class='input-row'><label><input type='checkbox' id='redeem_loyalty' onchange='toggleRedeemLoyalty()'> Gunakan 5 Poin untuk diskon Rp 50.000</label></div>`;
                    } else {
                        redeemSection.innerHTML = `<span style='color:#888;'>Belum cukup poin untuk redeem</span>`;
                    }
                }
            } else {
                group.style.display = 'none';
                value.textContent = 0;
                redeemSection.innerHTML = '';
            }
            inputPoin.value = 0;
            discount.value = 0;
            updateTotalAmount();
        }
        function toggleRedeemLoyalty() {
            var redeem = document.getElementById('redeem_loyalty');
            var inputPoin = document.getElementById('poin_dipakai');
            var discount = document.getElementById('discount');
            if (redeem && redeem.checked) {
                inputPoin.value = 5;
                discount.value = 50000;
            } else {
                inputPoin.value = 0;
                discount.value = 0;
            }
            updateTotalAmount();
        }
        function showSaleAlert(message) {
            var alertDiv = document.querySelector('.sale-items-section .sale-item-alert');
            if (!alertDiv) return;
            alertDiv.innerHTML = `<div class='alert alert-warning'>⚠️ ${message}</div>`;
            setTimeout(function() {
                alertDiv.innerHTML = '';
            }, 3000);
        }

        // Tambahkan di bawah function updateTotalAmount()
        function updateKembalian() {
            var metode = document.getElementById('metode_bayar')?.value;
            var bayar = parseInt(document.getElementById('bayar')?.value) || 0;
            var finalTotal = parseInt(document.getElementById('final_total').value) || 0;
            var kembalian = 0;
            if (metode === 'tunai') {
                kembalian = bayar - finalTotal;
                document.getElementById('kembalian-row').style.display = '';
            } else {
                document.getElementById('kembalian-row').style.display = 'none';
                kembalian = 0;
            }
            document.getElementById('kembalian').value = kembalian > 0 ? kembalian : 0;
            document.getElementById('kembalian_display').value = formatRupiah(kembalian > 0 ? kembalian : 0);
        }

        function formatRupiah(angka) {
            if (angka == null || angka === '' || isNaN(angka)) return 'Rp 0';
            return 'Rp ' + parseInt(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
</body>

</html>
 