-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 24 Nov 2015 pada 03.24
-- Versi Server: 10.1.8-MariaDB
-- PHP Version: 5.6.14

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
  `pass` varchar(30) NOT NULL,
  `last_login` datetime NOT NULL,
  `last_logout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `beo_admin`
--

INSERT INTO `beo_admin` (`id`, `user`, `pass`, `last_login`, `last_logout`) VALUES
(1, 'admin', 'qwerty', '2015-11-24 09:21:40', '2015-11-23 12:36:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beo_bengkel`
--

CREATE TABLE `beo_bengkel` (
  `id` int(11) NOT NULL,
  `id_marker` int(11) NOT NULL,
  `profile` text NOT NULL COMMENT 'bengkel name, company name, contact, email, jam buka, hari libur',
  `location` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `beo_bengkel`
--

INSERT INTO `beo_bengkel` (`id`, `id_marker`, `profile`, `location`, `created`, `updated`) VALUES
(3, 1, '{"name":"izunk","company":"izunk","contact":"izunk","email":"izunk"}', '{"lat":"-7.20036318688991","lng":"112.401123046875"}', '2015-11-21 12:50:57', '2015-11-21 12:51:14'),
(6, 2, '{"name":"ui","company":"i","contact":"iu","email":"i"}', '{"lat":"-6.7055261825665955","lng":"110.88020324707031"}', '2015-11-23 11:54:54', '0000-00-00 00:00:00'),
(8, 4, '{"name":"hjh","company":"j","contact":"hj","email":"hj"}', '{"lat":"-6.768943247435963","lng":"110.96946716308594"}', '2015-11-23 11:55:18', '0000-00-00 00:00:00'),
(10, 3, '{"name":"supor","company":"u","contact":"u","email":"uu"}', '{"lat":"-6.664607562172572","lng":"111.02851867675781"}', '2015-11-23 11:58:16', '0000-00-00 00:00:00'),
(11, 5, '{"name":"hjh","company":"jh","contact":"jh","email":"jhj"}', '{"lat":"-6.669381577573349","lng":"110.75660705566406"}', '2015-11-23 12:01:16', '0000-00-00 00:00:00'),
(12, 6, '{"name":"hjh","company":"jh","contact":"jh","email":"j"}', '{"lat":"-6.72530228551791","lng":"110.77857971191406"}', '2015-11-23 12:01:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beo_request`
--

CREATE TABLE `beo_request` (
  `id` int(11) NOT NULL,
  `profile` int(11) NOT NULL,
  `bengkel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `beo_request`
--
ALTER TABLE `beo_request`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `beo_request`
--
ALTER TABLE `beo_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
