<link rel="icon" type="image/png" href="https://i.ibb.co/whrNy6j6/Pngtree-vape-device-8133386.png" />

<title>Change Password - ZE Vapestore</title>

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
                        <a href="<?php echo base_url('index.php/account/account'); ?>" style="color:color: #666; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">
                            Account
                        </a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="<?php echo base_url('index.php/account/change_password'); ?>" style="color: #1a73e8; font-weight: 700; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px; background-color: #e8f0fe;">
                            Change Password
                        </a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="<?php echo base_url('index.php/history_pembelian'); ?>" style="color: #666; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">
                            History Pembelian
                        </a>
                    </li>
                    <li style="margin-top: 20px;">
                        <a href="<?php echo base_url('index.php/Auth/logout'); ?>" style="color: #d93025; font-weight: 700; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>

            <div style="flex-grow: 1; background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 12px rgba(0,0,0,0.1);">
                <h3 style="font-weight: 700; font-size: 20px; margin-bottom: 20px; color: #222;">Change Password</h3>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert error"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <?php echo validation_errors('<div class="alert error">', '</div>'); ?>

                <form method="post" action="<?php echo site_url('index.php/account/update_password'); ?>">
                    <div style="margin-bottom: 20px;">
                        <label for="current_password" style="font-weight: 600; color: #444;">Current Password</label><br>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter current password" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="new_password" style="font-weight: 600; color: #444;">New Password</label><br>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <div style="margin-bottom: 30px;">
                        <label for="confirm_password" style="font-weight: 600; color: #444;">Confirm New Password</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>

                    <div>
                        <button type="submit" style="background-color: #1a73e8; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; cursor: pointer;">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
