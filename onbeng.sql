-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21 Feb 2016 pada 01.55
-- Versi Server: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onbeng`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `beo_admin`
--

CREATE TABLE `beo_admin` (
  `id` int(11) NOT NULL,
  `user` varchar(30) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `last_logout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `beo_admin`
--

INSERT INTO `beo_admin` (`id`, `user`, `pass`, `last_login`, `last_logout`) VALUES
(1, 'admin', '9a60c5d1e71e5a3d31b59993878c984750b54a23', '2016-02-20 18:46:02', '2016-02-08 20:53:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beo_bengkel`
--

CREATE TABLE `beo_bengkel` (
  `id` int(11) NOT NULL,
  `id_marker` varchar(14) NOT NULL,
  `profile` text NOT NULL,
  `latlng` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `beo_bengkel`
--

INSERT INTO `beo_bengkel` (`id`, `id_marker`, `profile`, `latlng`, `created`, `updated`) VALUES
(19, '20160002054624', '{"name":"usha","company":"u","contact":"089789678678","email":"nadhif.ahm@gmail.com","location":"u","price":"90"}', '{"lat":"-6.5984485785931035","lng":"110.98526000976562"}', '2016-01-02 05:46:50', '2016-01-14 12:11:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beo_customer`
--

CREATE TABLE `beo_customer` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `profile` text NOT NULL,
  `latlng` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `beo_customer`
--

INSERT INTO `beo_customer` (`id`, `username`, `pass`, `profile`, `latlng`, `created`, `updated`) VALUES
(3, 'n@gmail.com', '123', '{"name":"nadhif","contact":"0852","location":"kajen"}', '{"lat":"-6.7449933","lng":"111.0460305"}', '2016-02-19 22:49:57', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beo_order`
--

CREATE TABLE `beo_order` (
  `id` int(11) NOT NULL,
  `bengkel_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `latlng` text NOT NULL,
  `detail_order` text NOT NULL,
  `type` int(5) NOT NULL COMMENT '1=general, 2=spesifik',
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `beo_order`
--

INSERT INTO `beo_order` (`id`, `bengkel_id`, `customer_id`, `latlng`, `detail_order`, `type`, `created`, `status`) VALUES
(18, 19, 3, '{"lat":"-6.7449933","lng":"111.0460305"}', '{"detail_location":"y","damage":"y","distance":"26.7","total_price":"2403"}', 1, '2016-02-19 23:16:30', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beo_admin`
--
ALTER TABLE `beo_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beo_bengkel`
--
ALTER TABLE `beo_bengkel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beo_customer`
--
ALTER TABLE `beo_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beo_order`
--
ALTER TABLE `beo_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beo_admin`
--
ALTER TABLE `beo_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `beo_bengkel`
--
ALTER TABLE `beo_bengkel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `beo_customer`
--
ALTER TABLE `beo_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `beo_order`
--
ALTER TABLE `beo_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
