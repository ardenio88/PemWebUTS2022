-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2022 at 12:05 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumah_tangga_panrb`
--

-- --------------------------------------------------------

--
-- Table structure for table `databaseclient`
--

CREATE TABLE `databaseclient` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `namaUsaha` varchar(255) NOT NULL,
  `alamatUsaha` text NOT NULL,
  `golonganUsaha` varchar(255) NOT NULL,
  `modalUsaha` varchar(255) NOT NULL,
  `namaPemilik` varchar(255) NOT NULL,
  `tempatLahir` text NOT NULL,
  `tanggalLahir` date NOT NULL,
  `noTelepon` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fileKTP` varchar(255) NOT NULL,
  `fileNPWP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `databaseclient`
--

INSERT INTO `databaseclient` (`username`, `password`, `namaUsaha`, `alamatUsaha`, `golonganUsaha`, `modalUsaha`, `namaPemilik`, `tempatLahir`, `tanggalLahir`, `noTelepon`, `email`, `fileKTP`, `fileNPWP`) VALUES
('cobaAkun', '42f749ade7f9e195bf475f37a44cafcb', 'Jual beli kodok sawah', 'Palur raya', 'menengah', 'Bank,Koperasi,Bantuan Sosial,Lainnya', 'Mr Sardine', 'Jakartanesia', '2022-09-09', 911, 'kodokmewah88@yahuut.com', '51f09300708dcecf26f403e4f2ec2659.jpg', 'download.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `databaseclient`
--
ALTER TABLE `databaseclient`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
