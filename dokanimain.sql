-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2019 at 10:29 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `apps_info`
--

CREATE TABLE `apps_info` (
  `appin_id` int(11) NOT NULL,
  `version_name` varchar(100) NOT NULL,
  `versoin_no` int(11) NOT NULL,
  `server_activity` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_book`
--

CREATE TABLE `bank_book` (
  `bb_id` int(11) NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `ledger_type` varchar(30) NOT NULL,
  `transaction_id` int(100) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `card_id` int(3) NOT NULL,
  `transaction_type` varchar(3) NOT NULL,
  `bank_name` int(11) NOT NULL,
  `cheque_no` varchar(30) NOT NULL,
  `cheque_date` date NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `creator` int(8) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_book_info`
--

CREATE TABLE `bank_book_info` (
  `bank_book_id` int(20) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `bank_id` int(20) NOT NULL,
  `transaction_type` varchar(20) NOT NULL,
  `amount` double NOT NULL,
  `bank_book_doc` date NOT NULL,
  `bank_book_dom` date NOT NULL,
  `bank_book_creator` int(20) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `reference_id` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_card_info`
--

CREATE TABLE `bank_card_info` (
  `card_id` int(11) NOT NULL,
  `bank_id` int(4) NOT NULL,
  `card_name` varchar(20) NOT NULL,
  `status` tinyint(8) NOT NULL,
  `creator` int(4) NOT NULL,
  `doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_info`
--

CREATE TABLE `bank_info` (
  `bank_id` int(50) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `bank_name` varchar(250) NOT NULL,
  `bank_account_no` varchar(100) NOT NULL,
  `bank_account_name` varchar(250) NOT NULL,
  `bank_description` text,
  `card_account` varchar(2) DEFAULT NULL,
  `bank_status` varchar(50) NOT NULL,
  `bank_creator` int(20) NOT NULL,
  `bank_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bank_dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barcode_print`
--

CREATE TABLE `barcode_print` (
  `print_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `quantity` float NOT NULL,
  `barcode` varchar(250) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `print_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bulk_sale_temp`
--

CREATE TABLE `bulk_sale_temp` (
  `bulk_sale_creator` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `bulk_sale_quantity` int(15) DEFAULT NULL,
  `unit_sale_price` double DEFAULT NULL,
  `unit_buy_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bulk_stock_info`
--

CREATE TABLE `bulk_stock_info` (
  `bulk_id` int(30) NOT NULL,
  `stock_amount` float NOT NULL,
  `product_id` int(30) NOT NULL,
  `shop_id` int(3) NOT NULL,
  `bulk_unit_buy_price` float NOT NULL,
  `bulk_unit_sale_price` float NOT NULL,
  `general_unit_sale_price` float NOT NULL,
  `bulk_alarming_stock` float NOT NULL,
  `last_buy_price` float NOT NULL,
  `warranty_period` int(3) DEFAULT NULL,
  `product_specification` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bulk_stock_info`
--

INSERT INTO `bulk_stock_info` (`bulk_id`, `stock_amount`, `product_id`, `shop_id`, `bulk_unit_buy_price`, `bulk_unit_sale_price`, `general_unit_sale_price`, `bulk_alarming_stock`, `last_buy_price`, `warranty_period`, `product_specification`) VALUES
(1, 12, 1, 1, 16.125, 20.625, 20.625, 100, 10, NULL, NULL),
(2, 3, 2, 1, 1.625, 1.625, 1.625, 100, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cash_book`
--

CREATE TABLE `cash_book` (
  `cb_id` int(11) NOT NULL,
  `transaction_id` int(100) NOT NULL,
  `transaction_type` varchar(3) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `creator` int(8) NOT NULL,
  `doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_book`
--

INSERT INTO `cash_book` (`cb_id`, `transaction_id`, `transaction_type`, `amount`, `date`, `status`, `creator`, `doc`, `dom`) VALUES
(1, 5, 'in', 20, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(2, 6, 'out', 500, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(3, 7, 'out', 500, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(4, 9, 'in', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(5, 10, 'out', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(6, 11, 'out', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(7, 29, 'in', 21, '2019-10-02', 'active', 12, '2019-10-01 18:00:00', '2019-10-01 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `catagory_info`
--

CREATE TABLE `catagory_info` (
  `catagory_id` int(15) NOT NULL,
  `catagory_name` varchar(250) NOT NULL,
  `catagory_description` varchar(250) DEFAULT NULL,
  `catagory_creator` int(15) NOT NULL,
  `catagory_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `catagory_dom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catagory_info`
--

INSERT INTO `catagory_info` (`catagory_id`, `catagory_name`, `catagory_description`, `catagory_creator`, `catagory_doc`, `catagory_dom`) VALUES
(1, 'aaaaaaa', '', 12, '2019-09-30 05:00:09', '2019-09-30 05:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `cheque_info`
--

CREATE TABLE `cheque_info` (
  `cheque_id` int(50) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `cheque_no` varchar(250) NOT NULL,
  `cheque_bank_name` varchar(250) NOT NULL,
  `cheque_account_name` varchar(250) NOT NULL,
  `cheque_account_no` int(250) NOT NULL,
  `cheque_activate_date` date NOT NULL,
  `cheque_clear_date` date NOT NULL,
  `cheque_type` varchar(20) NOT NULL,
  `cheque_status` varchar(30) NOT NULL,
  `cheque_amount` double NOT NULL,
  `cheque_date` date NOT NULL,
  `cheque_doc` date NOT NULL,
  `cheque_dom` date NOT NULL,
  `table_creator` int(11) NOT NULL,
  `my_bank` varchar(30) NOT NULL,
  `total_paid` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cheque_reference_info`
--

CREATE TABLE `cheque_reference_info` (
  `cheque_ref_id` int(100) NOT NULL,
  `cheque_ref_purpose` varchar(250) NOT NULL,
  `ref_id` int(100) NOT NULL,
  `cheque_id` int(100) NOT NULL,
  `transaction_table_ref_name` varchar(250) NOT NULL,
  `transaction_table_ref_id_field` varchar(50) NOT NULL,
  `transaction_type` varchar(250) NOT NULL,
  `transaction_amount` float NOT NULL,
  `cheque_ref_doc` date NOT NULL,
  `cheque_ref_dom` date NOT NULL,
  `cheque_ref_creator` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `last_activity` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_agent` varchar(200) COLLATE utf8_bin NOT NULL,
  `timestamp` varchar(16) COLLATE utf8_bin NOT NULL,
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `commison_info`
--

CREATE TABLE `commison_info` (
  `com_id` int(11) NOT NULL,
  `com_year` int(5) NOT NULL,
  `com_month` int(2) NOT NULL,
  `com_amount` float NOT NULL,
  `status` int(1) NOT NULL,
  `creator` int(8) NOT NULL,
  `doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `company_id` int(15) NOT NULL,
  `company_name` varchar(250) NOT NULL,
  `company_address` tinytext NOT NULL,
  `company_contact_no` int(100) NOT NULL,
  `company_email` varchar(250) NOT NULL,
  `company_description` text NOT NULL,
  `company_creator` varchar(250) NOT NULL,
  `company_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`company_id`, `company_name`, `company_address`, `company_contact_no`, `company_email`, `company_description`, `company_creator`, `company_doc`, `company_dom`) VALUES
(1, 'aaaaaaaa', 'saf', 123456789, 'sdf', 'sdf', '12', '2019-09-30 05:00:23', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `customer_id` int(100) NOT NULL,
  `customer_name` varchar(250) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `customer_define_id` int(20) DEFAULT NULL,
  `customer_contact_no` varchar(250) DEFAULT NULL,
  `customer_type` varchar(250) NOT NULL,
  `customer_mode` char(10) NOT NULL,
  `customer_address` varchar(250) DEFAULT NULL,
  `customer_email` varchar(250) DEFAULT NULL,
  `int_balance` float NOT NULL,
  `customer_creator` varchar(250) NOT NULL,
  `customer_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`customer_id`, `customer_name`, `user_id`, `customer_define_id`, `customer_contact_no`, `customer_type`, `customer_mode`, `customer_address`, `customer_email`, `int_balance`, `customer_creator`, `customer_doc`, `customer_dom`) VALUES
(1, 'QUICK_SALE', 1, 1, '0147896', '1', '0', 'sf', 'QUICK_SALE@GMAIL.COM', 1, '12', '2019-07-25 07:41:39', '2019-09-02 08:03:21'),
(2, 'fff', 0, NULL, '121', 'sdfsdf', '1212', 'sdf', 'sdf', 0, '12', '2019-09-23 05:39:53', '0000-00-00 00:00:00'),
(3, '1111111111111', 0, NULL, '232', '232', '323', '23', '22222222222', 23, '12', '2019-09-23 05:40:19', '0000-00-00 00:00:00'),
(4, 'ddddddddd', 0, NULL, '12312', '123', '213', '3123', 'dddddddddd', 213, '12', '2019-09-23 05:40:49', '0000-00-00 00:00:00'),
(5, 'sdgdg', 0, NULL, '123123', 'sdf', '123123', 'sfsf', 'sfsdf', 0, '12', '2019-09-23 05:42:15', '0000-00-00 00:00:00'),
(6, 'sdfsd', 0, NULL, '123123', '21312', '3', '123112', 'sdf', 0, '12', '2019-09-23 05:42:44', '0000-00-00 00:00:00'),
(7, 'aaaaaaaa', 0, NULL, '11', 'aaaaa', '1', '1231a12', 'sdfs', 0, '12', '2019-09-23 05:43:02', '0000-00-00 00:00:00'),
(8, 'A', 0, NULL, '1', 'AD', '1', 'ASD', 'SD', 1, '12', '2019-09-29 04:07:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `daily_statement`
--

CREATE TABLE `daily_statement` (
  `daily_statement_id` int(11) NOT NULL,
  `statement_date` varchar(14) NOT NULL,
  `payable_purchase` varchar(7) NOT NULL,
  `payable_expense` varchar(5) NOT NULL,
  `payable_loan` varchar(7) NOT NULL,
  `payable_salary` varchar(7) NOT NULL,
  `payable_total` varchar(7) NOT NULL,
  `receivable_sale` varchar(7) NOT NULL,
  `receivable_gift` varchar(5) NOT NULL,
  `receivable_loan` varchar(5) NOT NULL,
  `receivable_salary` varchar(7) NOT NULL,
  `receivable_total` varchar(7) NOT NULL,
  `total_investment` varchar(8) NOT NULL,
  `total_withdrawal` varchar(8) NOT NULL,
  `sale_total` varchar(7) NOT NULL,
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
  `net_profit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `damage_product`
--

CREATE TABLE `damage_product` (
  `damage_id` int(11) NOT NULL,
  `product_id` int(100) NOT NULL,
  `damage_quantity` int(5) NOT NULL,
  `unit_buy_price` varchar(20) NOT NULL,
  `creator` int(8) NOT NULL,
  `doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_retrive_checking`
--

CREATE TABLE `data_retrive_checking` (
  `drc_id` int(11) NOT NULL,
  `drc_name` varchar(250) CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `discount_details`
--

CREATE TABLE `discount_details` (
  `discount_details_id` int(12) NOT NULL,
  `discount_info_id` int(10) NOT NULL,
  `discount` int(4) NOT NULL,
  `quantity` int(4) NOT NULL,
  `discount_type` int(1) NOT NULL,
  `creator` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `doc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discount_info`
--

CREATE TABLE `discount_info` (
  `discount_info_id` int(10) NOT NULL,
  `product_id` int(6) NOT NULL,
  `shop_id` int(3) NOT NULL,
  `validate_quantity` int(4) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `creator` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `doc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dishonour_cheque_book`
--

CREATE TABLE `dishonour_cheque_book` (
  `cheque_book_id` int(100) NOT NULL,
  `cheque_id` int(100) NOT NULL,
  `cheque_book_amount` double NOT NULL,
  `cheque_book_doc` date NOT NULL,
  `cheque_book_dom` date NOT NULL,
  `cheque_book_creator` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_info`
--

CREATE TABLE `distributor_info` (
  `distributor_id` int(100) NOT NULL,
  `distributor_name` varchar(250) NOT NULL,
  `distributor_address` varchar(250) NOT NULL,
  `distributor_contact_no` varchar(250) NOT NULL,
  `distributor_email` varchar(250) NOT NULL,
  `distributor_description` varchar(250) NOT NULL,
  `int_balance` float NOT NULL,
  `distributor_creator` varchar(250) NOT NULL,
  `distributor_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `distributor_dom` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distributor_info`
--

INSERT INTO `distributor_info` (`distributor_id`, `distributor_name`, `distributor_address`, `distributor_contact_no`, `distributor_email`, `distributor_description`, `int_balance`, `distributor_creator`, `distributor_doc`, `distributor_dom`) VALUES
(1, 'sdf', 'fdsf', '123', '13123', '12', 1, '12', '2019-09-30 05:01:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `employee_id` int(100) NOT NULL,
  `employee_name` varchar(250) DEFAULT NULL,
  `employee_contact_no` varchar(250) DEFAULT NULL,
  `employee_type` varchar(250) NOT NULL,
  `employee_address` varchar(250) DEFAULT NULL,
  `employee_email` varchar(250) DEFAULT NULL,
  `int_balance` float NOT NULL,
  `employee_creator` varchar(250) NOT NULL,
  `employee_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `employee_dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary`
--

CREATE TABLE `employee_salary` (
  `salary_id` int(6) NOT NULL,
  `user_id` int(4) NOT NULL,
  `salary_amount` double NOT NULL,
  `extra_payment` double DEFAULT NULL,
  `reduced_amount` double DEFAULT NULL,
  `salary_status` tinyint(1) NOT NULL,
  `salary_creator` int(4) NOT NULL,
  `salary_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary_log`
--

CREATE TABLE `employee_salary_log` (
  `salary_log_id` int(6) NOT NULL,
  `user_id` int(4) NOT NULL,
  `salary_amount` double NOT NULL,
  `extra_payment` double NOT NULL,
  `reduced_amount` double NOT NULL,
  `salary_month` char(5) NOT NULL,
  `salary_year` int(4) NOT NULL,
  `mode` char(10) NOT NULL,
  `salary_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `salary_creator` int(4) NOT NULL,
  `salary_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exchange_return_details_tbl`
--

CREATE TABLE `exchange_return_details_tbl` (
  `id` int(5) NOT NULL,
  `exchange_return_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `exchange_quantity` int(5) NOT NULL,
  `unit_price` float NOT NULL,
  `total_price` float NOT NULL,
  `status1` varchar(10) NOT NULL,
  `status2` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exchange_return_tbl`
--

CREATE TABLE `exchange_return_tbl` (
  `exchange_return_id` int(5) NOT NULL,
  `exchange_return_creator` int(5) NOT NULL,
  `status` varchar(8) NOT NULL,
  `total_amount_ex` float NOT NULL,
  `total_amount_re` float NOT NULL,
  `exchange_return_doc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expense_info`
--

CREATE TABLE `expense_info` (
  `expense_id` int(100) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `service_provider_id` int(100) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `expense_type` varchar(250) NOT NULL,
  `expense_amount` float NOT NULL,
  `expense_details` varchar(250) NOT NULL,
  `total_paid` float DEFAULT NULL,
  `expense_creator` varchar(250) NOT NULL,
  `expense_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expense_dom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gift_details`
--

CREATE TABLE `gift_details` (
  `gift_id` int(10) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `gift_from` int(10) NOT NULL,
  `gift_amount` double NOT NULL,
  `gift_doc` date NOT NULL,
  `gift_description` text NOT NULL,
  `gift_creator` int(100) NOT NULL,
  `gift_mode` varchar(250) NOT NULL,
  `total_paid` float NOT NULL,
  `gift_status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_info`
--

CREATE TABLE `group_info` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `group_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image_for_sale_listing`
--

CREATE TABLE `image_for_sale_listing` (
  `ifsl_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `remarks` text NOT NULL,
  `image` varchar(6) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `income_info`
--

CREATE TABLE `income_info` (
  `income_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `service_provider_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `income_type` varchar(255) NOT NULL,
  `income_amount` float NOT NULL,
  `income_details` varchar(255) NOT NULL,
  `total_paid` float DEFAULT NULL,
  `income_creator` int(11) NOT NULL,
  `income_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `income_dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investment_info`
--

CREATE TABLE `investment_info` (
  `investment_id` int(25) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `investor_id` int(25) NOT NULL,
  `investment_details` varchar(250) NOT NULL,
  `investment_amount` float NOT NULL,
  `total_paid` float NOT NULL,
  `investment_doc` date NOT NULL,
  `investment_dom` date NOT NULL,
  `investment_creator` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investor_info`
--

CREATE TABLE `investor_info` (
  `investor_id` int(25) NOT NULL,
  `investor_name` varchar(250) NOT NULL,
  `investor_contact_no` varchar(250) NOT NULL,
  `investor_email` varchar(250) NOT NULL,
  `investor_address` varchar(250) NOT NULL,
  `investor_description` varchar(250) NOT NULL,
  `investor_doc` date NOT NULL,
  `investor_dom` date NOT NULL,
  `investor_creator` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_info`
--

CREATE TABLE `invoice_info` (
  `invoice_id` int(100) NOT NULL,
  `shop_id` int(3) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `total_price` float NOT NULL,
  `discount` float NOT NULL,
  `discount_type` tinyint(1) NOT NULL,
  `cash_commision` float NOT NULL,
  `discount_amount` float NOT NULL,
  `delivery_charge` float NOT NULL,
  `grand_total` float NOT NULL,
  `total_paid` float NOT NULL,
  `sale_return_amount` float NOT NULL,
  `return_money` float DEFAULT NULL,
  `payment_mode` varchar(300) NOT NULL,
  `invoice_creator` varchar(300) NOT NULL,
  `invoice_doc` date NOT NULL,
  `invoice_dom` date NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `point_info_id` int(11) NOT NULL,
  `point_discount` int(11) NOT NULL,
  `current_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_info`
--

INSERT INTO `invoice_info` (`invoice_id`, `shop_id`, `customer_id`, `total_price`, `discount`, `discount_type`, `cash_commision`, `discount_amount`, `delivery_charge`, `grand_total`, `total_paid`, `sale_return_amount`, `return_money`, `payment_mode`, `invoice_creator`, `invoice_doc`, `invoice_dom`, `date_time`, `point_info_id`, `point_discount`, `current_point`) VALUES
(2, 1, 3, 50, 0, 0, 0, 0, 0, 50, 50, 0, 0, 'cash', '12', '2019-09-30', '2019-09-30', '2019-09-30 07:56:28', 0, 0, 0),
(3, 1, 1, 21, 0, 0, 0, 0, 0, 21, 21, 0, 0, 'cash', '12', '2019-10-02', '2019-10-02', '2019-10-02 04:14:32', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `loan_details_info`
--

CREATE TABLE `loan_details_info` (
  `loan_details_id` int(10) NOT NULL,
  `loan_mode` tinyint(2) NOT NULL,
  `loan_seeker_id` int(10) NOT NULL,
  `loan_amount` double NOT NULL,
  `total_paid` double NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `receive_amount` int(8) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL,
  `creator` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_person_info`
--

CREATE TABLE `loan_person_info` (
  `lp_id` int(100) NOT NULL,
  `loan_person_name` varchar(250) NOT NULL,
  `loan_person_type` varchar(250) NOT NULL,
  `loan_person_contact` varchar(250) NOT NULL,
  `loan_person_address` varchar(250) NOT NULL,
  `loan_person_email` varchar(250) NOT NULL,
  `loan_person_description` text NOT NULL,
  `loan_person_doc` date NOT NULL,
  `loan_person_dom` date NOT NULL,
  `loan_person_creator` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_seeker_info`
--

CREATE TABLE `loan_seeker_info` (
  `loan_seeker_id` int(10) NOT NULL,
  `loan_seeker_name` varchar(25) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `email_address` varchar(20) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `doc` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `creator` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(100) NOT NULL,
  `ip_address` varchar(250) COLLATE utf8_bin NOT NULL,
  `login` varchar(250) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `owner_book`
--

CREATE TABLE `owner_book` (
  `ob_id` int(11) NOT NULL,
  `transaction_id` int(100) NOT NULL,
  `cash_cheque` varchar(10) NOT NULL,
  `transaction_type` varchar(3) NOT NULL,
  `cheque_no` varchar(30) NOT NULL,
  `cheque_date` date NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `creator` int(8) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `owner_info`
--

CREATE TABLE `owner_info` (
  `owner_id` int(100) NOT NULL,
  `owner_name` varchar(250) NOT NULL,
  `owner_type` varchar(250) NOT NULL,
  `owner_contact` varchar(250) NOT NULL,
  `owner_address` varchar(250) NOT NULL,
  `owner_email` varchar(250) NOT NULL,
  `owner_description` text NOT NULL,
  `owner_doc` date NOT NULL,
  `owner_dom` date NOT NULL,
  `owner_creator` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `point_info`
--

CREATE TABLE `point_info` (
  `point_id` int(11) NOT NULL,
  `customer_id` int(30) NOT NULL,
  `total_point` int(20) NOT NULL,
  `withdraw_point` int(11) NOT NULL,
  `remain_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `product_id` int(100) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `catagory_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `product_type` varchar(250) DEFAULT NULL,
  `product_size` varchar(250) NOT NULL,
  `product_model` varchar(250) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `product_description` varchar(250) DEFAULT NULL,
  `product_specification` int(3) NOT NULL,
  `product_warranty` int(11) NOT NULL,
  `product_creator` int(10) DEFAULT NULL,
  `product_status` tinyint(1) DEFAULT '1',
  `img` varchar(255) NOT NULL,
  `product_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_dom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`product_id`, `product_name`, `catagory_id`, `company_id`, `group_name`, `product_type`, `product_size`, `product_model`, `unit_id`, `barcode`, `product_description`, `product_specification`, `product_warranty`, `product_creator`, `product_status`, `img`, `product_doc`, `product_dom`) VALUES
(1, 'Simplecheck', 1, 1, NULL, NULL, '1', '', 1, '407207081', NULL, 1, 0, 12, 1, '', '2019-09-30 05:01:07', '2019-09-30 05:01:07'),
(2, 'abcdefghijklmn', 1, 1, NULL, NULL, '', '', 1, '1', NULL, 2, 12, 12, 1, '', '2019-09-30 05:12:44', '2019-09-30 05:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_info`
--

CREATE TABLE `purchase_info` (
  `purchase_id` int(100) NOT NULL,
  `purchase_receipt_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `purchase_quantity` float NOT NULL,
  `unit_buy_price` float NOT NULL,
  `purchase_expire_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `purchase_description` text NOT NULL,
  `purchase_creator` varchar(250) NOT NULL,
  `purchase_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `purchase_dom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_info`
--

INSERT INTO `purchase_info` (`purchase_id`, `purchase_receipt_id`, `product_id`, `purchase_quantity`, `unit_buy_price`, `purchase_expire_date`, `purchase_description`, `purchase_creator`, `purchase_doc`, `purchase_dom`) VALUES
(1, 1, 1, 10, 10, '2019-09-29 18:00:00', 'a test purchase_receipt_id', '12', '2019-09-30 05:07:05', '2019-09-30 05:07:05'),
(2, 1, 2, 1, 11, '2019-09-29 18:00:00', 'a test purchase_receipt_id', '12', '2019-09-30 05:13:08', '2019-09-30 05:13:08'),
(3, 1, 1, 15, 15, '2019-09-29 18:00:00', 'a test purchase_receipt_id', '12', '2019-09-30 08:49:48', '2019-09-30 08:49:48'),
(4, 1, 1, 50, 50, '2019-09-29 18:00:00', 'a test purchase_receipt_id', '12', '2019-09-30 08:53:24', '2019-09-30 08:53:24'),
(5, 1, 2, 1, 1, '2019-09-30 18:00:00', 'a test purchase_receipt_id', '12', '2019-10-01 04:09:34', '2019-10-01 04:09:34'),
(6, 1, 2, 2, 1, '2019-09-30 18:00:00', 'a test purchase_receipt_id', '12', '2019-10-01 04:13:23', '2019-10-01 04:13:23'),
(7, 1, 2, 2, 1, '2019-09-30 18:00:00', 'a test purchase_receipt_id', '12', '2019-10-01 04:34:34', '2019-10-01 04:34:34'),
(8, 1, 2, 3, 1, '2019-09-30 18:00:00', 'a test purchase_receipt_id', '12', '2019-10-01 04:55:03', '2019-10-01 04:55:03'),
(9, 1, 1, 10, 1, '2019-09-30 18:00:00', 'a test purchase_receipt_id', '12', '2019-10-01 11:12:01', '2019-10-01 11:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_receipt_info`
--

CREATE TABLE `purchase_receipt_info` (
  `receipt_id` int(100) NOT NULL,
  `distributor_id` int(100) NOT NULL,
  `purchase_amount` float NOT NULL,
  `transport_cost` float DEFAULT NULL,
  `gift_on_purchase` float DEFAULT NULL,
  `final_amount` int(11) NOT NULL,
  `shop_id` int(3) NOT NULL,
  `receipt_status` varchar(250) NOT NULL,
  `total_paid` float NOT NULL,
  `receipt_date` date NOT NULL,
  `receipt_creator` int(100) NOT NULL,
  `receipt_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `receipt_dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_receipt_info`
--

INSERT INTO `purchase_receipt_info` (`receipt_id`, `distributor_id`, `purchase_amount`, `transport_cost`, `gift_on_purchase`, `final_amount`, `shop_id`, `receipt_status`, `total_paid`, `receipt_date`, `receipt_creator`, `receipt_doc`, `receipt_dom`) VALUES
(1, 1, 1000, 0, 0, 1000, 1, 'unpaid', 0, '2019-09-30', 12, '2019-09-30 05:06:43', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_main_product`
--

CREATE TABLE `purchase_return_main_product` (
  `prmp_id` int(11) NOT NULL,
  `distri_id` int(11) NOT NULL,
  `produ_id` int(11) NOT NULL,
  `return_quantity` float NOT NULL,
  `buy_price` float NOT NULL,
  `status` int(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_return_main_product`
--

INSERT INTO `purchase_return_main_product` (`prmp_id`, `distri_id`, `produ_id`, `return_quantity`, `buy_price`, `status`, `creator`, `doc`, `dom`) VALUES
(1, 1, 1, 5, 10, 1, 12, '2019-09-30', '2019-09-30'),
(2, 1, 2, 1, 11, 1, 12, '2019-09-30', '2019-09-30'),
(9, 1, 1, 110, 10, 1, 12, '2019-09-30', '2019-09-30'),
(10, 1, 1, 15, 12.5, 1, 12, '2019-09-30', '2019-09-30'),
(17, 1, 2, 1, 6, 1, 12, '2019-10-01', '2019-10-01'),
(19, 1, 2, 1, 3.5, 1, 12, '2019-10-01', '2019-10-01'),
(23, 1, 2, 3, 2.25, 1, 12, '2019-10-01', '2019-10-01'),
(28, 1, 1, 10, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(29, 1, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(30, 0, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(31, 1, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(32, 1, 1, 5, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(33, 1, 1, 10, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(34, 1, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(35, 1, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(36, 1, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(37, 1, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(38, 1, 1, 2, 31.25, 1, 12, '2019-10-01', '2019-10-01'),
(39, 1, 1, 1, 31.25, 1, 12, '2019-10-01', '2019-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_warranty_product`
--

CREATE TABLE `purchase_return_warranty_product` (
  `prwp_id` int(11) NOT NULL,
  `prmp_id` int(11) NOT NULL,
  `ip_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sl_no` varchar(250) NOT NULL,
  `warranty_period` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_return_warranty_product`
--

INSERT INTO `purchase_return_warranty_product` (`prwp_id`, `prmp_id`, `ip_id`, `product_id`, `sl_no`, `warranty_period`, `status`, `creator`, `doc`, `dom`) VALUES
(1, 2, 1, 2, '11111', 0, 1, 12, '2019-09-30', '2019-09-30'),
(2, 17, 2, 2, '2147483647', 0, 1, 12, '2019-10-01', '2019-10-01'),
(4, 19, 4, 2, '34', 0, 1, 12, '2019-10-01', '2019-10-01'),
(9, 23, 3, 2, '12', 0, 1, 12, '2019-10-01', '2019-10-01'),
(10, 23, 5, 2, '546456', 0, 1, 12, '2019-10-01', '2019-10-01'),
(11, 23, 6, 2, '456456456', 0, 1, 12, '2019-10-01', '2019-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `sale_details_id` int(100) NOT NULL,
  `invoice_id` int(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock_id` int(100) NOT NULL,
  `sale_quantity` float NOT NULL,
  `sale_type` int(1) NOT NULL,
  `discount_info_id` int(10) NOT NULL,
  `discount` float NOT NULL,
  `discount_type` int(1) NOT NULL,
  `unit_sale_price` double NOT NULL,
  `general_sale_price` float NOT NULL,
  `unit_buy_price` double NOT NULL,
  `actual_sale_price` double NOT NULL,
  `product_specification` varchar(250) NOT NULL,
  `exact_sale_price` double NOT NULL,
  `sale_details_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`sale_details_id`, `invoice_id`, `product_id`, `stock_id`, `sale_quantity`, `sale_type`, `discount_info_id`, `discount`, `discount_type`, `unit_sale_price`, `general_sale_price`, `unit_buy_price`, `actual_sale_price`, `product_specification`, `exact_sale_price`, `sale_details_status`) VALUES
(2, 2, 1, 0, 5, 1, 0, 0, 0, 10, 10, 10, 10, '', 10, 1),
(3, 3, 1, 0, 1, 1, 0, 0, 0, 21, 21, 16.125, 21, '', 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_price_info`
--

CREATE TABLE `sale_price_info` (
  `sp_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `shop_id` double NOT NULL,
  `alarming_stock` int(100) NOT NULL,
  `warranty` int(100) NOT NULL,
  `unit_sale_price` double NOT NULL,
  `whole_sale_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_details_tbl`
--

CREATE TABLE `sale_return_details_tbl` (
  `id` int(11) NOT NULL,
  `sale_return_id` int(11) NOT NULL,
  `product_id` int(8) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `return_quantity` int(5) NOT NULL,
  `unit_buy_price` float NOT NULL,
  `unit_sale_price` float NOT NULL,
  `total_price` float NOT NULL,
  `return_doc` date NOT NULL,
  `return_dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_list`
--

CREATE TABLE `sale_return_list` (
  `srl_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `return_adjustment` float NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_return_list`
--

INSERT INTO `sale_return_list` (`srl_id`, `total_amount`, `return_adjustment`, `type`, `status`, `creator`, `doc`, `dom`) VALUES
(1, 500, 500, 'cashreturn', 0, 12, '2019-09-30', '2019-09-30'),
(2, 500, 1000, 'cashreturn', 0, 12, '2019-09-30', '2019-09-30'),
(3, 50, 50, 'cashreturn', 0, 12, '2019-09-30', '2019-09-30'),
(4, 0, 0, 'cashreturn', 0, 12, '2019-09-30', '2019-09-30'),
(5, 50, 100, 'cashreturn', 0, 12, '2019-09-30', '2019-09-30'),
(6, 0, 0, 'cashreturn', 0, 12, '2019-10-01', '2019-10-01'),
(7, 0, 0, 'cashreturn', 0, 12, '2019-10-02', '2019-10-02'),
(8, 0, 0, 'cashreturn', 0, 12, '2019-10-02', '2019-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_main_product`
--

CREATE TABLE `sale_return_main_product` (
  `srmp_id` int(11) NOT NULL,
  `return_list_id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `produ_id` int(11) NOT NULL,
  `return_quantity` float NOT NULL,
  `exact_price` float NOT NULL,
  `status` int(1) NOT NULL,
  `type` varchar(20) NOT NULL,
  `creator` int(11) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_return_main_product`
--

INSERT INTO `sale_return_main_product` (`srmp_id`, `return_list_id`, `inv_id`, `customer`, `produ_id`, `return_quantity`, `exact_price`, `status`, `type`, `creator`, `doc`, `dom`) VALUES
(1, 1, 1, 1, 1, 50, 10, 1, 'cashreturn', 12, '2019-09-30', '2019-09-30'),
(2, 2, 1, 1, 1, 50, 10, 1, 'cashreturn', 12, '2019-09-30', '2019-09-30'),
(3, 3, 2, 3, 1, 5, 10, 1, 'cashreturn', 12, '2019-09-30', '2019-09-30'),
(5, 5, 2, 3, 1, 5, 10, 1, 'cashreturn', 12, '2019-09-30', '2019-09-30'),
(6, 8, 3, 0, 1, 1, 21, 0, 'cashreturn', 12, '2019-10-02', '2019-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_receipt_tbl`
--

CREATE TABLE `sale_return_receipt_tbl` (
  `sale_return_id` int(8) NOT NULL,
  `shop_id` int(3) NOT NULL,
  `total_return_amount` float NOT NULL,
  `status` varchar(10) NOT NULL,
  `status2` varchar(15) NOT NULL,
  `creator` varchar(100) NOT NULL,
  `sale_return_doc` varchar(20) NOT NULL,
  `sale_return_dom` varchar(20) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_warranty_product`
--

CREATE TABLE `sale_return_warranty_product` (
  `srwp_id` int(11) NOT NULL,
  `srmp_id` int(11) NOT NULL,
  `ip_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `sl_no` varchar(250) NOT NULL,
  `sale_date` date NOT NULL,
  `sale_price` float NOT NULL,
  `warranty_period` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `doc` date NOT NULL,
  `dom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_running_info`
--

CREATE TABLE `sale_running_info` (
  `sale_running_id` int(100) NOT NULL,
  `sale_running_mode` varchar(250) NOT NULL,
  `sale_creator` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_info`
--

CREATE TABLE `service_provider_info` (
  `service_provider_id` int(100) NOT NULL,
  `service_provider_name` varchar(250) NOT NULL,
  `service_provider_type` varchar(250) NOT NULL,
  `service_provider_contact` varchar(250) NOT NULL,
  `service_provider_address` varchar(250) NOT NULL,
  `service_provider_email` varchar(250) NOT NULL,
  `service_provider_description` text NOT NULL,
  `service_provider_doc` date NOT NULL,
  `service_provider_dom` date NOT NULL,
  `service_provider_creator` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop_setup`
--

CREATE TABLE `shop_setup` (
  `shop_id` int(3) NOT NULL,
  `shop_name` char(100) NOT NULL,
  `logo` text NOT NULL,
  `invoicelogo` text NOT NULL,
  `shop_type` char(8) NOT NULL,
  `shop_address` char(150) NOT NULL,
  `shop_status` tinyint(1) NOT NULL,
  `shop_contact` char(15) NOT NULL,
  `one_point_equal` int(20) NOT NULL,
  `one_taka_equal` int(20) NOT NULL,
  `shop_creator` int(10) NOT NULL,
  `shop_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_setup`
--

INSERT INTO `shop_setup` (`shop_id`, `shop_name`, `logo`, `invoicelogo`, `shop_type`, `shop_address`, `shop_status`, `shop_contact`, `one_point_equal`, `one_taka_equal`, `shop_creator`, `shop_doc`) VALUES
(1, 'Demo Dokani', '', 'cc954b60196773384ed288fe7c9ec23c.jpg', 'Main', 'Sylhet', 1, '123456', 1, 100, 11, '2019-09-26 05:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `stock_info`
--

CREATE TABLE `stock_info` (
  `stock_id` int(100) NOT NULL,
  `product_id` int(8) NOT NULL,
  `shop_id` int(4) NOT NULL,
  `purchase_id` int(100) NOT NULL,
  `serial_no` varchar(250) NOT NULL,
  `stock_status` varchar(250) NOT NULL,
  `stock_creator` varchar(250) NOT NULL,
  `stock_doc` date NOT NULL,
  `stock_dom` date NOT NULL,
  `listed_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sale_details`
--

CREATE TABLE `temp_sale_details` (
  `temp_sale_details_id` int(12) NOT NULL,
  `temp_sale_id` int(10) NOT NULL,
  `product_id` int(5) NOT NULL,
  `stock_id` int(8) NOT NULL,
  `sale_quantity` double NOT NULL,
  `product_specification` varchar(15) NOT NULL,
  `sale_type` int(1) NOT NULL,
  `discount_info_id` int(10) NOT NULL,
  `discount` int(5) NOT NULL,
  `discount_type` int(1) NOT NULL,
  `unit_buy_price` double NOT NULL,
  `unit_sale_price` double NOT NULL,
  `general_unit_sale_price` float NOT NULL,
  `actual_sale_price` double NOT NULL,
  `temp_sale_details_status` tinyint(1) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `stock` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sale_info`
--

CREATE TABLE `temp_sale_info` (
  `temp_sale_id` int(10) NOT NULL,
  `temp_sale_shop_id` int(3) NOT NULL,
  `temp_sale_type` varchar(10) NOT NULL,
  `temp_customer_id` int(11) NOT NULL,
  `temp_sale_creator` int(4) NOT NULL,
  `temp_sale_status` tinyint(1) NOT NULL,
  `return_id` int(11) NOT NULL,
  `return_adjust_amount` float NOT NULL,
  `pre_invoice_status` varchar(20) NOT NULL,
  `temp_sale_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_sale_info`
--

INSERT INTO `temp_sale_info` (`temp_sale_id`, `temp_sale_shop_id`, `temp_sale_type`, `temp_customer_id`, `temp_sale_creator`, `temp_sale_status`, `return_id`, `return_adjust_amount`, `pre_invoice_status`, `temp_sale_doc`) VALUES
(5, 1, '', 0, 12, 1, 0, 0, '', '2019-10-02 04:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_cash_sale_return_details_tbl`
--

CREATE TABLE `tmp_cash_sale_return_details_tbl` (
  `id` int(5) NOT NULL,
  `tmp_cash_sale_return_id` int(1) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `return_quantity` int(5) NOT NULL,
  `buy_price` float NOT NULL,
  `unit_price` float NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_cash_sale_return_tbl`
--

CREATE TABLE `tmp_cash_sale_return_tbl` (
  `tmp_cash_sale_return_id` int(5) NOT NULL,
  `tmp_cash_sale_return_creator` int(5) NOT NULL,
  `status` varchar(8) NOT NULL,
  `total_amount` float NOT NULL,
  `tmp_cash_sale_return_doc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_purchase_return_details_tbl`
--

CREATE TABLE `tmp_purchase_return_details_tbl` (
  `id` int(5) NOT NULL,
  `tmp_purchase_return_id` int(5) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `return_quantity` float NOT NULL,
  `unit_buy_price` float NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_purchase_return_tbl`
--

CREATE TABLE `tmp_purchase_return_tbl` (
  `tmp_purchase_return_id` int(5) NOT NULL,
  `tmp_purchase_id` int(5) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `tmp_purchase_return_shop_id` int(5) NOT NULL,
  `tmp_purchase_return_creator` int(5) NOT NULL,
  `status` varchar(8) NOT NULL,
  `total_amount` float NOT NULL,
  `tmp_purchase_return_doc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_sale_return_details_tbl`
--

CREATE TABLE `tmp_sale_return_details_tbl` (
  `id` int(5) NOT NULL,
  `tmp_sale_return_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `return_quantity` int(5) NOT NULL,
  `buy_price` float NOT NULL,
  `unit_price` float NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_sale_return_tbl`
--

CREATE TABLE `tmp_sale_return_tbl` (
  `tmp_sale_return_id` int(5) NOT NULL,
  `tmp_sale_id` int(5) NOT NULL,
  `tmp_sale_return_shop_id` int(5) NOT NULL,
  `tmp_sale_return_creator` int(5) NOT NULL,
  `status` varchar(8) NOT NULL,
  `total_amount` float NOT NULL,
  `tmp_sale_return_doc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `transaction_id` int(100) NOT NULL,
  `transaction_receipt_id` int(15) NOT NULL,
  `shop_id` int(3) NOT NULL,
  `transaction_type` varchar(250) NOT NULL,
  `transaction_amount` float NOT NULL,
  `transaction_mode` varchar(250) NOT NULL,
  `transaction_reference_id` int(100) NOT NULL,
  `transaction_doc` date NOT NULL,
  `transaction_dom` date NOT NULL,
  `transaction_creator` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_info`
--

CREATE TABLE `transaction_info` (
  `transaction_id` int(11) NOT NULL,
  `transaction_purpose` varchar(100) NOT NULL,
  `transaction_mode` varchar(100) NOT NULL,
  `ledger_id` int(100) NOT NULL,
  `common_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `remarks` tinytext NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `creator` int(8) NOT NULL,
  `doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_info`
--

INSERT INTO `transaction_info` (`transaction_id`, `transaction_purpose`, `transaction_mode`, `ledger_id`, `common_id`, `sub_id`, `remarks`, `amount`, `date`, `status`, `creator`, `doc`, `dom`) VALUES
(1, 'purchase', '', 1, 1, 0, '', 1000, '2019-09-30', 'active', 12, '2019-09-30 05:06:44', '0000-00-00 00:00:00'),
(2, 'purchase_return', '', 1, 0, 0, '', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(3, 'purchase_return', '', 1, 0, 0, '', 11, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(4, 'sale', '', 1, 1, 0, '', 20, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(5, 'collection', 'cash', 1, 1, 0, '', 20, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(6, 'sale_return', 'cash', 1, 0, 1, '', 500, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(7, 'sale_return', 'cash', 1, 0, 2, '', 500, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(8, 'sale', '', 3, 2, 0, '', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(9, 'collection', 'cash', 3, 2, 0, '', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(10, 'sale_return', 'cash', 3, 0, 3, '', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(11, 'sale_return', 'cash', 3, 0, 5, '', 50, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(12, 'purchase_return', '', 1, 0, 0, '', 1100, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(13, 'purchase_return', '', 1, 0, 0, '', 187.5, '2019-09-30', 'active', 12, '2019-09-29 18:00:00', '2019-09-29 18:00:00'),
(14, 'purchase_return', '', 1, 0, 0, '', 6, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(15, 'purchase_return', '', 1, 0, 0, '', 3.5, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(16, 'purchase_return', '', 1, 0, 0, '', 6.75, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(17, 'purchase_return', '', 1, 0, 0, '', 312.5, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(18, 'purchase_return', '', 1, 0, 0, '', 31.25, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(19, 'purchase_return', '', 0, 0, 0, '', 62.5, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(20, 'purchase_return', '', 1, 0, 0, '', 156.25, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(21, 'purchase_return', '', 1, 0, 0, '', 312.5, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(22, 'purchase_return', '', 1, 0, 0, '', 31.25, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(23, 'purchase_return', '', 1, 0, 0, '', 31.25, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(24, 'purchase_return', '', 1, 0, 0, '', 31.25, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(25, 'purchase_return', '', 1, 0, 0, '', 31.25, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(26, 'purchase_return', '', 1, 0, 0, '', 62.5, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(27, 'purchase_return', '', 1, 0, 0, '', 31.25, '2019-10-01', 'active', 12, '2019-09-30 18:00:00', '2019-09-30 18:00:00'),
(28, 'sale', '', 1, 3, 0, '', 21, '2019-10-02', 'active', 12, '2019-10-01 18:00:00', '2019-10-01 18:00:00'),
(29, 'collection', 'cash', 1, 3, 0, '', 21, '2019-10-02', 'active', 12, '2019-10-01 18:00:00', '2019-10-01 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_receipt_info`
--

CREATE TABLE `transaction_receipt_info` (
  `transaction_receipt_id` int(10) NOT NULL,
  `shop_id` int(3) NOT NULL,
  `transaction_receipt_amount` double NOT NULL,
  `transaction_receipt_mode` char(7) NOT NULL,
  `transaction_receipt_ref_id` int(10) NOT NULL,
  `transaction_receipt_ref_table` char(20) NOT NULL,
  `transaction_receipt_cheque_id` int(10) NOT NULL,
  `transaction_receipt_doc` date NOT NULL,
  `transaction_receipt_dom` date NOT NULL,
  `transaction_receipt_status` tinyint(1) NOT NULL,
  `transaction_receipt_creator` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_ref_details`
--

CREATE TABLE `transaction_ref_details` (
  `transaction_ref_details_id` int(100) NOT NULL,
  `ref_id` int(100) NOT NULL,
  `transaction_purpose` varchar(250) NOT NULL,
  `transaction_amount` double NOT NULL,
  `transaction_table_ref_name` varchar(250) NOT NULL,
  `transaction_table_ref_id_field` varchar(250) NOT NULL,
  `transaction_type` varchar(250) NOT NULL,
  `transaction_ref_details_doc` date NOT NULL,
  `transaction_ref_details_dom` date NOT NULL,
  `transaction_ref_details_creator` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `type_info`
--

CREATE TABLE `type_info` (
  `type_id` int(100) NOT NULL,
  `type_name` varchar(250) NOT NULL,
  `type_type` varchar(250) NOT NULL,
  `type_doc` date NOT NULL,
  `type_dom` date NOT NULL,
  `type_creator` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit_info`
--

CREATE TABLE `unit_info` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_info`
--

INSERT INTO `unit_info` (`unit_id`, `unit_name`) VALUES
(1, 'sfds');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `username` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(250) COLLATE utf8_bin NOT NULL,
  `password2` varchar(255) COLLATE utf8_bin NOT NULL,
  `shop_id` int(3) NOT NULL,
  `user_type` varchar(250) COLLATE utf8_bin NOT NULL,
  `user_full_name` varchar(250) COLLATE utf8_bin NOT NULL,
  `user_address` varchar(250) COLLATE utf8_bin NOT NULL,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(250) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `password2`, `shop_id`, `user_type`, `user_full_name`, `user_address`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(12, 'admin', '$2a$08$jtgIWmApi2qjF9YbBC6bKeq22ZpWEZrBXtmHUAKmblCTRFS1pfb1a', '1234', 1, 'superadmin', 'Admin', 'Sylhet', '123456', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2019-10-03 10:12:52', '2017-06-14 15:46:54', '2019-10-03 04:12:52'),
(18, 'seller_1', '$2a$08$prLzr7wcRZ.YNn2wkLZa/uzis/TLpfqfdjvgJTSVH.o3R7vAzjkuG', '', 1, 'seller', 'Seller', 'Sylhet', '123456', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2019-01-05 17:44:14', '2017-05-05 05:24:51', '2019-02-05 06:27:48'),
(19, 'demo_user', '$2a$08$.WllJN10vRH/2KrVzzb5/eBtY1QeUkX7DInLPk155PW.bIEg4gsw6', '123456', 1, 'customer', 'demo user', '', '12345678945', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2019-03-18 16:47:21', '0000-00-00 00:00:00', '2019-03-18 10:47:21'),
(20, 'Admin1', '$2a$08$7lW4OgQeMK7oTtjSy4Y6E.bXUKJXqyNuCH.04gL0xRF9S6ADCWe06', '123456', 1, 'superadmin', 'Admin1', 'ad', '1234', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2019-03-19 10:59:08', '2019-03-19 10:58:16', '2019-07-27 05:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_product_list`
--

CREATE TABLE `warranty_product_list` (
  `ip_id` int(11) NOT NULL,
  `product_id` int(20) NOT NULL,
  `purchase_receipt_id` int(11) DEFAULT NULL,
  `sl_no` int(20) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `purchase_date` date NOT NULL,
  `purchase_price` float NOT NULL,
  `sale_price` float DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `creator` int(8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warranty_product_list`
--

INSERT INTO `warranty_product_list` (`ip_id`, `product_id`, `purchase_receipt_id`, `sl_no`, `invoice_id`, `status`, `purchase_date`, `purchase_price`, `sale_price`, `sale_date`, `creator`, `created_at`, `updated_at`) VALUES
(7, 2, 1, 12, NULL, 1, '2019-10-01', 1, 1, NULL, 12, '2019-10-01 04:55:03', '2019-10-01 04:55:26'),
(8, 2, 1, 23, NULL, 1, '2019-10-01', 1, 1, NULL, 12, '2019-10-01 04:55:03', '2019-10-01 04:55:26'),
(9, 2, 1, 34, NULL, 1, '2019-10-01', 1, 1, NULL, 12, '2019-10-01 04:55:03', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps_info`
--
ALTER TABLE `apps_info`
  ADD PRIMARY KEY (`appin_id`);

--
-- Indexes for table `bank_book`
--
ALTER TABLE `bank_book`
  ADD PRIMARY KEY (`bb_id`);

--
-- Indexes for table `bank_book_info`
--
ALTER TABLE `bank_book_info`
  ADD PRIMARY KEY (`bank_book_id`);

--
-- Indexes for table `bank_card_info`
--
ALTER TABLE `bank_card_info`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `bank_info`
--
ALTER TABLE `bank_info`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `barcode_print`
--
ALTER TABLE `barcode_print`
  ADD PRIMARY KEY (`print_id`);

--
-- Indexes for table `bulk_stock_info`
--
ALTER TABLE `bulk_stock_info`
  ADD PRIMARY KEY (`bulk_id`);

--
-- Indexes for table `cash_book`
--
ALTER TABLE `cash_book`
  ADD PRIMARY KEY (`cb_id`);

--
-- Indexes for table `catagory_info`
--
ALTER TABLE `catagory_info`
  ADD PRIMARY KEY (`catagory_id`);

--
-- Indexes for table `cheque_info`
--
ALTER TABLE `cheque_info`
  ADD PRIMARY KEY (`cheque_id`);

--
-- Indexes for table `cheque_reference_info`
--
ALTER TABLE `cheque_reference_info`
  ADD PRIMARY KEY (`cheque_ref_id`);

--
-- Indexes for table `commison_info`
--
ALTER TABLE `commison_info`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `daily_statement`
--
ALTER TABLE `daily_statement`
  ADD PRIMARY KEY (`daily_statement_id`);

--
-- Indexes for table `damage_product`
--
ALTER TABLE `damage_product`
  ADD PRIMARY KEY (`damage_id`);

--
-- Indexes for table `data_retrive_checking`
--
ALTER TABLE `data_retrive_checking`
  ADD PRIMARY KEY (`drc_id`);

--
-- Indexes for table `discount_details`
--
ALTER TABLE `discount_details`
  ADD PRIMARY KEY (`discount_details_id`);

--
-- Indexes for table `discount_info`
--
ALTER TABLE `discount_info`
  ADD PRIMARY KEY (`discount_info_id`);

--
-- Indexes for table `dishonour_cheque_book`
--
ALTER TABLE `dishonour_cheque_book`
  ADD PRIMARY KEY (`cheque_book_id`);

--
-- Indexes for table `distributor_info`
--
ALTER TABLE `distributor_info`
  ADD PRIMARY KEY (`distributor_id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `employee_salary_log`
--
ALTER TABLE `employee_salary_log`
  ADD PRIMARY KEY (`salary_log_id`);

--
-- Indexes for table `exchange_return_details_tbl`
--
ALTER TABLE `exchange_return_details_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange_return_tbl`
--
ALTER TABLE `exchange_return_tbl`
  ADD PRIMARY KEY (`exchange_return_id`);

--
-- Indexes for table `expense_info`
--
ALTER TABLE `expense_info`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `gift_details`
--
ALTER TABLE `gift_details`
  ADD PRIMARY KEY (`gift_id`);

--
-- Indexes for table `group_info`
--
ALTER TABLE `group_info`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `image_for_sale_listing`
--
ALTER TABLE `image_for_sale_listing`
  ADD PRIMARY KEY (`ifsl_id`);

--
-- Indexes for table `income_info`
--
ALTER TABLE `income_info`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `investment_info`
--
ALTER TABLE `investment_info`
  ADD PRIMARY KEY (`investment_id`);

--
-- Indexes for table `investor_info`
--
ALTER TABLE `investor_info`
  ADD PRIMARY KEY (`investor_id`);

--
-- Indexes for table `invoice_info`
--
ALTER TABLE `invoice_info`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `loan_details_info`
--
ALTER TABLE `loan_details_info`
  ADD PRIMARY KEY (`loan_details_id`);

--
-- Indexes for table `loan_person_info`
--
ALTER TABLE `loan_person_info`
  ADD PRIMARY KEY (`lp_id`);

--
-- Indexes for table `loan_seeker_info`
--
ALTER TABLE `loan_seeker_info`
  ADD PRIMARY KEY (`loan_seeker_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_book`
--
ALTER TABLE `owner_book`
  ADD PRIMARY KEY (`ob_id`);

--
-- Indexes for table `owner_info`
--
ALTER TABLE `owner_info`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `point_info`
--
ALTER TABLE `point_info`
  ADD PRIMARY KEY (`point_id`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `product_name` (`product_name`);

--
-- Indexes for table `purchase_info`
--
ALTER TABLE `purchase_info`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_receipt_info`
--
ALTER TABLE `purchase_receipt_info`
  ADD PRIMARY KEY (`receipt_id`);

--
-- Indexes for table `purchase_return_main_product`
--
ALTER TABLE `purchase_return_main_product`
  ADD PRIMARY KEY (`prmp_id`);

--
-- Indexes for table `purchase_return_warranty_product`
--
ALTER TABLE `purchase_return_warranty_product`
  ADD PRIMARY KEY (`prwp_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`sale_details_id`);

--
-- Indexes for table `sale_price_info`
--
ALTER TABLE `sale_price_info`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `sale_return_details_tbl`
--
ALTER TABLE `sale_return_details_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_return_list`
--
ALTER TABLE `sale_return_list`
  ADD PRIMARY KEY (`srl_id`);

--
-- Indexes for table `sale_return_main_product`
--
ALTER TABLE `sale_return_main_product`
  ADD PRIMARY KEY (`srmp_id`);

--
-- Indexes for table `sale_return_receipt_tbl`
--
ALTER TABLE `sale_return_receipt_tbl`
  ADD PRIMARY KEY (`sale_return_id`);

--
-- Indexes for table `sale_return_warranty_product`
--
ALTER TABLE `sale_return_warranty_product`
  ADD PRIMARY KEY (`srwp_id`);

--
-- Indexes for table `sale_running_info`
--
ALTER TABLE `sale_running_info`
  ADD PRIMARY KEY (`sale_running_id`);

--
-- Indexes for table `service_provider_info`
--
ALTER TABLE `service_provider_info`
  ADD PRIMARY KEY (`service_provider_id`);

--
-- Indexes for table `shop_setup`
--
ALTER TABLE `shop_setup`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `stock_info`
--
ALTER TABLE `stock_info`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `temp_sale_details`
--
ALTER TABLE `temp_sale_details`
  ADD PRIMARY KEY (`temp_sale_details_id`);

--
-- Indexes for table `temp_sale_info`
--
ALTER TABLE `temp_sale_info`
  ADD PRIMARY KEY (`temp_sale_id`);

--
-- Indexes for table `tmp_cash_sale_return_details_tbl`
--
ALTER TABLE `tmp_cash_sale_return_details_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_cash_sale_return_tbl`
--
ALTER TABLE `tmp_cash_sale_return_tbl`
  ADD PRIMARY KEY (`tmp_cash_sale_return_id`);

--
-- Indexes for table `tmp_purchase_return_details_tbl`
--
ALTER TABLE `tmp_purchase_return_details_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_purchase_return_tbl`
--
ALTER TABLE `tmp_purchase_return_tbl`
  ADD PRIMARY KEY (`tmp_purchase_return_id`);

--
-- Indexes for table `tmp_sale_return_details_tbl`
--
ALTER TABLE `tmp_sale_return_details_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_sale_return_tbl`
--
ALTER TABLE `tmp_sale_return_tbl`
  ADD PRIMARY KEY (`tmp_sale_return_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_info`
--
ALTER TABLE `transaction_info`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_receipt_info`
--
ALTER TABLE `transaction_receipt_info`
  ADD PRIMARY KEY (`transaction_receipt_id`);

--
-- Indexes for table `transaction_ref_details`
--
ALTER TABLE `transaction_ref_details`
  ADD PRIMARY KEY (`transaction_ref_details_id`);

--
-- Indexes for table `type_info`
--
ALTER TABLE `type_info`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `unit_info`
--
ALTER TABLE `unit_info`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_autologin`
--
ALTER TABLE `user_autologin`
  ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warranty_product_list`
--
ALTER TABLE `warranty_product_list`
  ADD PRIMARY KEY (`ip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps_info`
--
ALTER TABLE `apps_info`
  MODIFY `appin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_book`
--
ALTER TABLE `bank_book`
  MODIFY `bb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_book_info`
--
ALTER TABLE `bank_book_info`
  MODIFY `bank_book_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_card_info`
--
ALTER TABLE `bank_card_info`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_info`
--
ALTER TABLE `bank_info`
  MODIFY `bank_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barcode_print`
--
ALTER TABLE `barcode_print`
  MODIFY `print_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulk_stock_info`
--
ALTER TABLE `bulk_stock_info`
  MODIFY `bulk_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cash_book`
--
ALTER TABLE `cash_book`
  MODIFY `cb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `catagory_info`
--
ALTER TABLE `catagory_info`
  MODIFY `catagory_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cheque_info`
--
ALTER TABLE `cheque_info`
  MODIFY `cheque_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheque_reference_info`
--
ALTER TABLE `cheque_reference_info`
  MODIFY `cheque_ref_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commison_info`
--
ALTER TABLE `commison_info`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `company_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
  MODIFY `customer_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `daily_statement`
--
ALTER TABLE `daily_statement`
  MODIFY `daily_statement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_product`
--
ALTER TABLE `damage_product`
  MODIFY `damage_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_retrive_checking`
--
ALTER TABLE `data_retrive_checking`
  MODIFY `drc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_details`
--
ALTER TABLE `discount_details`
  MODIFY `discount_details_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_info`
--
ALTER TABLE `discount_info`
  MODIFY `discount_info_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dishonour_cheque_book`
--
ALTER TABLE `dishonour_cheque_book`
  MODIFY `cheque_book_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `distributor_info`
--
ALTER TABLE `distributor_info`
  MODIFY `distributor_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `employee_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `salary_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_salary_log`
--
ALTER TABLE `employee_salary_log`
  MODIFY `salary_log_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exchange_return_details_tbl`
--
ALTER TABLE `exchange_return_details_tbl`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exchange_return_tbl`
--
ALTER TABLE `exchange_return_tbl`
  MODIFY `exchange_return_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_info`
--
ALTER TABLE `expense_info`
  MODIFY `expense_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_details`
--
ALTER TABLE `gift_details`
  MODIFY `gift_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_info`
--
ALTER TABLE `group_info`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_for_sale_listing`
--
ALTER TABLE `image_for_sale_listing`
  MODIFY `ifsl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_info`
--
ALTER TABLE `income_info`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_info`
--
ALTER TABLE `investment_info`
  MODIFY `investment_id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investor_info`
--
ALTER TABLE `investor_info`
  MODIFY `investor_id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_info`
--
ALTER TABLE `invoice_info`
  MODIFY `invoice_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loan_details_info`
--
ALTER TABLE `loan_details_info`
  MODIFY `loan_details_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_person_info`
--
ALTER TABLE `loan_person_info`
  MODIFY `lp_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_seeker_info`
--
ALTER TABLE `loan_seeker_info`
  MODIFY `loan_seeker_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_book`
--
ALTER TABLE `owner_book`
  MODIFY `ob_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_info`
--
ALTER TABLE `owner_info`
  MODIFY `owner_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `point_info`
--
ALTER TABLE `point_info`
  MODIFY `point_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_info`
--
ALTER TABLE `product_info`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_info`
--
ALTER TABLE `purchase_info`
  MODIFY `purchase_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `purchase_receipt_info`
--
ALTER TABLE `purchase_receipt_info`
  MODIFY `receipt_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_return_main_product`
--
ALTER TABLE `purchase_return_main_product`
  MODIFY `prmp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `purchase_return_warranty_product`
--
ALTER TABLE `purchase_return_warranty_product`
  MODIFY `prwp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `sale_details_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_price_info`
--
ALTER TABLE `sale_price_info`
  MODIFY `sp_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_details_tbl`
--
ALTER TABLE `sale_return_details_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_list`
--
ALTER TABLE `sale_return_list`
  MODIFY `srl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sale_return_main_product`
--
ALTER TABLE `sale_return_main_product`
  MODIFY `srmp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sale_return_receipt_tbl`
--
ALTER TABLE `sale_return_receipt_tbl`
  MODIFY `sale_return_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_warranty_product`
--
ALTER TABLE `sale_return_warranty_product`
  MODIFY `srwp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_running_info`
--
ALTER TABLE `sale_running_info`
  MODIFY `sale_running_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_provider_info`
--
ALTER TABLE `service_provider_info`
  MODIFY `service_provider_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_setup`
--
ALTER TABLE `shop_setup`
  MODIFY `shop_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_info`
--
ALTER TABLE `stock_info`
  MODIFY `stock_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sale_details`
--
ALTER TABLE `temp_sale_details`
  MODIFY `temp_sale_details_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sale_info`
--
ALTER TABLE `temp_sale_info`
  MODIFY `temp_sale_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tmp_cash_sale_return_details_tbl`
--
ALTER TABLE `tmp_cash_sale_return_details_tbl`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_cash_sale_return_tbl`
--
ALTER TABLE `tmp_cash_sale_return_tbl`
  MODIFY `tmp_cash_sale_return_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_purchase_return_details_tbl`
--
ALTER TABLE `tmp_purchase_return_details_tbl`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_purchase_return_tbl`
--
ALTER TABLE `tmp_purchase_return_tbl`
  MODIFY `tmp_purchase_return_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_sale_return_details_tbl`
--
ALTER TABLE `tmp_sale_return_details_tbl`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_sale_return_tbl`
--
ALTER TABLE `tmp_sale_return_tbl`
  MODIFY `tmp_sale_return_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `transaction_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_info`
--
ALTER TABLE `transaction_info`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `transaction_receipt_info`
--
ALTER TABLE `transaction_receipt_info`
  MODIFY `transaction_receipt_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_ref_details`
--
ALTER TABLE `transaction_ref_details`
  MODIFY `transaction_ref_details_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_info`
--
ALTER TABLE `type_info`
  MODIFY `type_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_info`
--
ALTER TABLE `unit_info`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warranty_product_list`
--
ALTER TABLE `warranty_product_list`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
