-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 19, 2024 at 06:55 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_camp`
--

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_camping`
--

CREATE TABLE `fasilitas_camping` (
  `id` int(11) NOT NULL,
  `fasilitas_camping` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `gambar`, `deskripsi`, `created_at`) VALUES
(3, '506240818081843.jpg', 'Curug ', '2024-08-18 08:18:43'),
(4, '2024240818082025.jpg', '1', '2024-08-18 08:20:25'),
(5, '5769240818082029.jpg', '2', '2024-08-18 08:20:29'),
(6, '4811240818082033.jpg', '3', '2024-08-18 08:20:33'),
(7, '5708240818082038.jpg', '4', '2024-08-18 08:20:38'),
(8, '4456240818082044.jpg', '5', '2024-08-18 08:20:44'),
(9, '9341240818082048.jpg', '60', '2024-08-18 08:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `objek_wisata`
--

CREATE TABLE `objek_wisata` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `objek_wisata`
--

INSERT INTO `objek_wisata` (`id`, `nama`, `alamat`, `deskripsi`, `gambar`, `created_at`) VALUES
(7, 'Perbukitan Spot Foto', '3C3M+C5H, Cisantana, Kec. Cigugur, Kabupaten Kuningan, Jawa Barat 45552', 'Spot foto bagi wistawan', '7523240818082751.jpg', '2024-08-18 08:27:51'),
(8, 'Pondok Pinus Palutungan', ' Desa Cisantana, Cigugur Kabupaten Kuningan Jawa Barat.', 'Pondok Pinus Palutungan', '1502240818082911.jpg', '2024-08-18 08:29:11'),
(9, 'Camping di palutungan', ' Desa Cisantana, Kecamatan Cigugur, Kabupaten Kuningan, Jawa Barat.', 'Camping di palutungan', '9794240818083113.jpg', '2024-08-18 08:31:13'),
(10, 'Curug Ladung', ' Desa Cisantana, Kecamatan Cigugur, Kabupaten Kuningan, Jawa Barat.', 'air terjun curug landung', '2920240818083214.jpg', '2024-08-18 08:32:14'),
(11, 'Arunika Eatery', 'Dusun Palutungan, Desa Cisantana, Kecamatan Cigugur, Kabupaten Kuningan, Jawa Barat.', 'Arunika Eatery', '7453240818083306.webp', '2024-08-18 08:33:06'),
(12, ' Palutungan Bike Park', 'Dusun Palutungan, Desa Cisantana, Kecamatan Cigugur, Kabupaten Kuningan, Jawa Barat.', ' Palutungan Bike Park', 'download (22).jpg', '2024-08-18 08:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `paket_camping`
--

CREATE TABLE `paket_camping` (
  `id` int(11) NOT NULL,
  `obyek_wisata_id` int(11) NOT NULL,
  `paket_camping` varchar(255) NOT NULL,
  `harga_paket` decimal(10,2) NOT NULL,
  `area_camping` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `bonus_peralatan` varchar(255) DEFAULT NULL,
  `diskon` int(11) NOT NULL,
  `gambar` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paket_camping`
--

INSERT INTO `paket_camping` (`id`, `obyek_wisata_id`, `paket_camping`, `harga_paket`, `area_camping`, `kapasitas`, `bonus_peralatan`, `diskon`, `gambar`, `created_at`) VALUES
(8, 7, 'Basic', 100000.00, 'Area 1 ', 5, 'Kayu bakar', 2, 'download (15).jpg', '2024-08-18 08:35:48'),
(9, 8, 'Basic', 150000.00, 'Area 2', 5, 'Kayu bakar', 3, '9e2bc91a-44be-46e9-8910-a87f5e8b87f8-ebb60a57281b780df78fc1481f4a3614_600x400.jpg', '2024-08-18 08:37:07'),
(11, 8, 'Standard', 1000000.00, 'Area 2', 7, 'Kayu bakar', 4, 'download (16).jpg', '2024-08-19 16:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_camping`
--

CREATE TABLE `pemesanan_camping` (
  `id` int(11) NOT NULL,
  `no_pemesanan` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `paket_camping_id` varchar(500) NOT NULL,
  `tanggal` date NOT NULL,
  `durasi` int(11) NOT NULL,
  `jml_peserta` int(11) NOT NULL,
  `diskon` decimal(5,2) DEFAULT '0.00',
  `jenis_tenda` enum('2orang','4orang','6orang') DEFAULT NULL,
  `jenis_makanan` enum('makanan','bbq') DEFAULT NULL,
  `harga_paket` decimal(10,2) NOT NULL,
  `total_tagihan` decimal(10,2) NOT NULL,
  `status` enum('Proses','Selesai','Belum Diproses') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `no_hp`, `is_admin`) VALUES
(13, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '12345', 1),
(14, 'Albet ubaidi', 'albetubaidi', '8d1b3c1b02b9871b87c1f8aa69991576', '12345', 0);

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `url`, `created_at`) VALUES
(6, 'https://youtu.be/wKUCgNZstos?si=t2zJcYVip3RAX-O_', '2024-08-18 07:57:14'),
(7, 'https://youtu.be/ek9VekDHg84?si=XL6zk5t1h0h1VonI', '2024-08-18 07:57:32'),
(8, 'https://youtu.be/33dYO5V9GYA?si=HOqhohTFGmhF04aV', '2024-08-18 07:57:55'),
(9, 'https://youtu.be/fyr5LVfx-pc?si=BvlvFs8yTtJo6vbQ', '2024-08-18 07:58:04'),
(10, 'https://youtu.be/oEorlVV93tM?si=mx-qyw6ojk2Jiw-K', '2024-08-18 08:16:49'),
(11, 'https://youtu.be/5MuIPlrO3jE?si=CVjCLyvsvDPbzKuF', '2024-08-18 08:17:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fasilitas_camping`
--
ALTER TABLE `fasilitas_camping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `objek_wisata`
--
ALTER TABLE `objek_wisata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket_camping`
--
ALTER TABLE `paket_camping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesanan_camping`
--
ALTER TABLE `pemesanan_camping`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_pemesanan` (`no_pemesanan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fasilitas_camping`
--
ALTER TABLE `fasilitas_camping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `objek_wisata`
--
ALTER TABLE `objek_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `paket_camping`
--
ALTER TABLE `paket_camping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pemesanan_camping`
--
ALTER TABLE `pemesanan_camping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
