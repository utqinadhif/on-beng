SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `onbeng` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `onbeng`;

DROP TABLE IF EXISTS `beo_admin`;
CREATE TABLE `beo_admin` (
  `id` int(11) NOT NULL,
  `user` varchar(30) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `last_logout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `beo_admin` (`id`, `user`, `pass`, `last_login`, `last_logout`) VALUES
(1, 'admin', '9a60c5d1e71e5a3d31b59993878c984750b54a23', '2016-02-16 23:03:54', '2016-02-08 20:53:09');

DROP TABLE IF EXISTS `beo_bengkel`;
CREATE TABLE `beo_bengkel` (
  `id` int(11) NOT NULL,
  `id_marker` varchar(14) NOT NULL,
  `profile` text NOT NULL,
  `latlng` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `beo_bengkel` (`id`, `id_marker`, `profile`, `latlng`, `created`, `updated`) VALUES
(19, '20160002054624', '{"name":"usha","company":"u","contact":"089789678678","email":"nadhif.ahm@gmail.com","location":"u","price":"90"}', '{"lat":"-6.5984485785931035","lng":"110.98526000976562"}', '2016-01-02 05:46:50', '2016-01-14 12:11:26'),
(24, '20160014121148', '{"name":"bj","company":"jh","contact":"78679987987","email":"jh@ga.com","location":"jh","price":"100"}', '{"lat":"-6.683703344568791","lng":"110.85685729980469"}', '2016-01-14 12:12:17', '0000-00-00 00:00:00'),
(25, '20160014121359', '{"name":"hjh","company":"jhj","contact":"6778658","email":"jh@h.com","location":"jh","price":"90"}', '{"lat":"-6.7723525317661215","lng":"110.96054077148438"}', '2016-01-14 12:14:21', '0000-00-00 00:00:00'),
(26, '20160014121422', '{"name":"7686","company":"78678","contact":"687","email":"67@hkj.j","location":"6786","price":"876"}', '{"lat":"-6.794171380507531","lng":"111.14593505859375"}', '2016-01-14 12:14:35', '0000-00-00 00:00:00'),
(27, '20160014121437', '{"name":"jhj","company":"jhgh","contact":"76876","email":"hgh@hjg.c","location":"jhghjg","price":"768"}', '{"lat":"-6.672791560098654","lng":"111.005859375"}', '2016-01-14 12:14:51', '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `beo_customer`;
CREATE TABLE `beo_customer` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `profile` text NOT NULL,
  `latlng` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `beo_customer` (`id`, `username`, `pass`, `profile`, `latlng`, `created`, `updated`) VALUES
(1, 'nadhif.ahm@gmail.com', 'akuqiqi', '{"name":"nadhif","contact":"0852907890989","location":"mbolek"}', '{"lat":"-6.622321400509707","lng":"110.97084045410156"}', '2015-12-07 12:38:34', '2016-01-02 10:32:01'),
(2, 'n@d.com', '123', '{"name":"nadhof","contact":"0897890989","location":"kajen"}', '{"lat":"-6.622321400509707","lng":"110.97084045410156"}', '2015-12-07 12:38:34', '2016-01-02 10:32:01');

DROP TABLE IF EXISTS `beo_request`;
CREATE TABLE `beo_request` (
  `id` int(11) NOT NULL,
  `bengkel_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `latlng` text NOT NULL,
  `detail_location` text NOT NULL,
  `type` int(5) NOT NULL COMMENT '1=general, 2=spesifik',
  `damage` text NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `beo_request` (`id`, `bengkel_id`, `customer_id`, `latlng`, `detail_location`, `type`, `damage`, `created`, `status`) VALUES
(14, 19, 1, '{"lat":"-6.622321400509707","lng":"110.97084045410156"}', 'demak', 1, 'rusak', '2016-01-15 10:37:39', 3),
(15, 24, 1, '{"lat":"-6.622321400509707","lng":"110.97084045410156"}', 'jepara', 1, 'ganti lampu', '2016-01-14 10:37:39', 1),
(16, 27, 1, '{"lat":"-6.7937169","lng":"110.8643921"}', 'cebolek', 2, 'rusak', '2016-02-08 17:52:22', 1);


ALTER TABLE `beo_admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `beo_bengkel`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `beo_customer`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `beo_request`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `beo_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `beo_bengkel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
ALTER TABLE `beo_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `beo_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
