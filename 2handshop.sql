-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 12, 2024 at 12:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET GLOBAL collation_connection = 'utf8mb4_general_ci';
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `user_id`, `qty`, `amount`) VALUES
(6, 3, 1, 2, '500.00'),
(20, 36, 3, 1, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'อาหารและเครื่องดื่ม'),
(2, 'เสื้อผ้าและเครื่องแต่งกาย'),
(3, 'ของใช้ในครัวเรือน'),
(4, 'เครื่องสำอางและความงาม'),
(5, 'ของเล่นและเกมสำหรับเด็ก'),
(6, 'อุปกรณ์อิเล็กทรอนิกส์'),
(7, 'สมาร์ทโฟนและแท็บเล็ต'),
(8, 'เครื่องใช้ไฟฟ้าในบ้าน'),
(9, 'อุปกรณ์กีฬาและออกกำลังกาย'),
(10, 'หนังสือและการศึกษา');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id`, `product_id`, `user_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 5, 2),
(6, 35, 3),
(14, 1, 5),
(15, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message_text`, `sent_at`) VALUES
(1, 2, 1, 'สวัสดี', '2024-03-08 08:53:01'),
(2, 2, 1, 'ไง', '2024-03-08 09:17:42'),
(3, 1, 2, 'hi', '2024-03-08 10:26:51'),
(4, 3, 1, 'หวัดดีคับ', '2024-03-11 20:24:15'),
(5, 3, 1, '', '2024-03-11 20:26:27'),
(6, 3, 1, '..', '2024-03-11 20:26:32'),
(7, 3, 3, 'ดีคับ', '2024-03-11 20:27:54'),
(8, 3, 3, 'ดีคับ', '2024-03-11 20:31:08'),
(9, 3, 2, 'ดีคับ', '2024-03-11 20:32:35'),
(10, 4, 3, 'hello', '2024-03-11 21:00:53'),
(11, 3, 4, 'hello', '2024-03-11 21:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount_total` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `amount_total`, `order_date`) VALUES
(1, '1', '500', '2024-03-07 17:11:51'),
(2, '2', '500', '2024-03-08 03:09:14'),
(3, '3', '1000', '2024-03-11 19:26:58'),
(4, '3', '500', '2024-03-11 19:43:31'),
(5, '3', '1000', '2024-03-11 20:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `product_id`, `qty`, `user_id`, `order_id`, `amount`) VALUES
(1, 1, 2, 1, 1, '500.00'),
(2, 1, 1, 2, 2, '500.00'),
(3, 1, 1, 3, 3, '500.00'),
(4, 5, 1, 3, 3, '500.00'),
(5, 3, 1, 3, 4, '500.00'),
(6, 3, 1, 3, 5, '500.00'),
(7, 1, 1, 3, 5, '500.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `favorite` int DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `color`, `category_id`, `image`, `created_at`, `price`, `favorite`, `user_id`) VALUES
(1, 'สินค้าที่ 0', 'คำอธิบายสินค้าที่ 0', 'ม่วง', 7, '1.jpg', '2024-02-02', '500.00', 4, 1),
(2, 'สินค้าที่ 1', 'คำอธิบายสินค้าที่ 1', 'เทา', 8, '2.jpg', '2024-02-02', '500.00', 5, 1),
(3, 'สินค้าที่ 2', 'คำอธิบายสินค้าที่ 2', 'ดำ', 8, '3.jpg', '2024-02-02', '500.00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `address`, `postcode`, `phone`) VALUES
(1, 'หัวหน้า รปภ มายฟู๊ด', 'admin@gmail.com', '$2y$10$wf8VJcjS4fDhhhmCC/n6YuorV3vcEN0fL6exxvd.ZxqB8XZBxEjg.', NULL, NULL, ''),
(2, 'ผู้ขาย สินค้า', 'sale@gmail.com', '$2y$10$rsz.OSfF/U7aP/HQ27g/oOZynQMCesyR2HrzuSNul37PrFuVpHK0W', NULL, NULL, '023812312'),
(3, 'aniruj', 'a@gmail.com', '$2y$10$/J9w4c9B.kNvxf42tuQUYeomSHDcdaT8h3dLU07YR0uegidGzL1zC', NULL, NULL, '0521623654'),
(5, 's', 'aniruj2644@gmail.com', '$2y$10$b8Qwa/Smjpx7m31Imhr7p.FgYVQ3yCWEFgUksiI4rAWxq4MC5ApGG', NULL, NULL, '52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
