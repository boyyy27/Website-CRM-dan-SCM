<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Purchase Management - ZE Vapestore</title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/Fkx7FzKJ/Pngtree-vape-device-8133386.png" />
    
    <style>
        /* Basic styling */
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        *::before,
        *::after {
            background: none !important;
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

        .status-dipesan {
            background-color: #fef3c7;
            color: #d97706;
        }

        .status-diterima {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-dibatalkan {
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
        
        .btn-edit {
            color: #059669;
        }
        
        .btn-edit:hover {
            background-color: #d1fae5;
        }
        
        .btn-delete {
            color: #dc2626;
        }
        
        .btn-delete:hover {
            background-color: #fee2e2;
        }

        .btn-receive {
            color: #7c3aed;
        }

        .btn-receive:hover {
            background-color: #ede9fe;
        }

        /* Add button */
        .btn-add-purchase {
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

        .btn-add-purchase:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 2% auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: modalSlideIn 0.3s ease-out;
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
        }

        .close {
            color: #6b7280;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .close:hover {
            color: #374151;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-modal {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background-color: #e5e7eb;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 16px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #374151;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Detail items section */
        .detail-items {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .detail-items h4 {
            margin: 0 0 16px 0;
            color: #374151;
        }

        .item-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
            align-items: end;
            margin-bottom: 12px;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background-color: #f9fafb;
        }

        .btn-remove-item {
            background-color: #dc2626;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-add-item {
            background-color: #059669;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 16px;
        }

        /* Alert styles */
        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert.success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert.error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Content header */
        .content-header {
            margin-bottom: 24px;
        }

        .content-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 8px 0;
        }

        .content-header p {
            color: #6b7280;
            margin: 0;
            font-size: 1rem;
        }

        /* Table container */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Currency formatting */
        .currency {
            font-weight: 600;
            color: #059669;
        }

        /* Date styling */
        .date-text {
            color: #6b7280;
            font-size: 14px;
        }

        /* PO Number styling */
        .po-number {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #374151;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .item-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .modal-content {
                width: 95%;
                margin: 2% auto;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }
            
            .btn-action {
                width: 100%;
                justify-content: flex-start;
                padding: 8px 12px;
            }

            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 8px;
            }
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
            width: 95%;
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
            gap: 7px;
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
    </style>
</head>

<body>
  
    <div class="main-content">
        <div class="content-header">
            <h1>Purchase Management</h1>
            <p>Manage your purchase orders and supplier transactions</p>
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
                        <label for="supplier">Supplier</label>
                        <select id="supplier" name="supplier" class="filter-input">
                            <option value="">All Suppliers</option>
                            <?php foreach (
                                $suppliers as $supplier): ?>
                                <option value="<?php echo $supplier['supplier_id']; ?>"
                                    <?php echo (isset($_GET['supplier']) && $_GET['supplier'] == $supplier['supplier_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($supplier['nama_supplier']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="filter-input">
                            <option value="">All Status</option>
                            <option value="dipesan" <?php echo (isset($_GET['status']) && $_GET['status'] == 'dipesan') ? 'selected' : ''; ?>>Ordered</option>
                            <option value="diterima" <?php echo (isset($_GET['status']) && $_GET['status'] == 'diterima') ? 'selected' : ''; ?>>Received</option>
                            <option value="batal" <?php echo (isset($_GET['status']) && $_GET['status'] == 'batal') ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">Apply Filter</button>
                        <button type="button" onclick="resetFilter()" class="btn-reset">Reset</button>
                        <button type="button" onclick="printReport()" class="btn-print">Print Report</button>
                        <button type="button" onclick="exportReport()" class="btn-export">Export Report</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Success or Error message -->
        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert <?php echo $this->session->flashdata('message_type'); ?>">
                <?php if ($this->session->flashdata('message_type') == 'success'): ?>
                    ✅ <?php echo $this->session->flashdata('message'); ?>
                <?php else: ?>
                    ❌ <?php echo $this->session->flashdata('message'); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Add New Purchase Button -->
        <button onclick="openModal('add')" class="btn-add-purchase">
            ➕ Add New Purchase Order
        </button>

        <!-- Table with Purchase Data -->
        <div class="table-container">
            <table id="purchasesTable">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pembelian)): ?>
                        <?php foreach ($pembelian as $purchase): ?>
                            <tr>
                                <td><span class="po-number"><?php echo htmlspecialchars($purchase->nomor_po); ?></span></td>
                                <td><?php echo htmlspecialchars($purchase->nama_supplier); ?></td>
                                <td><span class="date-text"><?php echo date('Y-m-d', strtotime($purchase->tanggal_pesan)); ?></span></td>
                                <td><span class="currency">Rp <?php echo number_format($purchase->total_harga, 0, ',', '.'); ?></span></td>
                                <td><span class="status-badge status-<?php echo $purchase->status; ?>"><?php echo ucfirst($purchase->status); ?></span></td>
                                <td><?php echo htmlspecialchars($purchase->dibuat_oleh_nama); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo site_url('index.php/pembelian/detail/' . $purchase->pembelian_id); ?>" class="btn-action btn-view" title="View Details">
                                            👁️
                                        </a>
                                        <?php if ($purchase->status == 'dipesan'): ?>
                                            <button onclick="openModal('edit', <?php echo $purchase->pembelian_id; ?>)" class="btn-action btn-edit" title="Edit Purchase">
                                                ✏️
                                            </button>
                                            <button onclick="receivePurchase(<?php echo $purchase->pembelian_id; ?>)" class="btn-action btn-receive" title="Receive Order">
                                                📦
                                            </button>
                                            <button onclick="openModal('delete', <?php echo $purchase->pembelian_id; ?>, '<?php echo htmlspecialchars($purchase->nomor_po); ?>')" class="btn-action btn-delete" title="Delete Purchase">
                                                🗑️
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                                No purchase orders found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add, Edit, Delete -->
    <div id="purchaseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title"></h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="modal-form" method="post">
                    <div id="form-fields">
                        <!-- Form fields will be inserted here by JavaScript -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn-modal btn-secondary">Cancel</button>
                <button type="submit" form="modal-form" id="modal-submit" class="btn-modal btn-primary">Submit</button>
            </div>
        </div>
    </div>

    <script>
        // Modal Elements
        const modal = document.getElementById("purchaseModal");
        const modalTitle = document.getElementById("modal-title");
        const modalSubmit = document.getElementById("modal-submit");
        const modalForm = document.getElementById("modal-form");
        const formFields = document.getElementById("form-fields");

        // Data from PHP
        const suppliers = <?php echo json_encode($suppliers); ?>;
        const produk = <?php echo json_encode($produk); ?>;

        let itemCount = 0;
        let filteredProduk = [];

        // Listen for supplier change in modal
        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'supplier_id') {
                const supplierId = e.target.value;
                if (supplierId) {
                    fetch("<?php echo site_url('index.php/pembelian/get_produk_by_supplier'); ?>", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'supplier_id=' + encodeURIComponent(supplierId)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            filteredProduk = data.produk;
                            updateAllProductDropdowns();
                        } else {
                            filteredProduk = [];
                            updateAllProductDropdowns();
                        }
                    });
                } else {
                    filteredProduk = [];
                    updateAllProductDropdowns();
                }
            }
        });

        function updateAllProductDropdowns() {
            const selects = document.querySelectorAll('#items-container select[name="produk_id[]"]');
            selects.forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="">Select Product</option>' +
                    filteredProduk.map(product =>
                        `<option value="${product.produk_id}" data-price="${product.harga_beli}">${product.nama_produk}</option>`
                    ).join('');
                // Try to restore previous value if still available
                if (currentValue) {
                    select.value = currentValue;
                }
                // Trigger price update
                updatePrice(select);
            });
        }

        // Function to open modal and populate data based on action
        function openModal(action, purchaseId = null) {
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
            itemCount = 0;

            if (action === 'add') {
                modalTitle.innerHTML = "➕ Add New Purchase Order";
                modalSubmit.innerHTML = "Create Purchase";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/pembelian/create'); ?>";
                formFields.innerHTML = `
                    <div class="form-row">
                        <div class="form-group">
                            <label for="supplier_id">Supplier *</label>
                            <select id="supplier_id" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                                ${suppliers.map(supplier => 
                                    `<option value="${supplier.supplier_id}">${supplier.nama_supplier}</option>`
                                ).join('')}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pesan">Order Date *</label>
                            <input type="date" id="tanggal_pesan" name="tanggal_pesan" required value="${new Date().toISOString().split('T')[0]}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Notes</label>
                        <textarea id="catatan" name="catatan" placeholder="Enter additional notes"></textarea>
                    </div>
                    <div class="detail-items">
                        <h4>Purchase Items</h4>
                        <button type="button" onclick="addItem()" class="btn-add-item">+ Add Item</button>
                        <div id="items-container"></div>
                    </div>
                `;
                setTimeout(() => {
                    addItem(); // Add first item by default
                }, 50);
            } else if (action === 'edit') {
                modalTitle.innerHTML = "✏️ Edit Purchase Order";
                modalSubmit.innerHTML = "Update Purchase";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/pembelian/update/'); ?>" + purchaseId;
                // Load purchase data via AJAX
                loadPurchaseData(purchaseId);
            } else if (action === 'delete') {
                modalTitle.innerHTML = "🗑️ Delete Purchase Order";
                modalSubmit.innerHTML = "Delete Purchase";
                modalSubmit.className = "btn-modal btn-danger";
                modalForm.action = "<?php echo site_url('index.php/pembelian/delete/'); ?>" + purchaseId;
                formFields.innerHTML = `
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 15px;">
                        <p style="color: #dc2626; margin: 0; font-weight: 500;">
                            ⚠️ Are you sure you want to delete this purchase order? This action cannot be undone.
                        </p>
                    </div>
                `;
            }
        }

        // Add item row
        function addItem() {
            itemCount++;
            const itemsContainer = document.getElementById('items-container');
            if (!itemsContainer) return;
            const itemRow = document.createElement('div');
            itemRow.className = 'item-row';
            itemRow.id = `item-${itemCount}`;
            itemRow.innerHTML = `
                <div class="form-group">
                    <label>Product *</label>
                    <select name="produk_id[]" required>
                        <option value="">Select Product</option>
                        ${(filteredProduk.length > 0 ? filteredProduk : produk).map(product => 
                            `<option value="${product.produk_id}" data-price="${product.harga_beli}">${product.nama_produk}</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="jumlah[]" required min="1">
                </div>
                <div class="form-group">
                    <label>Unit Price *</label>
                    <input type="number" name="harga_satuan[]" required min="0">
                </div>
                <button type="button" onclick="removeItem(${itemCount})" class="btn-remove-item">Remove</button>
            `;
            itemsContainer.appendChild(itemRow);
            // Tambahkan event agar unit price auto terisi
            const selectProduk = itemRow.querySelector('select[name="produk_id[]"]');
            const hargaInput = itemRow.querySelector('input[name="harga_satuan[]"]');
            if (selectProduk && hargaInput) {
                selectProduk.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    if (selected && selected.dataset.price) {
                        hargaInput.value = selected.dataset.price;
                    } else {
                        hargaInput.value = '';
                    }
                });
            }
        }

        // Remove item row
        function removeItem(itemId) {
            const itemRow = document.getElementById(`item-${itemId}`);
            if (itemRow) {
                itemRow.remove();
            }
        }

        // Update price when product changes
        function updatePrice(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            if (selectedOption.dataset.price) {
                const priceInput = selectElement.closest('.item-row').querySelector('input[name="harga_satuan[]"]');
                priceInput.value = selectedOption.dataset.price;
            }
        }

        // Calculate subtotal
        function calculateSubtotal(element) {
            const itemRow = element.closest('.item-row');
            const quantity = itemRow.querySelector('input[name="jumlah[]"]').value;
            const price = itemRow.querySelector('input[name="harga_satuan[]"]').value;
            
            if (quantity && price) {
                const subtotal = quantity * price;
                // You can add a subtotal display if needed
            }
        }

        // Handle form submission
        document.getElementById('modal-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const action = this.action;
            // Jika delete, langsung fetch tanpa validasi produk
            if (action.includes('delete')) {
                fetch(action, {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert(data.message || 'Error deleting purchase');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error processing request');
                });
                return;
            }
            // Validasi minimal 1 produk (untuk tambah/edit saja)
            const formData = new FormData(this);
            const produkIds = formData.getAll('produk_id[]');
            const jumlahs = formData.getAll('jumlah[]');
            const hargaSatuans = formData.getAll('harga_satuan[]');
            if (!produkIds.length || produkIds.some(v => !v) || jumlahs.some(v => !v) || hargaSatuans.some(v => !v)) {
                alert('Minimal satu produk harus dipilih dan semua field item harus diisi!');
                return;
            }
            const isUpdate = action.includes('update');
            // Convert FormData to JSON for update operation
            if (isUpdate) {
                const jsonData = {};
                formData.forEach((value, key) => {
                    if (key.includes('[]')) {
                        const baseKey = key.replace('[]', '');
                        if (!jsonData[baseKey]) {
                            jsonData[baseKey] = [];
                        }
                        jsonData[baseKey].push(value);
                    } else {
                        jsonData[key] = value;
                    }
                });
                // Debug log
                console.log('Sending JSON data:', jsonData);
                fetch(action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(jsonData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Server response:', data);
                    if (data.status === 'success') {
                        if (data.wa_url) {
                            window.open(data.wa_url, '_blank');
                        } else {
                        location.reload();
                        }
                    } else {
                        alert(data.message || 'Error updating purchase');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error processing request');
                });
            } else {
                // Handle create and delete operations as before
                fetch(action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.wa_url) {
                            window.open(data.wa_url, '_blank');
                        } else {
                        location.reload();
                        }
                    } else {
                        alert(data.message || 'Error processing request');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error processing request');
                });
            }
        });

        // Function to load purchase data for editing
        function loadPurchaseData(purchaseId) {
            fetch(`<?php echo site_url('index.php/pembelian/get_data/'); ?>${purchaseId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const purchase = data.data.pembelian;
                        const details = data.data.detail;
                        formFields.innerHTML = `
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier *</label>
                                    <select id="supplier_id" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                        ${suppliers.map(supplier => 
                                            `<option value="${supplier.supplier_id}" ${supplier.supplier_id == purchase.supplier_id ? 'selected' : ''}>${supplier.nama_supplier}</option>`
                                        ).join('')}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_pesan">Order Date *</label>
                                    <input type="date" id="tanggal_pesan" name="tanggal_pesan" required value="${purchase.tanggal_pesan}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="catatan">Notes</label>
                                <textarea id="catatan" name="catatan" placeholder="Enter additional notes">${purchase.catatan || ''}</textarea>
                            </div>
                            <div class="detail-items">
                                <h4>Purchase Items</h4>
                                <button type="button" onclick="addItem()" class="btn-add-item">+ Add Item</button>
                                <div id="items-container"></div>
                            </div>
                        `;
                        // Ambil produk dari supplier terkait
                        fetch("<?php echo site_url('index.php/pembelian/get_produk_by_supplier'); ?>", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'supplier_id=' + encodeURIComponent(purchase.supplier_id)
                        })
                        .then(res => res.json())
                        .then(prodData => {
                            if (prodData.status === 'success') {
                                filteredProduk = prodData.produk;
                            } else {
                                filteredProduk = [];
                            }
                            // Add existing items pakai produk hasil filter
                            details.forEach(detail => {
                                addExistingItem(detail);
                            });
                        });
                    } else {
                        alert('Failed to load purchase data');
                    }
                })
                .catch(error => {
                    console.error('Error loading purchase data:', error);
                    alert('Error loading purchase data');
                });
        }

        function addExistingItem(detail) {
            itemCount++;
            const itemsContainer = document.getElementById('items-container');
            const itemRow = document.createElement('div');
            itemRow.className = 'item-row';
            itemRow.id = `item-${itemCount}`;
            itemRow.innerHTML = `
                <div class="form-group">
                    <label>Product *</label>
                    <select name="produk_id[]" required onchange="updatePrice(this)">
                        <option value="">Select Product</option>
                        ${(filteredProduk.length > 0 ? filteredProduk : produk).map(product => 
                            `<option value="${product.produk_id}" data-price="${product.harga_beli}" ${product.produk_id == detail.produk_id ? 'selected' : ''}>${product.nama_produk}</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="jumlah[]" required min="1" value="${detail.jumlah}" onchange="calculateSubtotal(this)">
                </div>
                <div class="form-group">
                    <label>Unit Price *</label>
                    <input type="number" name="harga_satuan[]" required min="0" value="${detail.harga_satuan}" onchange="calculateSubtotal(this)">
                </div>
                <button type="button" onclick="removeItem(${itemCount})" class="btn-remove-item">Remove</button>
            `;
            itemsContainer.appendChild(itemRow);
        }

        function receivePurchase(id) {
            if (confirm('Are you sure you want to mark this purchase as received? This will update the product stock.')) {
                fetch(`<?php echo site_url('index.php/pembelian/terima/'); ?>${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error processing receive order:', error);
                    alert('Error processing receive order');
                });
            }
        }

        function closeModal() {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }

        function resetFilter() {
            // Kosongkan semua input filter
            document.getElementById('date_start').value = '';
            document.getElementById('date_end').value = '';
            document.getElementById('supplier').value = '';
            document.getElementById('status').value = '';
            // Reload halaman tanpa parameter GET
            window.location.href = "<?php echo site_url('index.php/pembelian/pembelian'); ?>";
        }

        function exportReport() {
            const dateStart = document.getElementById('date_start').value;
            const dateEnd = document.getElementById('date_end').value;
            const supplier = document.getElementById('supplier').value;
            const status = document.getElementById('status').value;

            let url = "<?php echo site_url('index.php/pembelian/export'); ?>?";
            url += "date_start=" + encodeURIComponent(dateStart);
            url += "&date_end=" + encodeURIComponent(dateEnd);
            url += "&supplier=" + encodeURIComponent(supplier);
            url += "&status=" + encodeURIComponent(status);

            window.open(url, '_blank');
        }

        function printReport() {
            const dateStart = document.getElementById('date_start').value;
            const dateEnd = document.getElementById('date_end').value;
            const supplier = document.getElementById('supplier').value;
            const status = document.getElementById('status').value;

            let url = "<?php echo site_url('index.php/pembelian/print'); ?>?";
            url += "date_start=" + encodeURIComponent(dateStart);
            url += "&date_end=" + encodeURIComponent(dateEnd);
            url += "&supplier=" + encodeURIComponent(supplier);
            url += "&status=" + encodeURIComponent(status);

            window.open(url, '_blank');
        }

        // Pastikan fungsi tersedia di global scope
        window.openModal = openModal;
        window.addItem = addItem;
        window.removeItem = removeItem;
        window.loadPurchaseData = loadPurchaseData;
        window.addExistingItem = addExistingItem;
        window.receivePurchase = receivePurchase;
        window.closeModal = closeModal;
        window.updatePrice = updatePrice;
        window.calculateSubtotal = calculateSubtotal;
        window.resetFilter = resetFilter;
        window.exportReport = exportReport;
        window.printReport = printReport;
    </script>
</body>
</html>