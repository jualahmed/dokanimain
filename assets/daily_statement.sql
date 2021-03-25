-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2021 at 09:41 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dokanimain`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_statement`
--

CREATE TABLE `daily_statement` (
  `daily_statement_id` int(11) NOT NULL,
  `purchase` decimal(10,2) NOT NULL,
  `expense` decimal(11,2) NOT NULL,
  `payable_loan` varchar(7) NOT NULL,
  `payable_salary` varchar(7) NOT NULL,
  `payable_total` varchar(7) NOT NULL,
  `sale` decimal(11,2) NOT NULL,
  `receivable_gift` varchar(5) NOT NULL,
  `receivable_loan` varchar(5) NOT NULL,
  `receivable_salary` varchar(7) NOT NULL,
  `receivable_total` varchar(7) NOT NULL,
  `total_investment` varchar(8) NOT NULL,
  `total_withdrawal` varchar(8) NOT NULL,
  `sale_discount` varchar(5) NOT NULL,
  `sale_tot_consd` varchar(7) NOT NULL,
  `sale_average` varchar(7) NOT NULL,
  `stock_current` varchar(16) NOT NULL,
  `stock_opening` varchar(16) NOT NULL,
  `stock_closing` varchar(16) NOT NULL,
  `purchase_total` varchar(7) NOT NULL,
  `transport_cost` varchar(7) NOT NULL,
  `purchase_plus_transport` varchar(7) NOT NULL,
  `cash_in_hand` varchar(10) NOT NULL,
  `cash_in_bank` varchar(10) NOT NULL,
  `total_cash` varchar(16) NOT NULL,
  `cash_in_total` varchar(10) NOT NULL,
  `cash_out_total` varchar(10) NOT NULL,
  `gift_total` varchar(8) NOT NULL,
  `gross_profit` varchar(16) NOT NULL,
  `total_expense` varchar(8) NOT NULL,
  `date` date DEFAULT NULL,
  `net_profit` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_statement`
--
ALTER TABLE `daily_statement`
  ADD PRIMARY KEY (`daily_statement_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_statement`
--
ALTER TABLE `daily_statement`
  MODIFY `daily_statement_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
