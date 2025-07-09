-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 04:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vapestore`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateStokPembelian` (IN `p_produk_id` INT, IN `p_jumlah` INT, IN `p_po_number` VARCHAR(50))   BEGIN
    DECLARE v_stok_lama INT;
    
    -- Ambil stok sekarang
    SELECT jumlah_stok INTO v_stok_lama FROM stok WHERE produk_id = p_produk_id;
    
    -- Update stok
    UPDATE stok SET jumlah_stok = jumlah_stok + p_jumlah WHERE produk_id = p_produk_id;
    
    -- Insert ke riwayat stok
    INSERT INTO riwayat_stok (produk_id, jenis_transaksi, jumlah, stok_sebelum, stok_sesudah, referensi, keterangan)
    VALUES (p_produk_id, 'masuk', p_jumlah, v_stok_lama, v_stok_lama + p_jumlah, p_po_number, 'Pembelian dari supplier');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateStokPenjualan` (IN `p_produk_id` INT, IN `p_jumlah` INT, IN `p_invoice` VARCHAR(50))   BEGIN
    DECLARE v_stok_lama INT;
    
    -- Ambil stok sekarang
    SELECT jumlah_stok INTO v_stok_lama FROM stok WHERE produk_id = p_produk_id;
    
    -- Update stok
    UPDATE stok SET jumlah_stok = jumlah_stok - p_jumlah WHERE produk_id = p_produk_id;
    
    -- Insert ke riwayat stok
    INSERT INTO riwayat_stok (produk_id, jenis_transaksi, jumlah, stok_sebelum, stok_sesudah, referensi, keterangan)
    VALUES (p_produk_id, 'keluar', p_jumlah, v_stok_lama, v_stok_lama - p_jumlah, p_invoice, 'Penjualan');
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `kode_customer` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  'username' varchar(100) NOT NULL,
  'password' varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('pria','wanita') DEFAULT NULL,
  `total_pembelian` decimal(15,2) DEFAULT 0.00,
  `poin_loyalty` int(11) DEFAULT 0,
  `verifikasi_umur` tinyint(1) DEFAULT 0,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_daftar` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `kode_customer`, `nama_lengkap`, `email`, `telepon`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `total_pembelian`, `poin_loyalty`, `verifikasi_umur`, `status`, `tanggal_daftar`) VALUES
(1, 'CUST001', 'John Doe', 'john@email.com', '081111111111', 'Jl. Merdeka No. 1', '1990-01-01', 'pria', '0.00', 0, 1, 'aktif', '2025-05-28'),
(2, 'CUST002', 'Jane Smith', 'jane@email.com', '081222222222', 'Jl. Sudirman No. 2', '1985-05-15', 'wanita', '0.00', 0, 1, 'aktif', '2025-05-28'),
(3, 'CUST003', 'Budi Setiawan', 'budi@email.com', '081333333333', 'Jl. Gatot Subroto No. 3', '1995-08-20', 'pria', '0.00', 0, 1, 'aktif', '2025-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `detail_id` int(11) NOT NULL,
  `pembelian_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(15,2) GENERATED ALWAYS AS (`jumlah` * `harga_satuan`) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `detail_id` int(11) NOT NULL,
  `penjualan_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(15,2) GENERATED ALWAYS AS (`jumlah` * `harga_satuan`) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Pod System', 'Vape pod system compact dan mudah digunakan'),
(2, 'Mod Vape', 'Vape mod dengan watt tinggi'),
(3, 'E-Liquid', 'Cairan vape berbagai rasa'),
(4, 'Coil', 'Coil pengganti untuk berbagai device'),
(5, 'Disposable', 'Vape sekali pakai'),
(6, 'Aksesoris', 'Aksesoris pendukung vape');

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_penjualan_harian`
-- (See below for the actual view)
--
CREATE TABLE `laporan_penjualan_harian` (
`tanggal` date
,`jumlah_transaksi` bigint(21)
,`total_penjualan` decimal(37,2)
,`rata_rata_transaksi` decimal(19,6)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_stok_rendah`
-- (See below for the actual view)
--
CREATE TABLE `laporan_stok_rendah` (
`kode_produk` varchar(50)
,`nama_produk` varchar(200)
,`nama_kategori` varchar(100)
,`jumlah_stok` int(11)
,`stok_minimum` int(11)
,`status_stok` varchar(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `pembelian_id` int(11) NOT NULL,
  `nomor_po` varchar(50) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `tanggal_pesan` date NOT NULL,
  `tanggal_terima` date DEFAULT NULL,
  `total_harga` decimal(15,2) DEFAULT 0.00,
  `status` enum('dipesan','diterima','batal') DEFAULT 'dipesan',
  `catatan` text DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `dibuat_tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `penjualan_id` int(11) NOT NULL,
  `nomor_invoice` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `tanggal_jual` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(15,2) DEFAULT 0.00,
  `diskon` decimal(15,2) DEFAULT 0.00,
  `pajak` decimal(15,2) DEFAULT 0.00,
  `total_bayar` decimal(15,2) DEFAULT 0.00,
  `metode_bayar` enum('tunai','kartu','transfer','e_wallet') DEFAULT 'tunai',
  `status_bayar` enum('lunas','belum_lunas') DEFAULT 'lunas',
  `dilayani_oleh` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produk_id` int(11) NOT NULL,
  `kode_produk` varchar(50) NOT NULL,
  `nama_produk` varchar(200) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `stok_minimum` int(11) DEFAULT 5,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `dibuat_tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produk_id`, `kode_produk`, `nama_produk`, `kategori_id`, `supplier_id`, `harga_beli`, `harga_jual`, `stok_minimum`, `deskripsi`, `status`, `dibuat_tanggal`) VALUES
(1, 'POD001', 'SMOK Nord 4 Pod Kit', 1, 1, '250000.00', '350000.00', 10, 'Pod system dengan baterai 2000mAh', 'aktif', '2025-05-28 02:27:18'),
(2, 'POD002', 'Vaporesso XROS 3', 1, 1, '200000.00', '280000.00', 10, 'Pod system ultra portable', 'aktif', '2025-05-28 02:27:18'),
(3, 'MOD001', 'GeekVape Aegis Legend 2', 2, 2, '400000.00', '550000.00', 5, 'Mod tahan air dan debu', 'aktif', '2025-05-28 02:27:18'),
(4, 'ELQ001', 'Salt Nic Mango 30ml', 3, 1, '35000.00', '50000.00', 20, 'E-liquid salt nicotine rasa mangga', 'aktif', '2025-05-28 02:27:18'),
(5, 'ELQ002', 'Freebase Strawberry 60ml', 3, 2, '45000.00', '65000.00', 20, 'E-liquid freebase rasa strawberry', 'aktif', '2025-05-28 02:27:18'),
(6, 'COIL001', 'Nord Coil 0.8ohm', 4, 1, '15000.00', '25000.00', 50, 'Coil replacement untuk Nord series', 'aktif', '2025-05-28 02:27:18'),
(7, 'DSP001', 'Disposable 2500 Puff', 5, 3, '25000.00', '40000.00', 30, 'Vape sekali pakai 2500 puff', 'aktif', '2025-05-28 02:27:18'),
(8, 'ACC001', 'Charger USB Type-C', 6, 2, '20000.00', '35000.00', 15, 'Charger universal untuk vape', 'aktif', '2025-05-28 02:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_stok`
--

CREATE TABLE `riwayat_stok` (
  `riwayat_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jenis_transaksi` enum('masuk','keluar','penyesuaian') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `stok_sebelum` int(11) NOT NULL,
  `stok_sesudah` int(11) NOT NULL,
  `referensi` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `dibuat_oleh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `stok_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah_stok` int(11) DEFAULT 0,
  `lokasi_simpan` varchar(100) DEFAULT 'Gudang Utama',
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`stok_id`, `produk_id`, `jumlah_stok`, `lokasi_simpan`, `tanggal_update`) VALUES
(1, 1, 25, 'Gudang Utama', '2025-05-28 02:27:18'),
(2, 2, 20, 'Gudang Utama', '2025-05-28 02:27:18'),
(3, 3, 10, 'Gudang Utama', '2025-05-28 02:27:18'),
(4, 4, 50, 'Gudang Utama', '2025-05-28 02:27:18'),
(5, 5, 40, 'Gudang Utama', '2025-05-28 02:27:18'),
(6, 6, 100, 'Gudang Utama', '2025-05-28 02:27:18'),
(7, 7, 75, 'Gudang Utama', '2025-05-28 02:27:18'),
(8, 8, 30, 'Gudang Utama', '2025-05-28 02:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `kontak_person` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `dibuat_tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `nama_supplier`, `kontak_person`, `telepon`, `alamat`, `kota`, `status`, `dibuat_tanggal`) VALUES
(1, 'PT Vape Indonesia', 'Budi Santoso', '021-12345678', 'Jl. Sudirman No. 123', 'Jakarta', 'aktif', '2025-05-28 02:27:18'),
(2, 'CV Maju Vape', 'Siti Rahayu', '021-87654321', 'Jl. Gatot Subroto No. 456', 'Jakarta', 'aktif', '2025-05-28 02:27:18'),
(3, 'Distributor Vape Nusantara', 'Ahmad Rahman', '021-11223344', 'Jl. Thamrin No. 789', 'Bandung', 'aktif', '2025-05-28 02:27:18');

-- --------------------------------------------------------

--
-- Stand-in structure for view `top_customer`
-- (See below for the actual view)
--
CREATE TABLE `top_customer` (
`kode_customer` varchar(50)
,`nama_lengkap` varchar(100)
,`telepon` varchar(20)
,`total_pembelian` decimal(15,2)
,`poin_loyalty` int(11)
,`jumlah_transaksi` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `role` enum('admin','kasir','owner') NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `dibuat_tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `nama_lengkap`, `email`, `telepon`, `role`, `status`, `dibuat_tanggal`) VALUES
(1, 'admin', 'admin123', 'Administrator', 'admin@vapestore.com', '081234567890', 'admin', 'aktif', '2025-05-28 02:27:18'),
(2, 'kasir1', 'kasir123', 'Kasir 1', 'kasir1@vapestore.com', '081234567891', 'kasir', 'aktif', '2025-05-28 02:27:18'),
(3, 'owner', 'owner123', 'Pemilik Toko', 'owner@vapestore.com', '081234567892', 'owner', 'aktif', '2025-05-28 02:27:18');

-- --------------------------------------------------------

--
-- Structure for view `laporan_penjualan_harian`
--
DROP TABLE IF EXISTS `laporan_penjualan_harian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_penjualan_harian`  AS SELECT cast(`penjualan`.`tanggal_jual` as date) AS `tanggal`, count(0) AS `jumlah_transaksi`, sum(`penjualan`.`total_bayar`) AS `total_penjualan`, avg(`penjualan`.`total_bayar`) AS `rata_rata_transaksi` FROM `penjualan` WHERE `penjualan`.`status_bayar` = 'lunas' GROUP BY cast(`penjualan`.`tanggal_jual` as date) ORDER BY cast(`penjualan`.`tanggal_jual` as date) AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `laporan_stok_rendah`
--
DROP TABLE IF EXISTS `laporan_stok_rendah`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_stok_rendah`  AS SELECT `p`.`kode_produk` AS `kode_produk`, `p`.`nama_produk` AS `nama_produk`, `k`.`nama_kategori` AS `nama_kategori`, `s`.`jumlah_stok` AS `jumlah_stok`, `p`.`stok_minimum` AS `stok_minimum`, CASE WHEN `s`.`jumlah_stok` = 0 THEN 'Habis' WHEN `s`.`jumlah_stok` <= `p`.`stok_minimum` THEN 'Stok Rendah' ELSE 'Aman' END AS `status_stok` FROM ((`produk` `p` left join `stok` `s` on(`p`.`produk_id` = `s`.`produk_id`)) left join `kategori` `k` on(`p`.`kategori_id` = `k`.`kategori_id`)) WHERE `p`.`status` = 'aktif' ORDER BY `s`.`jumlah_stok` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `top_customer`
--
DROP TABLE IF EXISTS `top_customer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `top_customer`  AS SELECT `c`.`kode_customer` AS `kode_customer`, `c`.`nama_lengkap` AS `nama_lengkap`, `c`.`telepon` AS `telepon`, `c`.`total_pembelian` AS `total_pembelian`, `c`.`poin_loyalty` AS `poin_loyalty`, count(`p`.`penjualan_id`) AS `jumlah_transaksi` FROM (`customers` `c` left join `penjualan` `p` on(`c`.`customer_id` = `p`.`customer_id`)) WHERE `c`.`status` = 'aktif' GROUP BY `c`.`customer_id` ORDER BY `c`.`total_pembelian` AS `DESCdesc` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `kode_customer` (`kode_customer`);

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `pembelian_id` (`pembelian_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `penjualan_id` (`penjualan_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`pembelian_id`),
  ADD UNIQUE KEY `nomor_po` (`nomor_po`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`penjualan_id`),
  ADD UNIQUE KEY `nomor_invoice` (`nomor_invoice`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `dilayani_oleh` (`dilayani_oleh`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produk_id`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `riwayat_stok`
--
ALTER TABLE `riwayat_stok`
  ADD PRIMARY KEY (`riwayat_id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`stok_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `pembelian_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `penjualan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `riwayat_stok`
--
ALTER TABLE `riwayat_stok`
  MODIFY `riwayat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `stok_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_ibfk_1` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`pembelian_id`),
  ADD CONSTRAINT `detail_pembelian_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`);

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`penjualan_id`),
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`dilayani_oleh`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `riwayat_stok`
--
ALTER TABLE `riwayat_stok`
  ADD CONSTRAINT `riwayat_stok_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`),
  ADD CONSTRAINT `riwayat_stok_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
