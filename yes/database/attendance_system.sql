-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 04:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `bio` text NOT NULL,
  `images` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `bio`, `images`) VALUES
('U002', 'Udin', 'Baharudin', 'udin.baharudin@binus.ac.id', '3af4c9341e31bce1f4262a326285170d', 'Eyo, what’s up bro?', '/yes/photofile/download.jpeg'),
('U003', 'Udin', 'Petot', 'udinpetot123@gmail.com', '626d47988937e7ce40b788f72994a1da', '', '/yes/photofile/download (1).jpeg'),
('U004', 'Udin', 'Mantap', 'udin.mantap@binus.ac.id', '$2y$10$dPPT103KwZP5BXs1Xz/yNOiBLtjqmQ.vu/0yg.L1s0KhEGaD6pMGm', 'nge test banget nich', '/yes/photofile/bro.jpeg'),
('U005', 'Rafly', 'Prathama', 'raflyprathama21@gmail.com', '$2y$10$Lp/TPzLcRx4lC87er0eO8.HppkEr1j8MDf0ffd0bBGh8aqH.Vecbi', 'nge test lagi nich', '/yes/photofile/ahmed.jpeg'),
('U006', 'Udin', 'sedunia', 'udin@gmail.com', '$2y$10$DxNUCdqpp.FKtKh1NrrJ9.dX8RDtQ7fgGsOof9OlBW3ptE4OtW1SO', 'nge test lagi nich dah oke atau belum', '/yes/photofile/images.jpeg'),
('UD01', 'admin', 'admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'This is admin', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_firstname` (`firstName`),
  ADD KEY `idx_user_lastname` (`lastName`),
  ADD KEY `idx_user_email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
