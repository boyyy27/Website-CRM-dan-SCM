<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Product Management - ZE Vapestore</title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/Fkx7FzKJ/Pngtree-vape-device-8133386.png" />
    
    <style>
        /* Product image styling */
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            transition: transform 0.2s ease;
            cursor: pointer;
        }
        
        .product-image:hover {
            transform: scale(1.5);
            z-index: 10;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Table cell styling for image column */
        .image-cell {
            width: 70px;
            text-align: center;
            padding: 8px !important;
        }
        
        /* Basic table styling (add this if you don't have existing table styles) */
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
            background-color: #f9fafb;
            font-weight: 600;
            color:rgb(255, 255, 255);
        }
        
        tr:hover {
            background-color: #f9fafb;
        }
        
        /* Status badges */
        .status-active {
            color: #059669;
            background-color: #d1fae5;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-inactive {
            color: #dc2626;
            background-color: #fee2e2;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-action {
            background: none;
            border: none;
            padding: 6px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s ease;
        }
        
        .btn-action:hover {
            background-color: #f3f4f6;
        }
        
        .btn-edit:hover {
            background-color: #dbeafe;
        }
        
        .btn-delete:hover {
            background-color: #fee2e2;
        }
        
        /* Basic styling for other elements */
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* Remove any pseudo-elements that might cause purple background */
        *::before,
        *::after {
            background: none !important;
        }
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .form-group {
            flex: 1;
        }
        
        .form-group.full-width {
            width: 100%;
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
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-group input[readonly] {
            background-color: #f9fafb;
            color: #6b7280;
        }

        /* Styling for auto-generated fields */
        .form-group input[readonly] {
            background-color: #f3f4f6;
            color: #374151;
            border-color: #d1d5db;
            cursor: not-allowed;
        }

        .form-group input[readonly]:focus {
            border-color: #d1d5db;
            box-shadow: none;
        }

        /* Styling for stock field */
        .form-group input[type="number"] {
            transition: all 0.2s ease;
        }

        .form-group input[type="number"]:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Helper text styling */
        .form-group small {
            display: block;
            margin-top: 4px;
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.4;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 1000px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-header h2 {
            margin: 0;
            color: #1f2937;
            font-size: 1.5rem;
        }

        .close {
            color: #6b7280;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #1f2937;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-modal {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* Form Styles */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group.full-width {
            width: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input[readonly] {
            background-color: #f9fafb;
            color: #6b7280;
        }
    </style>
</head>

<body>

    <div class="main-content">

        <div class="content-header">
            <h1>Product Management</h1>
            <p>Manage your products, categories, and prices</p>
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

        <!-- Add New Product Button -->
        <button onclick="openModal('add')" class="btn-add-product">
            ➕ Add New Product
        </button>

        <!-- Table with Products Data -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Buy Price</th>
                        <th>Sell Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($produk)): ?>
                        <?php foreach ($produk as $product): ?>
                            <tr>
                                <td class="image-cell">
                                    <?php if (!empty($product['gambar'])): ?>
                                        <img src="<?php echo base_url('assets/uploads/' . $product['gambar']); ?>"
                                            alt="Product Image" class="product-image" title="<?php echo htmlspecialchars($product['nama_produk']); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo base_url('assets/img/no-image.png'); ?>" alt="No Image"
                                            class="product-image" title="No Image Available">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($product['kode_produk']); ?></td>
                                <td><?php echo htmlspecialchars($product['nama_produk']); ?></td>
                                <td><?php echo htmlspecialchars($product['nama_kategori']); ?></td>
                                <td><?php echo htmlspecialchars($product['nama_supplier']); ?></td>
                                <td>Rp <?php echo number_format($product['harga_beli'], 0, ',', '.'); ?></td>
                                <td>Rp <?php echo number_format($product['harga_jual'], 0, ',', '.'); ?></td>
                                <td><?php echo $product['jumlah_stok']; ?></td>
                                <td>
                                    <span
                                        class="<?php echo $product['status'] == 'aktif' ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $product['status'] == 'aktif' ? '● Active' : '● Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button
                                            onclick="openModal('edit', <?php echo $product['produk_id']; ?>, '<?php echo htmlspecialchars($product['kode_produk']); ?>', '<?php echo htmlspecialchars($product['nama_produk']); ?>', '<?php echo $product['kategori_id']; ?>', '<?php echo $product['supplier_id']; ?>', <?php echo $product['harga_beli']; ?>, <?php echo $product['harga_jual']; ?>, <?php echo $product['jumlah_stok']; ?>, '<?php echo htmlspecialchars($product['deskripsi']); ?>', '<?php echo $product['status']; ?>', '<?php echo $product['gambar']; ?>')"
                                            class="btn-action btn-edit" title="Edit Product">
                                            ✏️
                                        </button>
                                        <button
                                            onclick="openModal('delete', <?php echo $product['produk_id']; ?>, '<?php echo htmlspecialchars($product['nama_produk']); ?>')"
                                            class="btn-action btn-delete" title="Delete Product">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 2rem; color: #6b7280;">
                                No products found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add, Edit, Delete -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title"></h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="modal-form" method="post" enctype="multipart/form-data">
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
        const modal = document.getElementById("productModal");
        const modalTitle = document.getElementById("modal-title");
        const modalSubmit = document.getElementById("modal-submit");
        const modalForm = document.getElementById("modal-form");
        const formFields = document.getElementById("form-fields");

        // Function to open modal and populate data based on action
        function openModal(action, productId = null, kode = '', nama = '', kategoriId = 0, supplierId = 0, hargaBeli = 0, hargaJual = 0, stokMin = 0, deskripsi = '', status = 'aktif', gambar = '') {
            modal.style.display = "block";
            document.body.style.overflow = "hidden";

            if (action === 'add') {
                modalTitle.innerHTML = "➕ Add New Product";
                modalSubmit.innerHTML = "Add Product";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Produk/store'); ?>";

                formFields.innerHTML = `
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kode_produk">Product Code *</label>
                            <input type="text" id="kode_produk" name="kode_produk" required placeholder="Select category to auto-generate" readonly>
                            <small style="color: #6b7280; font-size: 0.875rem; margin-top: 4px; display: block;">Product code will be automatically generated based on the selected category</small>
                        </div>
                        <div class="form-group">
                            <label for="nama_produk">Product Name *</label>
                            <input type="text" id="nama_produk" name="nama_produk" required placeholder="Enter product name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kategori_id">Category *</label>
                             <select id="kategori_id" name="kategori_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['kategori_id']; ?>"><?php echo htmlspecialchars($category['nama_kategori']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select id="supplier_id" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo htmlspecialchars($supplier['nama_supplier']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="harga_beli">Buy Price *</label>
                            <input type="number" id="harga_beli" name="harga_beli" required placeholder="0" min="0">
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Sell Price *</label>
                            <input type="number" id="harga_jual" name="harga_jual" required placeholder="0" min="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jumlah_stok">Stock *</label>
                            <input type="number" id="jumlah_stok" name="jumlah_stok" required placeholder="0" min="0" value="0">
                            <small style="color: #6b7280; font-size: 0.875rem; margin-top: 4px; display: block;">Default stock is 0, you can change this value</small>
                        </div>
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select id="status" name="status" required>
                                <option value="aktif">Active</option>
                                <option value="nonaktif">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="deskripsi">Description</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Enter product description"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="gambar">Product Image *</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                `;
                
                // Setup category listener for add modal
                setTimeout(() => {
                    setupCategoryListeners();
                    // Ensure stock field is set to 0 for new products
                    const stockField = document.getElementById('jumlah_stok');
                    if (stockField) {
                        stockField.value = '0';
                    }
                }, 100);
            } else if (action === 'edit') {
                modalTitle.innerHTML = "✏️ Edit Product";
                modalSubmit.innerHTML = "Update Product";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Produk/update/'); ?>" + productId;

                formFields.innerHTML = `
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kode_produk">Product Code *</label>
                            <input type="text" id="kode_produk" name="kode_produk" required placeholder="Enter product code" value="${kode}">
                        </div>
                        <div class="form-group">
                            <label for="nama_produk">Product Name *</label>
                            <input type="text" id="nama_produk" name="nama_produk" required placeholder="Enter product name" value="${nama}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kategori_id">Category *</label>
                            <select id="kategori_id" name="kategori_id" required>
                                <option value="">Select Category</option>
                                <?php if (isset($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['kategori_id']; ?>"><?php echo htmlspecialchars($category['nama_kategori']); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select id="supplier_id" name="supplier_id">
                                <option value="">Select Supplier</option>
                                <?php if (isset($suppliers)): ?>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo htmlspecialchars($supplier['nama_supplier']); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="harga_beli">Buy Price *</label>
                            <input type="number" id="harga_beli" name="harga_beli" required placeholder="0" min="0" value="${hargaBeli}">
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Sell Price *</label>
                            <input type="number" id="harga_jual" name="harga_jual" required placeholder="0" min="0" value="${hargaJual}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jumlah_stok">Stock *</label>
                            <input type="number" id="jumlah_stok" name="jumlah_stok" required placeholder="0" min="0" value="${stokMin}">
                        </div>
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select id="status" name="status" required>
                                <option value="aktif" ${status === 'aktif' ? 'selected' : ''}>Active</option>
                                <option value="nonaktif" ${status === 'nonaktif' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="deskripsi">Description</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Enter product description">${deskripsi}</textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="gambar">Product Image</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*">
                        ${gambar ? `<small style="color: #6b7280; margin-top: 5px; display: block;">Current image: ${gambar}</small>` : ''}
                    </div>
                `;

                // Set selected values for dropdowns
                setTimeout(() => {
                    document.getElementById('kategori_id').value = kategoriId;
                    document.getElementById('supplier_id').value = supplierId;
                }, 10);
            } else if (action === 'delete') {
                modalTitle.innerHTML = "🗑️ Delete Product";
                modalSubmit.innerHTML = "Delete Product";
                modalSubmit.className = "btn-modal btn-danger";
                modalForm.action = "<?php echo site_url('index.php/Produk/delete/'); ?>" + productId;

                formFields.innerHTML = `
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kode_produk">Nama Product</label>
                            <input type="text" id="kode_produk" name="kode_produk" value="${kode}" readonly>
                        </div>
                       
                    </div>
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 15px; margin-top: 15px;">
                        <p style="color: #dc2626; margin: 0; font-weight: 500;">
                            ⚠️ Are you sure you want to delete this product? This action cannot be undone.
                        </p>
                    </div>
                `;
            }

            // Focus first input field
            setTimeout(() => {
                const firstInput = formFields.querySelector('input:not([readonly]), select, textarea');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close modal
        function closeModal() {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
            
            // Reset form fields when modal is closed
            if (modalForm) {
                modalForm.reset();
            }
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        }

        // Handle escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Function to generate product code when category is selected
        function generateProductCode(kategoriId, productCodeInput) {
            if (!kategoriId) {
                productCodeInput.value = '';
                return;
            }

            // Show loading state
            productCodeInput.value = 'Generating...';
            productCodeInput.disabled = true;

            // Make AJAX request to generate product code
            fetch('<?php echo site_url('index.php/Produk/generate_product_code'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'kategori_id=' + kategoriId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    productCodeInput.value = data.product_code;
                } else {
                    productCodeInput.value = '';
                    console.error('Error generating product code:', data.error);
                }
                productCodeInput.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                productCodeInput.value = '';
                productCodeInput.disabled = false;
            });
        }

        // Add event listeners for category selection in add modal
        function setupCategoryListeners() {
            const kategoriSelect = document.getElementById('kategori_id');
            const productCodeInput = document.getElementById('kode_produk');
            const stockField = document.getElementById('jumlah_stok');
            
            if (kategoriSelect && productCodeInput) {
                kategoriSelect.addEventListener('change', function() {
                    generateProductCode(this.value, productCodeInput);
                });
            }
            
            // Ensure stock field is properly set for new products
            if (stockField && stockField.value === '') {
                stockField.value = '0';
            }
            
            // Add validation for stock field
            if (stockField) {
                stockField.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            }
        }
    </script>

</body>

</html>