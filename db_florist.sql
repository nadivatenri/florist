-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 11:30 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: florist
--

--
-- Table structure for table login
--

CREATE TABLE login(
  LoginID int (50) NOT NULL,
  Username varchar(255)NOT NULL,
  Sandi varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

---- Dumping data for table login----
INSERT INTO login (LoginID, Username, Sandi) VALUES
(05102024, 'nidipie', 'nidipieaja')

--
-- Table structure for table order
--

CREATE TABLE order (
  OrderID int(50) NOT NULL, AUTO_INCREMENT;
  NamaBunga varchar(255) NOT NULL,
  Quantity int(255) NOT NULL,
  FlowerID int(50) NOT NULL,
  Harga decimal(10,2) NOT NULL,
  Username varchar (255) NOT NULL,
  TotalHarga int(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

---- Dumping data for table order----

INSERT INTO order (OrderID, NamaBunga, Quantity, FlowerID, Harga, Username, TotalHarga) VALUES
(21042000, 'Aurora', 2, , 3108, 500000, 'nidipie', 5000000)

--
-- Table structure for table user
--

CREATE TABLE user (
  UserID int(50) NOT NULL,
  Nama varchar(255) NULL,
  Username  varchar(255) NOT NULL,
  Sandi varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Dumping data for table user
--

INSERT INTO user (UserID, Nama, Username, Sandi, ) VALUES
(20102005, 'nadiva', 'nidipie', 'nidipieaja')

-- --------------------------------------------------------








/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
