-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 19 Jun 2013 pada 06.12
-- Versi Server: 5.5.27
-- Versi PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `tebaklagu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data untuk tabel `artist`
--

INSERT INTO `artist` (`id`, `nama`) VALUES
(1, 'Kerispatih'),
(2, 'Noah'),
(3, 'Maudy Ayunda'),
(4, 'Kotak'),
(5, 'Daphne Willis'),
(6, 'Katon Bagaskara'),
(7, 'JKT48'),
(8, 'SNSD');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lagu`
--

CREATE TABLE IF NOT EXISTS `lagu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(120) NOT NULL,
  `id_artist` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data untuk tabel `lagu`
--

INSERT INTO `lagu` (`id`, `judul`, `id_artist`) VALUES
(13, 'Separuh Aku', 2),
(16, 'Perahu Kertas', 3),
(17, 'Tertatih', 1),
(18, 'Mengenangmu', 1),
(19, 'Jujur', 1),
(20, 'Masih Cinta', 4),
(21, 'Do What You Want', 5),
(22, 'Yogyakarta', 6),
(23, 'Jejak Awan Pesawat', 7),
(24, 'LaLaLa', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skor`
--

CREATE TABLE IF NOT EXISTS `skor` (
  `id_user` int(11) NOT NULL,
  `nilai` int(11) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `skor`
--

INSERT INTO `skor` (`id_user`, `nilai`, `tanggal`) VALUES
(6, 100, '2013-06-19 05:43:02'),
(8, 30, '2013-06-19 05:23:42'),
(9, 50, '2013-06-19 05:25:15'),
(10, 50, '2013-06-19 05:27:16'),
(11, 40, '2013-06-19 05:28:49'),
(12, 10, '2013-06-19 05:30:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tebak`
--

CREATE TABLE IF NOT EXISTS `tebak` (
  `id_user` int(11) NOT NULL,
  `mulai_tebak` datetime NOT NULL,
  `terakhir_benar` datetime NOT NULL,
  `urutan_lagu` text NOT NULL,
  `skor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tebak`
--

INSERT INTO `tebak` (`id_user`, `mulai_tebak`, `terakhir_benar`, `urutan_lagu`, `skor`) VALUES
(7, '2013-06-18 21:07:45', '2013-06-18 21:07:45', '21-19-16-22-20-13-17-18', 0),
(6, '2013-06-19 05:49:02', '2013-06-19 05:49:02', '20-18-17-13-21-16-19-24-22-23', 0),
(10, '2013-06-19 06:08:34', '2013-06-19 06:08:34', '13-18-24-17-21-23-22-16-20-19', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `joinDate` datetime NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` text NOT NULL,
  `auth` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `joinDate`, `email`, `password`, `auth`) VALUES
(2, 'tessss', '2013-06-05 03:10:26', 'putuyoga@gmail.coms', '32v5tf sdfds', 1),
(3, 'coba', '2013-06-18 08:04:40', 'putuyoga@gmiaaal.com', '5e0335b1b3da545410951b983cfb34dc', 1),
(5, 'sadsa', '2013-06-18 08:30:16', 'asdsa@asdas.cccs', '4124bc0a9335c27f086f24ba207a4912', 1),
(6, 'putuyoga', '2013-06-18 08:34:18', 'putuyoga@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 255),
(7, 'bondo', '2013-06-18 18:35:50', 'bondo@gmail.com', '500592809f3998df73a7f0d7e275d1b3', 1),
(8, 'ariel', '2013-06-19 05:22:50', 'ariel@ariel.com', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(9, 'benjo', '2013-06-19 05:24:08', 'benjo@lala.com', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(10, 'julian_maho', '2013-06-19 05:25:57', 'julian@maho.com', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(11, 'riko_maho', '2013-06-19 05:27:48', 'rikoadi@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(12, 'pengunjung', '2013-06-19 05:29:31', 'putuyoga@gmiaaal.com', '827ccb0eea8a706c4c34a16891f84e7b', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
