-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 24, 2024 at 04:36 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `prod_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `unique_cart_user_prod` (`user_id`,`prod_id`),
  KEY `prod_id` (`prod_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Demo Categorie'),
(3, 'Finished Goods'),
(5, 'Machinery'),
(4, 'Packing Materials'),
(2, 'Raw Materials'),
(8, 'Stationery Items');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `dep_id` int NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(191) DEFAULT NULL,
  `dep_head` int DEFAULT NULL,
  `dep_status` int NOT NULL,
  PRIMARY KEY (`dep_id`),
  KEY `fk_departments` (`dep_head`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dep_id`, `dep_name`, `dep_head`, `dep_status`) VALUES
(1, 'Finance', 5, 1),
(2, 'Production', 4, 1),
(3, 'IT', 1, 1),
(4, 'Purchase and property administration', 3, 1),
(5, 'Management ', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `issue_vouchers`
--

DROP TABLE IF EXISTS `issue_vouchers`;
CREATE TABLE IF NOT EXISTS `issue_vouchers` (
  `issue_id` int NOT NULL AUTO_INCREMENT,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `department` int DEFAULT NULL,
  `division` varchar(191) DEFAULT NULL,
  `issued_to` int DEFAULT NULL,
  `store_req_id` int DEFAULT NULL,
  `issue_item_code` varchar(191) DEFAULT NULL,
  `measurement` varchar(20) DEFAULT NULL,
  `quantity` varchar(30) DEFAULT NULL,
  `unit_price` decimal(2,0) DEFAULT NULL,
  `total_price` decimal(2,0) DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  `issue_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`issue_id`),
  KEY `issued_to` (`issued_to`),
  KEY `issue_item_code` (`issue_item_code`),
  KEY `store_req_id` (`store_req_id`),
  KEY `approved_by` (`approved_by`),
  KEY `fk_issue_vouher` (`department`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `not_id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `not_date` date DEFAULT NULL,
  `not_type` int DEFAULT NULL,
  `not_url` varchar(255) DEFAULT NULL,
  `not_table` varchar(255) DEFAULT NULL,
  `not_seen` int DEFAULT NULL,
  `not_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`not_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`not_id`, `sender_id`, `not_date`, `not_type`, `not_url`, `not_table`, `not_seen`, `not_status`) VALUES
(1, 1, '2023-11-08', 1, '1rgthrg', 'rgertgerg', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `po_items`
--

DROP TABLE IF EXISTS `po_items`;
CREATE TABLE IF NOT EXISTS `po_items` (
  `po_id` int NOT NULL,
  `item_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `unit` varchar(50) NOT NULL,
  `total` float NOT NULL DEFAULT '0',
  KEY `po_items_ibfk_1` (`po_id`),
  KEY `po_items_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `prod_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `prod_code` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `prod_name` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `supplier_id` int DEFAULT NULL,
  `quantity` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `low_stock` int DEFAULT NULL,
  `over_stock` int DEFAULT NULL,
  `categorie_id` int UNSIGNED NOT NULL,
  `media_id` int DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`prod_id`),
  UNIQUE KEY `name` (`prod_name`),
  UNIQUE KEY `prod_code` (`prod_code`),
  KEY `categorie_id` (`categorie_id`),
  KEY `media_id` (`media_id`),
  KEY `products_ibfk_1` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_code`, `prod_name`, `supplier_id`, `quantity`, `buy_price`, `unit`, `low_stock`, `over_stock`, `categorie_id`, `media_id`, `date`) VALUES
(1, 'SPE-103-1014', 'Demo Product', 11, '39', '100.00', 'kg  ', 40, 60, 1, 0, '2021-04-04 16:45:51'),
(2, 'SPM-103-1007', 'Box Varieties', 12, '11', '55.00', 'unit ', 40, 50, 4, 0, '2021-04-04 18:44:52'),
(3, 'SPM-103-1003', 'Wheat', 11, '45', '2.00', 'grams ', 70, 110, 2, 0, '2021-04-04 18:48:53'),
(4, 'SPE-103-1002', 'Timber', 11, '1175', '780.00', 'bale ', 50, 100, 2, 0, '2021-04-04 19:03:23'),
(5, 'SPE-103-1004', 'W1848 Oscillating Floor Drill Press', 12, '18', '299.00', 'grams ', 5, 20, 5, 0, '2021-04-04 19:11:30'),
(6, 'SPE-103-1006', 'Portable Band Saw XBP02Z', 13, '42', '280.00', 'bale ', 2, 20, 5, 0, '2021-04-04 19:13:35'),
(7, 'SPM-103-1004', 'Life Breakfast Cereal-3 Pk', 12, '107', '3.00', 'kg ', 4, 7, 3, 0, '2021-04-04 19:15:38'),
(8, 'SPM-103-1002', 'Chicken of the Sea Sardines W', 15, '110', '13.00', 'kg ', 20, 50, 3, 0, '2021-04-04 19:17:11'),
(9, 'SPE-103-1001', 'Disney Woody - Action Figure', 12, '67', '29.00', 'kg ', 3, 30, 3, 0, '2021-04-04 19:19:20'),
(10, 'SPE-101-1001', 'Hasbro Marvel Legends Series Toys', 13, '106', '219.00', 'kg ', 90, 3000, 3, 0, '2021-04-04 19:20:28'),
(11, 'SPM-106-2003', 'Packing Chips', 12, '76', '21.00', 'kg ', 4, 40, 4, 0, '2021-04-04 19:25:22'),
(12, 'SPM-104-2001', 'Classic Desktop Tape Dispenser 38', 11, '152', '5.00', 'kg ', 30, 60, 8, 0, '2021-04-04 19:48:01'),
(13, 'SPM-103-1001', 'Small Bubble Cushioning Wrap', 11, '199', '8.00', 'kg ', 2, 20, 4, 0, '2021-04-04 19:49:00'),
(14, 'SPM-103-1020', 'chicken', 11, '4', '10.56', 'bale ', 5, 40, 3, 0, '2024-01-30 20:01:49'),
(15, 'SPM-1000-84', 'shampoo', 11, '2', '10.56', ' KG ', 5, 500, 3, 0, '2024-01-30 20:10:47'),
(16, 'F-300-01', 'Gause', 11, '50', '600.00', 'bale', NULL, NULL, 3, 0, '2024-02-20 06:54:55');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_list`
--

DROP TABLE IF EXISTS `purchase_order_list`;
CREATE TABLE IF NOT EXISTS `purchase_order_list` (
  `POL_id` int NOT NULL AUTO_INCREMENT,
  `po_code` varchar(50) NOT NULL,
  `supplier_id` int NOT NULL,
  `made_by` int NOT NULL,
  `amount` float NOT NULL,
  `discount_perc` float NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0',
  `tax_perc` float NOT NULL DEFAULT '0',
  `tax` float NOT NULL DEFAULT '0',
  `remarks` text NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0 = pending, 1 = partially received, 2 =received',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`POL_id`),
  KEY `purchase_order_list_ibfk_1` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `price`, `date`) VALUES
(1, 1, 2, '1000.00', '2021-04-04'),
(2, 3, 3, '15.00', '2021-04-04'),
(3, 10, 6, '1932.00', '2021-04-04'),
(4, 6, 2, '830.00', '2021-04-04'),
(5, 12, 5, '50.00', '2021-04-04'),
(6, 13, 21, '399.00', '2021-04-04'),
(7, 7, 5, '35.00', '2021-04-04'),
(8, 9, 2, '110.00', '2021-04-04'),
(9, 1, 9, '4500.00', '2023-11-22'),
(10, 12, 8, '80.00', '2023-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `store_requisitions`
--

DROP TABLE IF EXISTS `store_requisitions`;
CREATE TABLE IF NOT EXISTS `store_requisitions` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `user_id` int NOT NULL,
  `qty` int NOT NULL,
  `approved_by` varchar(191) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` int DEFAULT '0',
  `item_code` varchar(191) DEFAULT NULL,
  `measurement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `item_name` varchar(191) DEFAULT NULL,
  `issued_by` varchar(191) DEFAULT NULL,
  `confirmed` int DEFAULT NULL,
  PRIMARY KEY (`request_id`),
  KEY `item_id` (`item_id`),
  KEY `user_id` (`user_id`),
  KEY `approved_by` (`approved_by`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `store_requisitions`
--

INSERT INTO `store_requisitions` (`request_id`, `item_id`, `user_id`, `qty`, `approved_by`, `timestamp`, `seen`, `item_code`, `measurement`, `item_name`, `issued_by`, `confirmed`) VALUES
(1, 8, 1, 1, '2', '2023-11-26 18:38:25', 1, 'SPM-103-1002', 'kg', NULL, '3', 1),
(2, 1, 1, 6, '2', '2023-11-30 19:22:41', 1, 'SPE-103-1005', 'dozens', NULL, '3', 1),
(3, 7, 2, 2, '2', '2023-12-05 11:38:53', 1, 'SPM-103-1004', 'bale', NULL, '3', NULL),
(4, 11, 1, 1, 'Declined', '2023-12-14 16:51:56', 1, 'SPM-106-2003', 'grams', NULL, NULL, NULL),
(5, 9, 3, 6, 'Declined', '2023-12-17 06:26:10', 1, 'SPE-103-1001', 'grams', 'Disney Woody - Action Figure', NULL, NULL),
(6, 13, 1, 6, '2', '2023-12-20 17:44:26', 1, 'SPM-103-1001', 'grams', 'Small Bubble Cushioning Wrap', '3', 1),
(7, 12, 1, 6, 'Declined', '2023-12-21 07:41:11', 1, 'SPM-104-2001', 'grams', 'Classic Desktop Tape Dispenser 38', 'Declined', NULL),
(8, 11, 1, 1, '2', '2023-12-24 10:13:37', 0, 'SPM-106-2003', 'units', 'Packing Chips', '3', 1),
(9, 10, 2, 1, '2', '2023-12-27 09:06:53', 0, 'SPE-101-1001', 'units', 'Hasbro Marvel Legends Series Toys', 'Declined', NULL),
(10, 1, 1, 8, '2', '2023-12-29 09:28:21', 0, 'SPE-103-1005', 'units', 'Demo Product', '3', 1),
(11, 8, 1, 1, NULL, '2024-01-30 21:14:42', 0, 'SPM-103-1002', 'units', 'Chicken of the Sea Sardines W', NULL, NULL),
(12, 1, 1, 104, '2', '2024-02-18 17:12:37', 0, 'SPE-103-1014', 'kg ', 'Demo Product', NULL, NULL),
(13, 3, 1, 22, NULL, '2024-02-18 17:12:37', 0, 'SPM-103-1003', 'grams', 'Wheat', NULL, NULL),
(14, 2, 1, 129, NULL, '2024-02-18 17:12:37', 0, 'SPM-103-1007', 'unit', 'Box Varieties', NULL, NULL),
(37, 13, 1, 8, 'Declined', '2024-02-18 17:18:34', 0, 'SPM-103-1001', 'kg', 'Small Bubble Cushioning Wrap', NULL, NULL),
(38, 1, 1, 106, '2', '2024-02-18 17:20:00', 0, 'SPE-103-1014', 'kg ', 'Demo Product', NULL, NULL),
(39, 2, 1, 130, NULL, '2024-02-18 17:20:00', 0, 'SPM-103-1007', 'unit', 'Box Varieties', NULL, NULL),
(40, 3, 1, 22, NULL, '2024-02-18 17:20:00', 0, 'SPM-103-1003', 'grams', 'Wheat', NULL, NULL),
(41, 4, 1, 25, NULL, '2024-02-18 17:20:00', 0, 'SPE-103-1002', 'bale', 'Timber', NULL, NULL),
(42, 5, 1, 8, '2', '2024-02-18 17:20:00', 0, 'SPE-103-1004', 'grams', 'W1848 Oscillating Floor Drill Press', NULL, NULL),
(43, 6, 1, 1, '2', '2024-02-18 17:20:00', 0, 'SPE-103-1006', 'bale', 'Portable Band Saw XBP02Z', NULL, NULL),
(44, 7, 1, 4, NULL, '2024-02-18 17:20:00', 0, 'SPM-103-1004', 'kg', 'Life Breakfast Cereal-3 Pk', NULL, NULL),
(45, 8, 1, 3, NULL, '2024-02-18 17:20:00', 0, 'SPM-103-1002', 'kg', 'Chicken of the Sea Sardines W', NULL, NULL),
(46, 9, 1, 2, NULL, '2024-02-18 17:20:00', 0, 'SPE-103-1001', 'kg', 'Disney Woody - Action Figure', NULL, NULL),
(47, 10, 1, 3, NULL, '2024-02-18 17:20:00', 0, 'SPE-101-1001', 'kg', 'Hasbro Marvel Legends Series Toys', NULL, NULL),
(48, 11, 1, 2, NULL, '2024-02-18 17:20:00', 0, 'SPM-106-2003', 'kg', 'Packing Chips', NULL, NULL),
(49, 12, 1, 4, '2', '2024-02-18 17:20:00', 0, 'SPM-104-2001', 'kg', 'Classic Desktop Tape Dispenser 38', NULL, NULL),
(50, 13, 1, 8, '2', '2024-02-18 17:20:00', 0, 'SPM-103-1001', 'kg', 'Small Bubble Cushioning Wrap', NULL, NULL),
(51, 1, 1, 106, '2', '2024-02-18 17:20:18', 0, 'SPE-103-1014', 'kg ', 'Demo Product', 'Declined', NULL),
(52, 2, 1, 130, '2', '2024-02-18 17:20:18', 0, 'SPM-103-1007', 'unit', 'Box Varieties', NULL, NULL),
(53, 3, 1, 22, '2', '2024-02-18 17:20:18', 0, 'SPM-103-1003', 'grams', 'Wheat', '3', NULL),
(54, 4, 1, 25, '2', '2024-02-18 17:20:18', 0, 'SPE-103-1002', 'bale', 'Timber', '3', NULL),
(55, 5, 1, 8, '2', '2024-02-18 17:20:18', 0, 'SPE-103-1004', 'grams', 'W1848 Oscillating Floor Drill Press', '3', NULL),
(56, 6, 1, 1, '2', '2024-02-18 17:20:18', 0, 'SPE-103-1006', 'bale', 'Portable Band Saw XBP02Z', NULL, NULL),
(57, 7, 1, 4, '2', '2024-02-18 17:20:18', 0, 'SPM-103-1004', 'kg', 'Life Breakfast Cereal-3 Pk', NULL, NULL),
(58, 8, 1, 3, '2', '2024-02-18 17:20:18', 0, 'SPM-103-1002', 'kg', 'Chicken of the Sea Sardines W', 'Declined', NULL),
(59, 9, 1, 2, '2', '2024-02-18 17:20:18', 0, 'SPE-103-1001', 'kg', 'Disney Woody - Action Figure', NULL, NULL),
(60, 10, 1, 3, '2', '2024-02-18 17:20:18', 0, 'SPE-101-1001', 'kg', 'Hasbro Marvel Legends Series Toys', NULL, NULL),
(61, 11, 1, 2, '2', '2024-02-18 17:20:18', 0, 'SPM-106-2003', 'kg', 'Packing Chips', '3', NULL),
(62, 12, 1, 4, '2', '2024-02-18 17:20:18', 0, 'SPM-104-2001', 'kg', 'Classic Desktop Tape Dispenser 38', NULL, NULL),
(63, 13, 1, 8, '2', '2024-02-18 17:20:18', 0, 'SPM-103-1001', 'kg', 'Small Bubble Cushioning Wrap', NULL, NULL),
(64, 2, 1, 2, '2', '2024-02-19 07:31:28', 0, 'SPM-103-1007', 'unit', 'Box Varieties', '3', NULL),
(65, 3, 1, 2, '2', '2024-02-19 07:31:28', 0, 'SPM-103-1003', 'grams', 'Wheat', '3', NULL),
(66, 1, 1, 4, '2', '2024-02-22 06:22:20', 0, 'SPE-103-1014', 'kg  ', 'Demo Product', 'Declined', NULL),
(67, 2, 1, 1, '2', '2024-02-22 06:22:20', 0, 'SPM-103-1007', 'unit ', 'Box Varieties', '3', NULL),
(68, 5, 1, 1, 'Declined', '2024-02-22 06:22:20', 0, 'SPE-103-1004', 'grams ', 'W1848 Oscillating Floor Drill Press', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `SUPPLIER_ID` int NOT NULL AUTO_INCREMENT,
  `COMPANY_NAME` varchar(50) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `PHONE_NUMBER` varchar(11) DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`SUPPLIER_ID`),
  KEY `LOCATION_ID` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SUPPLIER_ID`, `COMPANY_NAME`, `email`, `PHONE_NUMBER`, `status`) VALUES
(11, 'InGame Tech', '114', '09457488521', 1),
(12, 'Asus', '115', '09635877412', 1),
(13, 'Razer Co.', '111', '09587855685', 1),
(15, 'Strategic Technology Co.', 'seb@gmail.com', '9124033805', 1),
(16, 'A4tech', '155', '09775673257', 1),
(17, 'ALEMA plc.', 'alem@gmail.com', '0923818102', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `department` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_level` (`user_level`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`, `department`) VALUES
(1, 'Harry Denn', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2024-02-24 07:29:55', 'IT'),
(2, 'John Walker', 'Special', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'd82b50y82.jpg', 1, '2024-02-24 05:07:23', 'Management'),
(3, 'Christopher', 'user', '12dea96fec20593566ab75692c9949596833adc9', 3, 'ch1e5aog3.jpg', 1, '2024-02-23 09:20:52', 'Purchase And Property Adminstration'),
(5, 'Kevin', 'Kevin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, 'no_image.png', 1, '2021-04-04 19:54:29', 'Purchase and property administration'),
(6, 'Yoakin', 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1, 'no_image.jpg', 1, NULL, 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(150) NOT NULL,
  `group_level` int NOT NULL,
  `group_status` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_level` (`group_level`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Manager', 2, 1),
(3, 'Store', 3, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `po_items`
--
ALTER TABLE `po_items`
  ADD CONSTRAINT `po_items_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_order_list` (`POL_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `products` (`prod_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`SUPPLIER_ID`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_order_list`
--
ALTER TABLE `purchase_order_list`
  ADD CONSTRAINT `purchase_order_list_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`SUPPLIER_ID`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
