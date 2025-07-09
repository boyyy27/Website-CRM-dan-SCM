
<title>Roles Management - ZE Vapestore</title>

   <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="content-header">
            <h1>Role Management</h1>
            <p>Manage user roles, permissions, and access levels</p>
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

        <!-- Add New User Button -->
        <button onclick="openModal('add')" class="btn-add-user">
            ➕ Add New User
        </button>

        <!-- Table with Users Data -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user->user_id; ?></td>
                                <td><?php echo htmlspecialchars($user->username); ?></td>
                                <td><?php echo htmlspecialchars($user->nama_lengkap ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($user->email ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($user->telepon ?? '-'); ?></td>
                                <td>
                                    <span class="role-badge role-<?php echo strtolower($user->role); ?>">
                                        <?php echo ucfirst($user->role); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?php echo $user->status == 'aktif' ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $user->status == 'aktif' ? '● Active' : '● Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button onclick="openModal('update', <?php echo $user->user_id; ?>, '<?php echo htmlspecialchars($user->username); ?>', '<?php echo htmlspecialchars($user->nama_lengkap ?? ''); ?>', '<?php echo htmlspecialchars($user->email ?? ''); ?>', '<?php echo htmlspecialchars($user->telepon ?? ''); ?>', '<?php echo $user->role; ?>', '<?php echo $user->status; ?>')" class="btn-action btn-edit" title="Edit User">
                                            ✏️
                                        </button>
                                        <button onclick="openModal('delete', <?php echo $user->user_id; ?>, '<?php echo htmlspecialchars($user->username); ?>')" class="btn-action btn-delete" title="Delete User">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">
                                No users found
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

    <script>
        let modal = document.getElementById("modal");
        let modalTitle = document.getElementById("modal-title");
        let modalSubmit = document.getElementById("modal-submit");
        let modalForm = document.getElementById("modal-form");
        let formFields = document.getElementById("form-fields");

        function openModal(action, userId = null, username = '', namaLengkap = '', email = '', telepon = '', role = '', status = '') {
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
            
            if (action === 'add') {
                modalTitle.innerHTML = "➕ Add New User";
                modalSubmit.innerHTML = "Add User";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Dashboard/create_user'); ?>";
                
                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" name="username" required placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Full Name</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Enter full name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Phone</label>
                        <input type="text" id="telepon" name="telepon" placeholder="Enter phone number">
                    </div>
                    <div class="form-group">
                        <label for="role">Role *</label>
                        <select id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="aktif">Active</option>
                            <option value="nonaktif">Inactive</option>
                        </select>
                    </div>
                `;
                
            } else if (action === 'update') {
                modalTitle.innerHTML = "✏️ Update User";
                modalSubmit.innerHTML = "Update User";
                modalSubmit.className = "btn-modal btn-primary";
                modalForm.action = "<?php echo site_url('index.php/Dashboard/update_user/'); ?>" + userId;
                
                formFields.innerHTML = `
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="${username}" readonly style="background: #f3f4f6; color: #6b7280;">
                    </div>
                    <div class="form-group">
                        <label for="role">Role *</label>
                        <select id="role" name="role" required>
                            <option value="admin" ${role === 'admin' ? 'selected' : ''}>Admin</option>
                            <option value="kasir" ${role === 'kasir' ? 'selected' : ''}>Kasir</option>
                            <option value="owner" ${role === 'owner' ? 'selected' : ''}>Owner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="aktif" ${status === 'aktif' ? 'selected' : ''}>Active</option>
                            <option value="nonaktif" ${status === 'nonaktif' ? 'selected' : ''}>Inactive</option>
                        </select>
                    </div>
                `;
                
            } else if (action === 'delete') {
                modalTitle.innerHTML = "🗑️ Delete User";
                modalSubmit.innerHTML = "Delete User";
                modalSubmit.className = "btn-modal btn-danger";
                modalForm.action = "<?php echo site_url('index.php/Dashboard/delete_user/'); ?>" + userId;
                
                formFields.innerHTML = `
                    <div class="delete-confirmation">
                        <span class="delete-icon">⚠️</span>
                        <div class="delete-text">Are you sure you want to delete this user?</div>
                        <div class="delete-username">${username}</div>
                        <p style="color: #6b7280; margin-top: 1rem; font-size: 0.9rem;">This action cannot be undone.</p>
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
</script>
       