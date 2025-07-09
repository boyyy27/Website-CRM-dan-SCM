
<div class="main-content">
    <div style="max-width: 1100px; margin: 0 auto;">
        <div class="content-header" style="display: flex; align-items: center; justify-content: space-between;">
            <h1>Settings</h1>
            <a href="<?php echo base_url('index.php/history_pembelian'); ?>" style="background-color: #1a73e8; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer;">&larr; Back</a>
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
                <h3 style="font-weight: 700; font-size: 20px; margin-bottom: 20px; color: #222;">Detail Pembelian</h3>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert error"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <?php if (isset($detail_pembelian)): ?>
                    <!-- Transaction Info -->
                    <div style="margin-bottom: 24px; background: #f8f9fa; padding: 20px; border-radius: 12px;">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                            <div>
                                <p style="margin: 0 0 8px; color: #666;">No. Transaksi</p>
                                <p style="margin: 0; font-weight: 600;"><?php echo $detail_pembelian->penjualan_id; ?></p>
                            </div>
                            <div>
                                <p style="margin: 0 0 8px; color: #666;">Tanggal</p>
                                <p style="margin: 0; font-weight: 600;"><?php echo date('d/m/Y H:i', strtotime($detail_pembelian->tanggal_jual)); ?></p>
                            </div>
                            <div>
                                <p style="margin: 0 0 8px; color: #666;">Kasir</p>
                                <p style="margin: 0; font-weight: 600;"><?php echo $detail_pembelian->nama_kasir; ?></p>
                            </div>
                            <div>
                                <p style="margin: 0 0 8px; color: #666;">Status Pembayaran</p>
                                <p style="margin: 0;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; <?php echo $detail_pembelian->status_bayar == 'lunas' ? 'background-color: #e6f4ea; color: #137333;' : 'background-color: #fce8e6; color: #c5221f;'; ?>">
                                        <?php echo ucfirst($detail_pembelian->status_bayar); ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div style="margin-bottom: 24px;">
                        <h4 style="font-weight: 600; margin-bottom: 16px; color: #444;">Detail Item</h4>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Produk</th>
                                        <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Harga</th>
                                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Jumlah</th>
                                        <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail_pembelian->items as $item): ?>
                                        <tr style="border-bottom: 1px solid #dee2e6;">
                                            <td style="padding: 12px;"><?php echo $item->nama_produk; ?></td>
                                            <td style="padding: 12px; text-align: right;">Rp <?php echo number_format($item->harga_jual, 0, ',', '.'); ?></td>
                                            <td style="padding: 12px; text-align: center;"><?php echo $item->jumlah; ?></td>
                                            <td style="padding: 12px; text-align: right;">Rp <?php echo number_format($item->harga_jual * $item->jumlah, 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="padding: 12px; text-align: right; font-weight: 600;">Subtotal</td>
                                        <td style="padding: 12px; text-align: right; font-weight: 600;">Rp <?php echo number_format($detail_pembelian->subtotal, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding: 12px; text-align: right; font-weight: 600;">Diskon</td>
                                        <td style="padding: 12px; text-align: right; font-weight: 600;">Rp <?php echo number_format($detail_pembelian->diskon, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding: 12px; text-align: right; font-weight: 600;">Total</td>
                                        <td style="padding: 12px; text-align: right; font-weight: 600;">Rp <?php echo number_format($detail_pembelian->total_bayar, 0, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px 0; color: #666;">
                        Data pembelian tidak ditemukan
                    </div>
                <?php endif; ?>

                <!-- Print Button -->
                <div style="text-align: right; margin-top: 20px;">
                    <a href="<?php echo site_url('index.php/history_pembelian/print_invoice/' . $detail_pembelian->penjualan_id); ?>" target="_blank" style="background-color: #1a73e8; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                        Print Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

