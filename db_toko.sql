-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2021 pada 05.25
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bank`
--

CREATE TABLE `tb_bank` (
  `bank_id` int(11) NOT NULL,
  `nama_bank` varchar(255) DEFAULT NULL,
  `no_bank` varchar(255) DEFAULT NULL,
  `atas_nama_bank` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_bank`
--

INSERT INTO `tb_bank` (`bank_id`, `nama_bank`, `no_bank`, `atas_nama_bank`) VALUES
(1, 'mandiri', '12300372', 'Jhon Doe'),
(2, 'BCA', '120037642', 'Jhonn');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_keranjang`
--

CREATE TABLE `tb_keranjang` (
  `keranjang_id` int(11) NOT NULL,
  `keranjang_grup` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(100) DEFAULT NULL,
  `is_payed` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_keranjang`
--

INSERT INTO `tb_keranjang` (`keranjang_id`, `keranjang_grup`, `product_id`, `user_id`, `qty`, `is_payed`) VALUES
(49, 3, 2, 3, 2, 1),
(50, 3, 2, 3, 1, 1),
(51, 3, 2, 3, 8, 1),
(52, 3, 4, 3, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_product`
--

CREATE TABLE `tb_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_desc` varchar(255) DEFAULT NULL,
  `product_thumb` varchar(255) DEFAULT NULL,
  `product_stok` int(100) DEFAULT NULL,
  `product_price` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_product`
--

INSERT INTO `tb_product` (`product_id`, `product_name`, `product_desc`, `product_thumb`, `product_stok`, `product_price`) VALUES
(1, 'baju kemeja putih', 'lorem lorem', '60d9c1fb64dd5.png', 190, 40000),
(2, 'lorem baju', 'lorem', 'baju.jpg', 60, 30000),
(3, 'bajuuu', 'jjuu', 'baju.jfif', 150, 50000),
(4, 'nama baru', 'bjuu', '60d9bbea59fc8.png', 119, 60000),
(5, 'baju kemeja', 'baju dengan bahan halus', '60d9c0f509e18.png', 300, 40000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `keranjang_grup` int(11) NOT NULL,
  `transaksi_alamat` varchar(255) DEFAULT NULL,
  `tanggal_transaksi` varchar(255) DEFAULT NULL,
  `status_pembayaran` int(1) DEFAULT 2,
  `bukti_pembayaran` varchar(256) NOT NULL DEFAULT '2',
  `total_pembayaran` varchar(256) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`transaksi_id`, `user_id`, `bank_id`, `keranjang_grup`, `transaksi_alamat`, `tanggal_transaksi`, `status_pembayaran`, `bukti_pembayaran`, `total_pembayaran`) VALUES
(32, 3, 1, 49, 'gaggg', '2021-06-28', 1, '60d9b2df05800.png', '60000'),
(33, 3, 2, 51, 'gaggg2', '2021-06-28', 1, '60d9b307b0f09.png', '240000'),
(34, 3, 2, 52, '32131', '2021-06-28', 1, '60d9c7b24e8fd.png', '60000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(1) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `username`, `fullname`, `password`, `role`) VALUES
(3, 'user', 'muhamad nizar', '$2y$10$AD85JaIX8eK1qCkVe32n6epjiimfvi1f2t0Qb3itZ0ddskIiXyzFC', 2),
(4, 'nizar', 'nizarrr ganteng', '$2y$10$pcLiOwnbVDvY3a9jya.2e.QxJPkGZ1tSUSgLzxq3FI8rmjSD.GwjS', 2),
(5, 'admin', 'administrator', '$2y$10$0oNEcilMYEcp39zm.5itDel.CmrtBpBBhoI7yrgWTkvp/ii8wCaBG', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_bank`
--
ALTER TABLE `tb_bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indeks untuk tabel `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD PRIMARY KEY (`keranjang_id`),
  ADD KEY `FK_58e81b88-c1a7-4aed-87d8-a3b3a7f26b58` (`product_id`),
  ADD KEY `FK_c5cfab37-f97f-418b-843a-36d9fd87a70f` (`user_id`);

--
-- Indeks untuk tabel `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indeks untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `FK_3d28adec-a61d-47ef-8de6-6f6e908db79b` (`user_id`),
  ADD KEY `FK_c517df8a-2e58-491f-802b-a338cae9abb5` (`bank_id`),
  ADD KEY `tb_transaksi_ibfk_1` (`keranjang_grup`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_bank`
--
ALTER TABLE `tb_bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  MODIFY `keranjang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD CONSTRAINT `FK_58e81b88-c1a7-4aed-87d8-a3b3a7f26b58` FOREIGN KEY (`product_id`) REFERENCES `tb_product` (`product_id`),
  ADD CONSTRAINT `FK_c5cfab37-f97f-418b-843a-36d9fd87a70f` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `FK_3d28adec-a61d-47ef-8de6-6f6e908db79b` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`),
  ADD CONSTRAINT `FK_c517df8a-2e58-491f-802b-a338cae9abb5` FOREIGN KEY (`bank_id`) REFERENCES `tb_bank` (`bank_id`),
  ADD CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`keranjang_grup`) REFERENCES `tb_keranjang` (`keranjang_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
