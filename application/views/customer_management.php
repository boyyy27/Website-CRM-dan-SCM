<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management - ZE Vapestore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
       

      
        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert.success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: 1px solid #047857;
        }

        .alert.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: 1px solid #b91c1c;
        }

        /* Add Button */
        .btn-add-customer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .btn-add-customer:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4);
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        /* Status Badges */
        .status-active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-inactive {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            margin: 2% auto;
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .close {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .close:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn-modal {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-modal:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Delete Confirmation */
        .delete-confirmation {
            text-align: center;
            padding: 2rem 1rem;
        }

        .delete-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }

        .delete-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .delete-customer {
            font-size: 1.1rem;
            color: #ef4444;
            font-weight: 600;
            margin-bottom: 1rem;
        }


    </style>
</head>
<body>
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="content-header">
            <h1>Member Management</h1>
            <p>Manage customers, profiles, and account information</p>
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

        <!-- Add New Customer Button -->
        <button onclick="openModal('add')" class="btn-add-customer">
            ➕ Add New Member
        </button>

        <!-- Table with Customers Data -->
        <div class="table-container">
            <table id="customersTable">
                <thead>
                    <tr>
                        <th>Member Code</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($customer->kode_customer); ?></td>
                                <td><?php echo htmlspecialchars($customer->nama_lengkap); ?></td>
                                <td><?php echo htmlspecialchars($customer->username); ?></td>
                                <td><?php echo htmlspecialchars($customer->email); ?></td>
                                <td><?php echo !empty($customer->telepon) ? htmlspecialchars($customer->telepon) : '<span style="color: #6b7280;">No Phone</span>'; ?></td>
                                <td>
                                    <span class="<?php echo $customer->status == 'aktif' ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $customer->status == 'aktif' ? '● Active' : '● Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button onclick="openModal('update', <?php echo $customer->customer_id; ?>, '<?php echo htmlspecialchars($customer->kode_customer); ?>', '<?php echo htmlspecialchars($customer->nama_lengkap); ?>', '<?php echo htmlspecialchars($customer->username); ?>', '<?php echo htmlspecialchars($customer->email); ?>', '<?php echo htmlspecialchars($customer->telepon ?? ''); ?>', '<?php echo htmlspecialchars($customer->alamat ?? ''); ?>', '<?php echo $customer->tanggal_lahir; ?>', '<?php echo $customer->jenis_kelamin; ?>', '<?php echo $customer->status; ?>')" class="btn-action btn-edit" title="Edit Customer">
                                            ✏️
                                        </button>
                                        <button onclick="openModal('delete', <?php echo $customer->customer_id; ?>, '<?php echo htmlspecialchars($customer->nama_lengkap); ?>')" class="btn-action btn-delete" title="Delete Customer">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                                No Members found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add, Update, Delete -->
    <div id="modal" class="modal">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#customersTable').DataTable({
                "pageLength": 10,
                "order": [[0, "asc"]],
                "responsive": true
            });
        });

        let modal = document.getElementById("modal");
        let modalTitle = document.getElementById("modal-title");
        let modalSubmit = document.getElementById("modal-submit");
        let modalForm = document.getElementById("modal-form");
        let formFields = document.getElementById("form-fields");

        function openModal(action, customerId = null, kodeCustomer = '', namaLengkap = '', username = '', email = '', telepon = '', alamat = '', tanggalLahir = '', jenisKelamin = '', status = '') {
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
            
            if (action === 'add') {
                modalTitle.innerHTML = "➕ Add New Customer";
                modalSubmit.innerHTML = "Add Customer";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Dashboard/save_customer'); ?>";
                
                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="nama_lengkap">Full Name *</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" required placeholder="Enter customer full name">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required placeholder="Enter email address">
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Phone *</label>
                        <input type="text" id="telepon" name="telepon" required placeholder="Enter phone number">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Address</label>
                        <input type="text" id="alamat" name="alamat" placeholder="Enter full address">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Birth Date</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Gender</label>
                        <select id="jenis_kelamin" name="jenis_kelamin">
                            <option value="pria">Male</option>
                            <option value="wanita">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="aktif">Active</option>
                            <option value="nonaktif">Inactive</option>
                        </select>
                    </div>
                `;
                
            } else if (action === 'update') {
                modalTitle.innerHTML = "✏️ Update Customer";
                modalSubmit.innerHTML = "Update Customer";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Dashboard/save_customer'); ?>";
                
                formFields.innerHTML = `
                    <input type="hidden" name="customer_id" value="${customerId}">
                    <div class="form-group">
                        <label for="kode_customer">Customer Code</label>
                        <input type="text" id="kode_customer" value="${kodeCustomer}" readonly style="background: #f3f4f6; color: #6b7280;">
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Full Name *</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="${namaLengkap}" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="${username}" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="${email}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (Leave empty to keep current password)</label>
                        <input type="password" id="password" name="password" placeholder="Leave empty to keep current password">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Phone *</label>
                        <input type="text" id="telepon" name="telepon" value="${telepon}" required placeholder="Enter phone number">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Address</label>
                        <input type="text" id="alamat" name="alamat" value="${alamat}" placeholder="Enter full address">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Birth Date</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="${tanggalLahir}">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Gender</label>
                        <select id="jenis_kelamin" name="jenis_kelamin">
                            <option value="pria" ${jenisKelamin === 'pria' ? 'selected' : ''}>Male</option>
                            <option value="wanita" ${jenisKelamin === 'wanita' ? 'selected' : ''}>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="aktif" ${status === 'aktif' ? 'selected' : ''}>Active</option>
                            <option value="nonaktif" ${status === 'nonaktif' ? 'selected' : ''}>Inactive</option>
                        </select>
                    </div>
                `;
                
            } else if (action === 'delete') {
                modalTitle.innerHTML = "🗑️ Delete Customer";
                modalSubmit.innerHTML = "Delete Customer";
                modalSubmit.className = "btn-modal btn-danger";
                modalForm.action = "<?php echo site_url('index.php/Dashboard/delete_customer/'); ?>" + customerId;
                
                formFields.innerHTML = `
                    <div class="delete-confirmation">
                        <span class="delete-icon">⚠️</span>
                        <div class="delete-text">Are you sure you want to delete this customer?</div>
                        <div class="delete-customer">${namaLengkap}</div>
                        <p style="color: #6b7280; margin-top: 1rem; font-size: 0.9rem;">This action cannot be undone and will remove all customer data.</p>
                    </div>
                `;
            }
            
            // Focus first input
            setTimeout(() => {
                const firstInput = formFields.querySelector('input:not([readonly]), select');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        function closeModal() {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.style.display === 'block') {
                closeModal();
            }
        });
    </script>
</body>
</html>