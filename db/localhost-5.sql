-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 30 Des 2019 pada 08.46
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hijab`
--
CREATE DATABASE IF NOT EXISTS `hijab` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hijab`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `asal_transaksi`
--

CREATE TABLE `asal_transaksi` (
  `at_id` int(11) NOT NULL,
  `at_nama` varchar(50) DEFAULT NULL,
  `at_tanggal` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `asal_transaksi`
--

INSERT INTO `asal_transaksi` (`at_id`, `at_nama`, `at_tanggal`) VALUES
(3, 'WhatsApp', '2019-05-01 08:59:03'),
(4, 'Line', '2019-05-01 08:59:20'),
(5, 'Shopee', '2019-05-01 08:59:35'),
(6, 'COD', '2019-05-01 08:59:43'),
(7, 'Bukalapak', '2019-05-01 09:48:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL,
  `barang_nama` varchar(50) DEFAULT NULL,
  `id_kategori_barang` int(11) NOT NULL,
  `barang_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`barang_id`, `barang_nama`, `id_kategori_barang`, `barang_stok`) VALUES
(70, 'Square Baby Pink S', 1, 91),
(71, 'Square Baby Pink M', 2, 97),
(72, 'Square Baby Pink L', 3, 97),
(73, 'Ayra Baby Pink S', 4, 97),
(74, 'Ayra Baby Pink M', 4, 84),
(75, 'Ayra Baby Pink L', 6, 94),
(76, 'Nadira Baby Pink S', 7, 97),
(77, 'Nadira Baby Pink M', 8, 97),
(78, 'Nadira Baby Pink L', 9, 95);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_non_reseller`
--

CREATE TABLE `barang_non_reseller` (
  `bnr_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `bnr_harga` varchar(50) NOT NULL,
  `bnr_tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_non_reseller`
--

INSERT INTO `barang_non_reseller` (`bnr_id`, `barang_id`, `bnr_harga`, `bnr_tanggal`) VALUES
(55, 70, '124124', '2019-07-08 08:58:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_reseller`
--

CREATE TABLE `barang_reseller` (
  `br_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `br_kuantitas` int(50) NOT NULL,
  `br_harga` varchar(50) NOT NULL,
  `br_tanggal` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_reseller`
--

INSERT INTO `barang_reseller` (`br_id`, `barang_id`, `br_kuantitas`, `br_harga`, `br_tanggal`) VALUES
(3014, 70, 12, '2000', '2019-07-08 08:59:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_stock_barang`
--

CREATE TABLE `history_stock_barang` (
  `hsb_id` int(11) NOT NULL,
  `pemesanan_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `stock_berkurang` int(50) NOT NULL,
  `lvl` int(11) NOT NULL,
  `hsb_tanggal` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `history_stock_barang`
--

INSERT INTO `history_stock_barang` (`hsb_id`, `pemesanan_id`, `barang_id`, `stock_berkurang`, `lvl`, `hsb_tanggal`) VALUES
(25, 25, 70, 7, 2, '2019-11-10 18:03:11'),
(26, 26, 70, 14, 1, '2019-11-11 05:38:59'),
(27, 26, 70, 6, 2, '2019-11-11 05:50:23'),
(28, 27, 70, 5, 3, '2019-11-11 06:05:14'),
(29, 28, 75, 3, 1, '2019-11-11 15:43:05'),
(30, 28, 74, 13, 1, '2019-11-11 15:43:05'),
(31, 28, 78, 2, 1, '2019-11-11 15:43:05'),
(32, 28, 70, 6, 1, '2019-11-11 15:43:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori_barang` int(11) NOT NULL,
  `nama_kategori` varchar(250) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga_ecer` int(11) NOT NULL,
  `harga_grosir_3_11` int(11) NOT NULL,
  `harga_grosir_12_29` int(11) NOT NULL,
  `grosir_diatas_30` int(11) NOT NULL,
  `reseller` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori_barang`
--

INSERT INTO `kategori_barang` (`id_kategori_barang`, `nama_kategori`, `berat`, `harga_ecer`, `harga_grosir_3_11`, `harga_grosir_12_29`, `grosir_diatas_30`, `reseller`) VALUES
(1, 'Square S', 240, 47500, 42500, 41000, 39000, 41000),
(2, 'Square M', 280, 50000, 45000, 43000, 41000, 43000),
(3, 'Square L', 350, 53000, 48000, 46000, 44000, 46000),
(4, 'Ayra S', 235, 78000, 73000, 68000, 63000, 68000),
(5, 'Ayra M', 315, 85000, 80000, 75000, 70000, 75000),
(6, 'Ayra L', 415, 98000, 93000, 88000, 83000, 88000),
(7, 'Nadira S', 235, 78000, 73000, 68000, 63000, 68000),
(8, 'Nadira M', 315, 85000, 80000, 75000, 70000, 75000),
(9, 'Nadira L', 415, 98000, 93000, 88000, 83000, 88000),
(10, 'Saila S', 225, 75000, 70000, 65000, 60000, 65000),
(11, 'Saila M', 270, 80000, 75000, 70000, 65000, 70000),
(12, 'Saila Non S', 225, 65000, 60000, 55000, 50000, 55000),
(13, 'Saila Non M', 270, 70000, 65000, 60000, 55000, 60000),
(14, 'Saila Non L', 320, 75000, 70000, 65000, 60000, 65000),
(15, 'Farra', 42, 15000, 14000, 13000, 12000, 13000),
(16, 'Nadira Kids XS', 65, 50000, 45000, 42500, 40000, 42500),
(17, 'Nadira Kids S', 85, 55000, 50000, 47500, 45000, 475000),
(18, 'Nadira Kids M', 115, 60000, 55000, 52500, 50000, 52500),
(19, 'Nadira Kids L', 155, 65000, 60000, 57500, 55000, 57500),
(20, 'Adeeva XS', 190, 63000, 58000, 55500, 53000, 55500),
(21, 'Adeeva S', 235, 66000, 61000, 58500, 56000, 58500),
(22, 'Adeeva M', 260, 69000, 64000, 61500, 59000, 61500),
(23, 'Adeeva L', 285, 75000, 70000, 67500, 65000, 675000),
(24, 'Adeeva XL', 340, 81000, 76000, 73500, 71000, 73500),
(25, 'Wupol', 60, 19500, 18000, 17000, 16000, 17000),
(26, 'Dhia BTM-BTT', 125, 50000, 45000, 43000, 41000, 43000),
(27, 'Banda Army', 30, 10000, 9000, 8500, 75000, 85000),
(28, 'Kupluk Army', 35, 12000, 10000, 9500, 8500, 9500),
(29, 'Maisafa Apricot', 175, 57500, 52500, 50000, 47500, 50000),
(30, 'Maisa Pink', 175, 55000, 50000, 47500, 45000, 47500),
(31, 'Maira Pink', 175, 52000, 47000, 44500, 42000, 44500),
(32, 'Alea Pink', 175, 52500, 47500, 45000, 42500, 45000),
(33, 'Azalea Pale Mint', 175, 52500, 47500, 45000, 42500, 45000),
(34, 'Diamond Pale Mint', 175, 52500, 47500, 44500, 42000, 44500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kurir`
--

CREATE TABLE `kurir` (
  `kurir_id` int(11) NOT NULL,
  `kurir_nama` varchar(50) DEFAULT NULL,
  `kurir_tanggal` timestamp NULL DEFAULT current_timestamp(),
  `kurir_harga` varchar(20) NOT NULL,
  `ongkir` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kurir`
--

INSERT INTO `kurir` (`kurir_id`, `kurir_nama`, `kurir_tanggal`, `kurir_harga`, `ongkir`) VALUES
(1, 'JNE', '2019-04-19 15:50:14', '10000', '22000'),
(2, 'J & T', '2019-04-19 15:50:23', '10000', '22000'),
(4, 'Grab', '2019-04-19 15:50:40', '10000', '12000'),
(5, 'Gojek', '2019-05-01 09:05:31', '10000', '12000'),
(6, 'tidak ada kurir', '2019-11-11 06:03:54', '0', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `list_barang`
--

CREATE TABLE `list_barang` (
  `lb_id` int(11) NOT NULL,
  `pemesanan_id` int(11) NOT NULL,
  `lb_qty` int(20) NOT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `lb_tanggal` timestamp NULL DEFAULT current_timestamp(),
  `lb_lvl` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `berat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `list_barang`
--

INSERT INTO `list_barang` (`lb_id`, `pemesanan_id`, `lb_qty`, `barang_id`, `lb_tanggal`, `lb_lvl`, `harga`, `berat`) VALUES
(21, 22, 4, 70, '2019-11-10 16:28:36', 1, 42500, 240),
(22, 23, 4, 70, '2019-11-10 16:28:36', 1, 42500, 240),
(23, 25, 7, 70, '2019-11-10 18:03:11', 2, 41000, 240),
(24, 26, 14, 70, '2019-11-11 05:38:59', 1, 41000, 240),
(25, 26, 6, 70, '2019-11-11 05:50:23', 2, 42500, 240),
(26, 27, 5, 70, '2019-11-11 06:05:14', 3, 41000, 240),
(27, 28, 3, 75, '2019-11-11 15:43:05', 1, 93000, 415),
(28, 28, 13, 74, '2019-11-11 15:43:05', 1, 68000, 235),
(29, 28, 2, 78, '2019-11-11 15:43:05', 1, 98000, 415),
(30, 28, 6, 70, '2019-11-11 15:43:05', 1, 42500, 240);

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `mp_id` int(11) NOT NULL,
  `mp_nama` varchar(50) DEFAULT NULL,
  `mp_tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`mp_id`, `mp_nama`, `mp_tanggal`) VALUES
(1, 'Cash', '2019-05-12 14:10:06'),
(2, 'BNI', '2019-05-12 14:11:41'),
(3, 'BRI', '2019-05-12 14:11:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `pemesanan_id` int(11) NOT NULL,
  `pemesanan_nama` varchar(50) DEFAULT NULL,
  `pemesanan_nama_akun` varchar(250) NOT NULL DEFAULT '-',
  `pemesanan_tanggal` date NOT NULL,
  `pemesanan_hp` varchar(25) DEFAULT NULL,
  `pemesanan_alamat` text DEFAULT NULL,
  `email_pemesan` varchar(250) NOT NULL,
  `kurir_id` int(11) DEFAULT NULL,
  `at_id` int(11) DEFAULT NULL,
  `mp_id` int(11) NOT NULL,
  `biaya_ongkir` int(11) NOT NULL,
  `status_pemesanan` int(1) NOT NULL,
  `biaya_admin` int(11) NOT NULL DEFAULT 0,
  `diskon` int(11) NOT NULL DEFAULT 0,
  `uang_kembalian` varchar(10) NOT NULL,
  `note` varchar(50) NOT NULL,
  `status_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`pemesanan_id`, `pemesanan_nama`, `pemesanan_nama_akun`, `pemesanan_tanggal`, `pemesanan_hp`, `pemesanan_alamat`, `email_pemesan`, `kurir_id`, `at_id`, `mp_id`, `biaya_ongkir`, `status_pemesanan`, `biaya_admin`, `diskon`, `uang_kembalian`, `note`, `status_customer`) VALUES
(22, 'asdad', '-', '2019-11-10', '12131', '1213', '12131asda', 4, 3, 2, 131, 1, 0, 0, '1213', 'asda', 1),
(23, 'asdad', '-', '2019-11-10', '12131', '1213', '12131asda', 4, 3, 2, 131, 2, 0, 0, '1213', 'asda', 1),
(25, '121asa', '-', '2019-11-11', '1213', '1sa', '12131', 2, 4, 2, 121, 2, 0, 0, '1213', 'asdad', 2),
(26, 'cadsa', '-', '2019-11-11', '1231', 'asdada', 'asdadwqeq', 2, 4, 1, 12131, 1, 0, 0, '123131', 'asdada', 1),
(27, 'admin', '-', '2019-11-11', '-', '-', '-', 6, 6, 1, 0, 3, 0, 0, '0', 'asdada', 3),
(28, 'testing', '-', '2019-11-11', '0918318318', 'testing', 'testing@gmail.com', 1, 3, 1, 30000, 1, 0, 0, '30000', 'testing', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_barang`
--

CREATE TABLE `stok_barang` (
  `id_stok` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `uang_masuk`
--

CREATE TABLE `uang_masuk` (
  `id_uang_masuk` int(11) NOT NULL,
  `pemesanan_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `uang_masuk`
--

INSERT INTO `uang_masuk` (`id_uang_masuk`, `pemesanan_id`, `jumlah`, `tanggal`) VALUES
(1, 23, 170131, '2019-11-10 17:11:52'),
(2, 25, 170131, '2019-11-10 18:03:28'),
(3, 27, 205000, '2019-11-11 06:05:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(50) DEFAULT NULL,
  `user_hp` varchar(20) DEFAULT NULL,
  `user_alamat` text DEFAULT NULL,
  `user_foto` varchar(50) DEFAULT NULL,
  `user_level` int(2) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_nama`, `user_hp`, `user_alamat`, `user_foto`, `user_level`, `username`, `password`) VALUES
(1, 'Owner', '081255555555', 'Jl.Tnabun', 'about-img.jpg', 1, 'owner', '1234'),
(2, 'Order', '121', 'Bumi', 'product3.jpg', 2, 'order', '1234'),
(3, 'Stok', '10468013', 'Bumi', 'r4.jpg', 3, 'stok', '1234');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `asal_transaksi`
--
ALTER TABLE `asal_transaksi`
  ADD PRIMARY KEY (`at_id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`);

--
-- Indeks untuk tabel `barang_non_reseller`
--
ALTER TABLE `barang_non_reseller`
  ADD PRIMARY KEY (`bnr_id`);

--
-- Indeks untuk tabel `barang_reseller`
--
ALTER TABLE `barang_reseller`
  ADD PRIMARY KEY (`br_id`);

--
-- Indeks untuk tabel `history_stock_barang`
--
ALTER TABLE `history_stock_barang`
  ADD PRIMARY KEY (`hsb_id`);

--
-- Indeks untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori_barang`);

--
-- Indeks untuk tabel `kurir`
--
ALTER TABLE `kurir`
  ADD PRIMARY KEY (`kurir_id`);

--
-- Indeks untuk tabel `list_barang`
--
ALTER TABLE `list_barang`
  ADD PRIMARY KEY (`lb_id`);

--
-- Indeks untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`mp_id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`pemesanan_id`);

--
-- Indeks untuk tabel `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indeks untuk tabel `uang_masuk`
--
ALTER TABLE `uang_masuk`
  ADD PRIMARY KEY (`id_uang_masuk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `asal_transaksi`
--
ALTER TABLE `asal_transaksi`
  MODIFY `at_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `barang_non_reseller`
--
ALTER TABLE `barang_non_reseller`
  MODIFY `bnr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `barang_reseller`
--
ALTER TABLE `barang_reseller`
  MODIFY `br_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3015;

--
-- AUTO_INCREMENT untuk tabel `history_stock_barang`
--
ALTER TABLE `history_stock_barang`
  MODIFY `hsb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `kurir`
--
ALTER TABLE `kurir`
  MODIFY `kurir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `list_barang`
--
ALTER TABLE `list_barang`
  MODIFY `lb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `mp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `pemesanan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `uang_masuk`
--
ALTER TABLE `uang_masuk`
  MODIFY `id_uang_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
