-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Des 2025 pada 06.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_saw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_alternatif`
--

CREATE TABLE `tb_alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama_alternatif` varchar(100) DEFAULT NULL,
  `k1_val` double DEFAULT NULL,
  `k2_val` double DEFAULT NULL,
  `k3_val` varchar(20) DEFAULT NULL,
  `k4_val` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_alternatif`
--

INSERT INTO `tb_alternatif` (`id_alternatif`, `nama_alternatif`, `k1_val`, `k2_val`, `k3_val`, `k4_val`) VALUES
(1, 'Gn. Merbabu', 250000, 7, 'Ada', 4.8),
(2, 'Gn. Ungaran', 600000, 4, 'Ada', 4.6),
(3, 'Gn. Slamet', 900000, 9, 'Ada', 4.6),
(4, 'Gn. Sumbing', 600000, 8, 'Tidak Ada', 4.6),
(5, 'Gn. Merapi', 350000, 5, 'Tidak Ada', 4.4),
(6, 'Gn. Lawu', 450000, 7, 'Ada', 4.6),
(7, 'Gn. Sindoro', 500000, 6, 'Tidak Ada', 4.6),
(8, 'Gn. Prau', 400000, 3, 'Tidak Ada', 4.8),
(9, 'Gn. Andong', 200000, 1.5, 'Ada', 4.7),
(10, 'Gn. Telomoyo', 150000, 2, 'Ada', 4.6),
(11, 'Gn. Muria', 150000, 3, 'Ada', 4.2),
(12, 'Gn. Bismo', 300000, 3.5, 'Tidak Ada', 4.8),
(13, 'Gn. Kembang', 350000, 4.5, 'Tidak Ada', 4.4),
(14, 'Gn. Pakuwaja', 250000, 2, 'Tidak Ada', 4.7),
(15, 'Gn. Rogojembangan', 250000, 3.5, 'Ada', 4.4),
(16, 'Gn. Besek', 100000, 1, 'Tidak Ada', 4.7),
(17, 'Gn. Blego', 100000, 1, 'Tidak Ada', 4.3),
(18, 'Gn. Sipandu', 150000, 1, 'Tidak Ada', 4.3),
(19, 'Gn. Lasem', 200000, 2.5, 'Ada', 4.6),
(21, 'Gn. Ayamayam', 200000, 25, 'Ada', 4.6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(5) DEFAULT NULL,
  `nama_kriteria` varchar(50) DEFAULT NULL,
  `atribut` enum('cost','benefit') DEFAULT NULL,
  `bobot` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `atribut`, `bobot`) VALUES
(1, 'K1', 'Biaya', 'cost', 0.4),
(2, 'K2', 'Durasi', 'cost', 0.3),
(3, 'K3', 'Mata Air', 'benefit', 0.2),
(4, 'K4', 'Populer', 'benefit', 0.1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_parameter`
--

CREATE TABLE `tb_parameter` (
  `id_param` int(11) NOT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nama_parameter` varchar(50) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `min_value` double DEFAULT NULL,
  `max_value` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_parameter`
--

INSERT INTO `tb_parameter` (`id_param`, `id_kriteria`, `nama_parameter`, `nilai`, `min_value`, `max_value`) VALUES
(4, 2, 'Sangat Cepat (<2 jam)', 1, 0, 1.9),
(5, 2, 'Cepat (2-4 jam)', 2, 2, 3.9),
(6, 2, 'Sedang (4-6 jam)', 3, 4, 5.9),
(7, 2, 'Lama (6-8 jam)', 4, 6, 7.9),
(8, 2, 'Sangat Lama (>8 jam)', 5, 8, 999),
(9, 3, 'Tidak Ada', 1, 0, 0),
(10, 3, 'Ada', 2, 1, 1),
(11, 4, 'Buruk', 1, 1, 1.9),
(12, 4, 'Kurang', 2, 2, 2.9),
(13, 4, 'Cukup', 3, 3, 3.9),
(14, 4, 'Baik', 4, 4, 4.9),
(15, 4, 'Sangat Baik', 5, 5, 5),
(21, 1, 'Range 0 - 299.999', 1, 0, 299999),
(22, 1, 'Range 300.000 - 800.000', 2, 300000, 800000),
(23, 1, 'Range 800.001 - 1.000.000', 3, 800001, 1000000),
(24, 1, 'Range 1.000.001 - 3.000.000', 4, 1000001, 3000000),
(25, 1, 'Range > 3.000.001', 5, 3000001, 999999999);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `tb_parameter`
--
ALTER TABLE `tb_parameter`
  ADD PRIMARY KEY (`id_param`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_parameter`
--
ALTER TABLE `tb_parameter`
  MODIFY `id_param` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_parameter`
--
ALTER TABLE `tb_parameter`
  ADD CONSTRAINT `tb_parameter_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `tb_kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
