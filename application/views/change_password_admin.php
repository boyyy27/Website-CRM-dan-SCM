<title>Change Password Admin - ZE Vapestore</title>

<div class="main-content">
    <div class="content-header">
        <h1>Ubah Password Admin</h1>
        <p>Ganti password akun admin/kasir/owner Anda di sini.</p>
    </div>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert success"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert error"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <?php echo validation_errors('<div class="alert error">', '</div>'); ?>
    <form method="post" action="<?= site_url('index.php/account/update_password') ?>" style="max-width:400px;margin:auto;background:#fff;padding:2rem;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.07);">
        <div style="margin-bottom:1.2rem;">
            <label for="current_password" style="font-weight:600;">Password Lama</label>
            <input type="password" id="current_password" name="current_password" required style="width:100%;padding:0.6rem 0.8rem;border-radius:8px;border:1px solid #e5e7eb;">
        </div>
        <div style="margin-bottom:1.2rem;">
            <label for="new_password" style="font-weight:600;">Password Baru</label>
            <input type="password" id="new_password" name="new_password" required style="width:100%;padding:0.6rem 0.8rem;border-radius:8px;border:1px solid #e5e7eb;">
        </div>
        <div style="margin-bottom:1.2rem;">
            <label for="confirm_password" style="font-weight:600;">Konfirmasi Password Baru</label>
            <input type="password" id="confirm_password" name="confirm_password" required style="width:100%;padding:0.6rem 0.8rem;border-radius:8px;border:1px solid #e5e7eb;">
        </div>
        <button type="submit" class="crm-btn" style="padding:0.7rem 1.5rem;border-radius:8px;background:#6366f1;color:#fff;font-weight:600;">Simpan</button>
        <a href="<?= site_url('index.php/account/account') ?>" class="crm-btn" style="background:#64748b;color:#fff;padding:0.7rem 1.5rem;border-radius:8px;font-weight:600;text-decoration:none;margin-left:1rem;">Batal</a>
    </form>
</div> 