-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2018 pada 05.43
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belajar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `nomor_nota` varchar(13) NOT NULL,
  `id_produk` int(3) NOT NULL,
  `jumlah` float NOT NULL,
  `subtotal` int(11) NOT NULL,
  `potongan_harga` int(11) NOT NULL,
  `subtotal2` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Trigger `detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `TG_STOKUPDATE` AFTER INSERT ON `detail_penjualan` FOR EACH ROW BEGIN 
UPDATE produk SET stok=stok-NEW.jumlah
WHERE id_produk=NEW.id_produk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(3) NOT NULL,
  `nama_produk` varchar(20) NOT NULL,
  `id_kat` int(5) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `stok` float DEFAULT NULL,
  `gambar` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(3) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `id_kat`, `harga_jual`, `satuan`, `stok`, `gambar`, `updated_at`, `updated_by`, `created_at`, `created_by`, `status`) VALUES
(23, 'Rawonan', 9, 100000, 'gram', -0.258, NULL, '2018-11-19 07:37:50', NULL, '2018-11-19 07:26:10', 1, 1),
(24, 'Tulang Iga', 9, 100000, 'gram', 2.479, NULL, '2018-11-19 08:41:11', NULL, '2018-11-19 07:26:37', 1, 1),
(25, 'Daging Iga', 9, 100000, 'gram', 0, NULL, NULL, NULL, '2018-11-19 07:26:54', 1, 1),
(26, 'khas', 9, 100000, 'gram', 0, NULL, NULL, NULL, '2018-11-19 07:27:14', 1, 1),
(27, 'dada', 10, 32000, 'gram', -1.5, NULL, '2018-11-19 07:37:50', NULL, '2018-11-19 07:27:44', 1, 1),
(28, 'paha', 10, 32000, 'gram', 0, NULL, NULL, NULL, '2018-11-19 07:27:58', 1, 1),
(29, 'sayap', 10, 20000, 'gram', 0, NULL, NULL, NULL, '2018-11-19 07:28:14', 1, 1),
(30, 'wortel', 11, 15000, 'gram', -3, NULL, '2018-11-19 07:37:50', NULL, '2018-11-19 07:28:46', 1, 1),
(31, 'Kentang', 11, 15000, 'gram', -2, NULL, '2018-11-19 07:46:43', NULL, '2018-11-19 07:29:02', 1, 1),
(32, 'Sop-sopan', 11, 5000, 'pcs', -3, NULL, '2018-11-19 07:37:50', NULL, '2018-11-19 07:35:44', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_cat`
--

CREATE TABLE `produk_cat` (
  `id_kat` int(5) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk_cat`
--

INSERT INTO `produk_cat` (`id_kat`, `nama_kategori`) VALUES
(9, 'Sapi'),
(10, 'ayam'),
(11, 'sayur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(4) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `nomor_telephone` varchar(15) NOT NULL,
  `alamat` text,
  `catatan` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(3) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `nomor_telephone`, `alamat`, `catatan`, `updated_at`, `updated_by`, `created_at`, `created_by`, `status`) VALUES
(21, 'abdul', '0812456578987', 'jombang', 'sayur', NULL, NULL, '2018-11-19 07:29:59', 1, 1),
(22, 'abdi', '0812456578987', 'jombang', 'sapi', NULL, NULL, '2018-11-19 07:30:22', 1, 1),
(23, 'andi', '0812456578987', 'joimbang', 'ayam', NULL, NULL, '2018-11-19 07:30:50', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_pembelian`
--

CREATE TABLE `transaksi_pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_supplier` int(3) NOT NULL,
  `id_produk` int(3) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `bukti_pembayaran` text,
  `keterangan` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(3) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Trigger `transaksi_pembelian`
--
DELIMITER $$
CREATE TRIGGER `TG_TAMBAHSTOK` AFTER INSERT ON `transaksi_pembelian` FOR EACH ROW BEGIN 
UPDATE produk SET stok=stok+NEW.jumlah
WHERE id_produk=NEW.id_produk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_penjualan`
--

CREATE TABLE `transaksi_penjualan` (
  `nomor_nota` varchar(13) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `pembayaran` int(11) NOT NULL,
  `uang_kembali` int(11) DEFAULT NULL,
  `delivery` int(11) DEFAULT NULL,
  `nama_pelanggan` varchar(50) DEFAULT NULL,
  `alamat_pelanggan` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_penjualan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_penjualan` (
`nomor_nota` varchar(13)
,`total_bayar` int(11)
,`pembayaran` int(11)
,`uang_kembali` int(11)
,`updated_at` timestamp
,`updated_by` int(1)
,`created_at` timestamp
,`created_by` int(11)
,`status` int(1)
,`id_produk` int(3)
,`jumlah` float
,`subtotal` int(11)
,`subtotal2` int(11)
,`potongan_harga` int(11)
,`nama_produk` varchar(20)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_penjualan`
--
DROP TABLE IF EXISTS `view_penjualan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_penjualan`  AS  select `transaksi_penjualan`.`nomor_nota` AS `nomor_nota`,`transaksi_penjualan`.`total_bayar` AS `total_bayar`,`transaksi_penjualan`.`pembayaran` AS `pembayaran`,`transaksi_penjualan`.`uang_kembali` AS `uang_kembali`,`transaksi_penjualan`.`updated_at` AS `updated_at`,`transaksi_penjualan`.`updated_by` AS `updated_by`,`transaksi_penjualan`.`created_at` AS `created_at`,`transaksi_penjualan`.`created_by` AS `created_by`,`transaksi_penjualan`.`status` AS `status`,`detail_penjualan`.`id_produk` AS `id_produk`,`detail_penjualan`.`jumlah` AS `jumlah`,`detail_penjualan`.`subtotal` AS `subtotal`,`detail_penjualan`.`subtotal2` AS `subtotal2`,`detail_penjualan`.`potongan_harga` AS `potongan_harga`,`produk`.`nama_produk` AS `nama_produk` from ((`transaksi_penjualan` join `detail_penjualan` on((`detail_penjualan`.`nomor_nota` = `transaksi_penjualan`.`nomor_nota`))) join `produk` on((`detail_penjualan`.`id_produk` = `produk`.`id_produk`))) where (`transaksi_penjualan`.`status` = 1) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `produk_cat`
--
ALTER TABLE `produk_cat`
  ADD PRIMARY KEY (`id_kat`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `transaksi_pembelian`
--
ALTER TABLE `transaksi_pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  ADD PRIMARY KEY (`nomor_nota`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `produk_cat`
--
ALTER TABLE `produk_cat`
  MODIFY `id_kat` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `transaksi_pembelian`
--
ALTER TABLE `transaksi_pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
