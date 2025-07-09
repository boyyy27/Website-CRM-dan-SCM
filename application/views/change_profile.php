<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile - ZE Vapestore</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin-style.css'); ?>">
    <style>
        .profile-card {
            position: relative;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(99,102,241,0.08);
            padding: 2.5rem 2.2rem 2.2rem 2.2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 500px;
            margin: 2.5rem auto 0 auto;
        }
        .profile-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #6366f1;
            box-shadow: 0 2px 12px rgba(99,102,241,0.10);
            margin-bottom: 0.7rem;
            background: #f3f4f6;
        }
        .profile-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #22223b;
            margin-bottom: 0.2rem;
            text-align: center;
        }
        .profile-email {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 0.7rem;
            text-align: center;
        }
        .status-badge {
            position: absolute;
            right: 18px;
            top: 18px;
            padding: 0.3em 0.9em;
            border-radius: 16px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            background: #10b981;
            box-shadow: 0 2px 8px rgba(16,185,129,0.10);
        }
        .status-nonaktif {
            background: #ef4444;
        }
        .profile-form {
            width: 100%;
            margin-top: 1.5rem;
        }
        .profile-form label {
            font-weight: 600;
        }
        .profile-form input[type="text"],
        .profile-form input[type="email"],
        .profile-form input[type="file"] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            margin-bottom: 1.2rem;
        }
        .profile-form button,
        .profile-form a {
            margin-top: 0.5rem;
        }
        .alert {
            width: 100%;
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>
<div class="main-content">
    <div class="content-header">
        <h1>Ubah Profil</h1>
        <p>Perbarui data profil Anda di bawah ini.</p>
    </div>
    <div class="profile-card">
        <?php if (!empty($user->foto)): ?>
            <img src="<?= base_url('assets/uploads/' . $user->foto) ?>" alt="Foto Profil" class="profile-photo">
        <?php else: ?>
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->nama_lengkap ?? 'User') ?>&background=6366f1&color=fff&size=80" alt="Foto Profil" class="profile-photo">
        <?php endif; ?>
        <div class="profile-name"><?= htmlspecialchars($user->nama_lengkap ?? '') ?></div>
        <div class="profile-email"><?= htmlspecialchars($user->email ?? '') ?></div>
        <?php if (isset($user->status)): ?>
            <span class="status-badge<?= ($user->status == 'nonaktif') ? ' status-nonaktif' : '' ?>">
                <?= ($user->status == 'aktif') ? 'Active' : 'Non Active' ?>
            </span>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert error"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <?php echo validation_errors('<div class="alert error">', '</div>'); ?>
        <form class="profile-form" method="post" enctype="multipart/form-data">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($user->nama_lengkap ?? ''); ?>" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->email ?? ''); ?>" required>
            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon" class="form-control" value="<?php echo htmlspecialchars($user->telepon ?? ''); ?>">
            <label for="foto">Foto Profil</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="form-control">
            <small style="color:#64748b;">Format: jpg, jpeg, png. Maksimal 2MB.</small>
            <div style="margin-top:1.5rem;display:flex;gap:1rem;justify-content:center;">
                <button type="submit" class="crm-btn" style="padding:0.7rem 1.5rem;border-radius:8px;background:#6366f1;color:#fff;font-weight:600;">Simpan Perubahan</button>
                <a href="<?= site_url('index.php/account/account') ?>" class="crm-btn" style="background:#64748b;color:#fff;padding:0.7rem 1.5rem;border-radius:8px;font-weight:600;text-decoration:none;">Batal</a>
            </div>
        </form>
    </div>
</div>
</body>
</html> 