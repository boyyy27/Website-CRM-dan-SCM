<link rel="icon" type="image/png" href="https://i.ibb.co/whrNy6j6/Pngtree-vape-device-8133386.png" />

<title>History Pembelian - ZE Vapestore</title>

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
                        <a href="<?php echo base_url('index.php/account/account'); ?>" style="color: #666; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">
                            Account
                        </a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="<?php echo base_url('index.php/account/change_password'); ?>" style="color: #666; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px;">
                            Change Password
                        </a>
                    </li>
                    <li style="margin-bottom: 12px;">
                        <a href="<?php echo base_url('index.php/history_pembelian'); ?>" style="color: #1a73e8; font-weight: 700; text-decoration: none; display: block; padding: 8px 12px; border-radius: 6px; background-color: #e8f0fe;">
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

            <!-- Main content -->
            <div style="flex-grow: 1; background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 12px rgba(0,0,0,0.1);">
                <h3 style="font-weight: 700; font-size: 20px; margin-bottom: 20px; color: #222;">History Pembelian</h3>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert error"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <!-- Filter Section -->
                <div style="margin-bottom: 24px; background: #f8f9fa; padding: 20px; border-radius: 12px;">
                    <form method="get" action="<?php echo site_url('index.php/history_pembelian'); ?>" style="display: flex; gap: 16px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Tanggal Mulai</label>
                            <input type="date" name="date_start" value="<?php echo $this->input->get('date_start'); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Tanggal Akhir</label>
                            <input type="date" name="date_end" value="<?php echo $this->input->get('date_end'); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Status Pembayaran</label>
                            <select name="status_bayar" style="width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px;">
                                <option value="">Semua Status</option>
                                <option value="lunas" <?php echo $this->input->get('status_bayar') == 'lunas' ? 'selected' : ''; ?>>Lunas</option>
                                <option value="belum" <?php echo $this->input->get('status_bayar') == 'belum' ? 'selected' : ''; ?>>Belum Lunas</option>
                            </select>
                        </div>
                        <div style="flex: 0 0 auto; align-self: flex-end;">
                            <button type="submit" style="background-color: #1a73e8; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer;">Filter</button>
                        </div>
                    </form>
                </div>

                <!-- History Table -->
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">No. Transaksi</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Tanggal</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Total</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Status</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($history_pembelian)): ?>
                                <?php foreach ($history_pembelian as $pembelian): ?>
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 12px;"><?php echo $pembelian->penjualan_id; ?></td>
                                        <td style="padding: 12px;"><?php echo date('d/m/Y', strtotime($pembelian->tanggal_jual)); ?></td>
                                        <td style="padding: 12px;">Rp <?php echo number_format($pembelian->total_bayar, 0, ',', '.'); ?></td>
                                        <td style="padding: 12px;">
                                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; <?php echo $pembelian->status_bayar == 'lunas' ? 'background-color: #e6f4ea; color: #137333;' : 'background-color: #fce8e6; color: #c5221f;'; ?>">
                                                <?php echo ucfirst($pembelian->status_bayar); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 12px;">
                                            <a href="<?php echo site_url('index.php/history_pembelian/detail/' . $pembelian->penjualan_id); ?>" style="color: #1a73e8; text-decoration: none; font-weight: 600;">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="padding: 24px; text-align: center; color: #666;">Tidak ada data pembelian</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer'); ?> 