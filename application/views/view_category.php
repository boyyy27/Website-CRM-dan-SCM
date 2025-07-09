<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Category Management - ZE Vapestore</title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/Fkx7FzKJ/Pngtree-vape-device-8133386.png" />
    
    <style>
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
            background-color: #f9fafb;
            font-weight: 600;
            color: rgb(255, 255, 255);
        }
        
        tr:hover {
            background-color: #f9fafb;
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

        /* Add button */
       
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
            margin: 5% auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: modalSlideIn 0.3s ease-out;
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
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-group input[readonly] {
            background-color: #f9fafb;
            color: #6b7280;
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

        /* Description cell styling */
        .description-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .description-full {
            white-space: normal;
            word-wrap: break-word;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 2% auto;
            }
            
            .description-cell {
                max-width: 150px;
            }
        }
    </style>
</head>

<body>

    <div class="main-content">

        <div class="content-header">
            <h1>Category Management</h1>
            <p>Manage your product categories and descriptions</p>
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

        <!-- Add New Category Button -->
        <button onclick="openModal('add')" class="btn-add-category">
            ➕ Add New Category
        </button>

        <!-- Table with Categories Data -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo $category['kategori_id']; ?></td>
                                <td><?php echo htmlspecialchars($category['nama_kategori']); ?></td>
                                <td class="description-cell" title="<?php echo htmlspecialchars($category['deskripsi']); ?>">
                                    <?php echo htmlspecialchars($category['deskripsi'] ? $category['deskripsi'] : '-'); ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button
                                            onclick="openModal('edit', <?php echo $category['kategori_id']; ?>, '<?php echo htmlspecialchars($category['nama_kategori']); ?>', '<?php echo htmlspecialchars($category['deskripsi']); ?>')"
                                            class="btn-action btn-edit" title="Edit Category">
                                            ✏️
                                        </button>
                                        <button
                                            onclick="openModal('delete', <?php echo $category['kategori_id']; ?>, '<?php echo htmlspecialchars($category['nama_kategori']); ?>')"
                                            class="btn-action btn-delete" title="Delete Category">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #6b7280;">
                                No categories found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add, Edit, Delete -->
    <div id="categoryModal" class="modal">
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
        const modal = document.getElementById("categoryModal");
        const modalTitle = document.getElementById("modal-title");
        const modalSubmit = document.getElementById("modal-submit");
        const modalForm = document.getElementById("modal-form");
        const formFields = document.getElementById("form-fields");

        // Function to open modal and populate data based on action
        function openModal(action, categoryId = null, namaKategori = '', deskripsi = '') {
            modal.style.display = "block";
            document.body.style.overflow = "hidden";

            if (action === 'add') {
                modalTitle.innerHTML = "➕ Add New Category";
                modalSubmit.innerHTML = "Add Category";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Category/store'); ?>";

                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="nama_kategori">Category Name *</label>
                        <input type="text" id="nama_kategori" name="nama_kategori" required placeholder="Enter category name">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Description</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Enter category description"></textarea>
                    </div>
                `;
            } else if (action === 'edit') {
                modalTitle.innerHTML = "✏️ Edit Category";
                modalSubmit.innerHTML = "Update Category";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Category/update/'); ?>" + categoryId;

                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="nama_kategori">Category Name *</label>
                        <input type="text" id="nama_kategori" name="nama_kategori" required placeholder="Enter category name" value="${namaKategori}">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Description</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Enter category description">${deskripsi}</textarea>
                    </div>
                `;
            } else if (action === 'delete') {
                modalTitle.innerHTML = "🗑️ Delete Category";
                modalSubmit.innerHTML = "Delete Category";
                modalSubmit.className = "btn-modal btn-danger";
                modalForm.action = "<?php echo site_url('index.php/Category/delete/'); ?>" + categoryId;

                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="nama_kategori">Category Name</label>
                        <input type="text" id="nama_kategori" name="nama_kategori" value="${namaKategori}" readonly>
                    </div>
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 15px; margin-top: 15px;">
                        <p style="color: #dc2626; margin: 0; font-weight: 500;">
                            ⚠️ Are you sure you want to delete this category? This action cannot be undone.
                        </p>
                    </div>
                `;
            }

            // Focus first input field
            setTimeout(() => {
                const firstInput = formFields.querySelector('input:not([readonly]), textarea');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        // Close modal
        function closeModal() {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
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
    </script>

</body>

</html>