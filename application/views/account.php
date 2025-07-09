<link rel="icon" type="image/png" href="https://i.ibb.co/whrNy6j6/Pngtree-vape-device-8133386.png" />

<title>Account - ZE Vapestore</title>   

<div class="main-content">
    <div style="max-width: 1100px; margin: 0 auto;">
        <div class="content-header" style="display: flex; align-items: center; justify-content: space-between;">
            <h1>Settings</h1>
            <a href="<?php echo base_url(); ?>" style="background-color: #1a73e8; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer;">&larr; Back</a>
        </div>
        <p>Manage your account settings and preferences</p>
        <div style="display: flex; gap: 20px;">
            <!-- Sidebar menu -->
            <nav style="min-width: 220px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
                <ul style="list-style: none; padding: 0; margin: 0; font-weight: 600; color: #666;">
                    <li style="margin-bottom: 12px;">
                        <a href="#" style="color: #1a73e8; font-weight: 700; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px; background-color: #e8f0fe;">Account</a>
                    </li>
                    <li style="margin-bottom: 12px;"><a href="<?php echo base_url('index.php/account/change_password'); ?>" style="color: #666; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">Change Password</a></li>
                    <li style="margin-bottom: 12px;">
                        <a href="<?php echo base_url('index.php/history_pembelian'); ?>" style="color: #666; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">
                            History Pembelian
                        </a>
                    </li>
                    <li style="margin-top: 20px;">
                        <a href="<?php echo base_url('index.php/Auth/logout'); ?>" style="color: #d93025; font-weight: 700; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">Logout</a>
                    </li>
                </ul>
            </nav>

            <!-- Main content -->
            <div style="flex-grow: 1; background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 12px rgba(0,0,0,0.1); position: relative;">
                <!-- Loyalty Point Badge di kanan atas -->
                <?php if (isset($user->poin_loyalty)): ?>
                <div style="position: absolute; top: 24px; right: 32px; z-index: 2;">
                    <div style="display: flex; align-items: center; gap: 8px; background: linear-gradient(90deg, #f8fafc 60%, #e0e7ff 100%); border-radius: 24px; box-shadow: 0 2px 8px rgba(99,102,241,0.08); padding: 8px 18px;">
                        <svg width="22" height="22" fill="none" viewBox="0 0 32 32" style="flex-shrink:0;"><circle cx="16" cy="16" r="16" fill="#6366f1"/><path d="M16 8l2.472 5.01 5.528.803-4 3.9.944 5.507L16 20.2l-4.944 2.02.944-5.507-4-3.9 5.528-.803L16 8z" fill="#fff"/></svg>
                        <span style="font-weight:700;font-size:1.08rem;color:#6366f1;letter-spacing:0.5px;">Loyalty: <?= number_format($user->poin_loyalty) ?></span>
                    </div>
                </div>
                <?php endif; ?>
                <h3 style="font-weight: 700; font-size: 20px; margin-bottom: 20px; color: #222;">Account</h3>
                <form method="post" action="<?php echo site_url('index.php/account/update_account'); ?>" enctype="multipart/form-data">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert success"><?php echo $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert error"><?php echo $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    <?php echo validation_errors('<div class="alert error">', '</div>'); ?>
                    <!-- Avatar -->
                    <div style="display: flex; align-items: center; margin-bottom: 25px;">
                        <div>
                            <?php if (!empty($user->foto)): ?>
                                <img src="<?php echo base_url('assets/uploads/' . $user->foto); ?>" alt="Avatar" style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; margin-right: 20px; border: 1px solid #ddd;">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user->nama_lengkap ?? 'User'); ?>&background=6366f1&color=fff&size=72" alt="Avatar" style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; margin-right: 20px; border: 1px solid #ddd;">
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="foto" style="font-weight:600;">Upload Foto</label><br>
                            <input type="file" id="foto" name="foto" accept="image/*" style="margin-top:8px;">
                            <small style="color:#64748b;display:block;">Format: jpg, jpeg, png. Maksimal 2MB.</small>
                        </div>
                    </div>

                    <!-- Full name -->
                    <div style="margin-bottom: 20px;">
                        <label for="nama_lengkap" style="font-weight: 600; color: #444;">Nama Lengkap</label><br>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo set_value('nama_lengkap', isset($user->nama_lengkap) ? $user->nama_lengkap : ''); ?>" placeholder="Masukkan nama lengkap" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <!-- Username -->
                    <div style="margin-bottom: 20px;">
                        <label for="username" style="font-weight: 600; color: #444;">Username</label><br>
                        <input type="text" id="username" name="username" value="<?php echo set_value('username', isset($user->username) ? $user->username : ''); ?>" placeholder="Masukkan username" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <!-- Email -->
                    <div style="margin-bottom: 20px;">
                        <label for="email" style="font-weight: 600; color: #444;">Email</label><br>
                        <input type="email" id="email" name="email" value="<?php echo set_value('email', isset($user->email) ? $user->email : ''); ?>" placeholder="Masukkan email" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <!-- Phone -->
                    <div style="margin-bottom: 20px;">
                        <label for="telepon" style="font-weight: 600; color: #444;">Telepon</label><br>
                        <input type="tel" id="telepon" name="telepon" value="<?php echo set_value('telepon', isset($user->telepon) ? $user->telepon : ''); ?>" placeholder="Masukkan nomor telepon" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <!-- Address -->
                    <div style="margin-bottom: 20px;">
                        <label for="alamat" style="font-weight: 600; color: #444;">Alamat</label><br>
                        <textarea id="alamat" name="alamat" placeholder="Masukkan alamat" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;"><?php echo set_value('alamat', isset($user->alamat) ? $user->alamat : ''); ?></textarea>
                    </div>

                    <!-- Date of Birth -->
                    <div style="margin-bottom: 20px;">
                        <label for="tanggal_lahir" style="font-weight: 600; color: #444;">Tanggal Lahir</label><br>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo set_value('tanggal_lahir', isset($user->tanggal_lahir) ? $user->tanggal_lahir : ''); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <!-- Gender -->
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 600; color: #444;">Jenis Kelamin</label><br>
                        <label><input type="radio" name="jenis_kelamin" value="pria" <?php echo set_radio('jenis_kelamin', 'pria', (isset($user->jenis_kelamin) && $user->jenis_kelamin == 'pria')); ?>> Pria</label>
                        <label style="margin-left: 20px;"><input type="radio" name="jenis_kelamin" value="wanita" <?php echo set_radio('jenis_kelamin', 'wanita', (isset($user->jenis_kelamin) && $user->jenis_kelamin == 'wanita')); ?>> Wanita</label>
                    </div>

                    <!-- Delete account -->
                    <div style="margin-bottom: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                        <h4 style="font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #222;">Delete account</h4>
                        <p style="color: #666; font-size: 14px; margin-bottom: 10px;">By deleting your account you will lose all your data</p>
                        <button type="button" style="background: none; border: none; color: #d93025; font-weight: 600; cursor: pointer; padding: 0;">Delete account</button>
                    </div>

                    <!-- Save changes -->
                    <div>
                        <button type="submit" style="background-color: #1a73e8; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; cursor: pointer;">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

