-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 06 Haz 2024, 22:41:27
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_surname` varchar(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_status` enum('Killer','Medium','Low') DEFAULT 'Low'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_surname`, `admin_username`, `admin_pass`, `admin_status`) VALUES
(1, 'Ertürk', 'Eryavuz', 'erturkeryavuz', '3027ert', 'Killer'),
(9, 'erto', 'curry', 'ertcurry', '2345353', 'Killer'),
(5, 'quowind', 'avernus', 'Quowind', '12345', 'Medium'),
(6, 'LORD OF ', 'AVERNUS', '--Avernus--', '12345', 'Medium'),
(8, 'cookiem', 'eryavuz', 'cookiem', 'gtegbrt5545', 'Medium'),
(7, 'tuo', 'yerli', 'Cookie', 'gtegbrt5545heyhey', 'Low'),
(10, 'ertert', 'mumb', 'quoert', 'mjujordsnhoho2345', 'Medium');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`, `display_order`, `parent_id`) VALUES
(1, 'Men\'s Jersey', NULL, 1),
(2, 'Woman\'s Jersey', NULL, 1),
(3, 'Teenager\'s Jersey', NULL, 1),
(4, 'T-Shirts', NULL, NULL),
(5, 'Hoodies', NULL, NULL),
(6, 'Shorts', NULL, NULL),
(7, 'Tracksuits', NULL, NULL),
(8, 'Caps', NULL, NULL),
(9, 'Accessories', NULL, NULL),
(10, 'Footwear', NULL, NULL),
(11, 'Socks', NULL, NULL),
(12, 'Bags', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Ertürk Eryavuz', 'erturkeryavuz@gmail.com', 'efw', 'wefw', '2024-06-05 07:00:08'),
(2, 'ronaldo cristiano', 'suironaldo7@hotmail.com', 'real madrid', 'hala madriddd', '2024-06-05 07:11:53'),
(3, 'Ertürk Eryavuz', 'erturkeryavuz@gmail.com', '2323', '32r23', '2024-06-06 02:22:17');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `total_price` decimal(65,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_details` text DEFAULT NULL,
  `estimated_delivery` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `total_price`, `created_at`, `first_name`, `last_name`, `email`, `mobile`, `address1`, `address2`, `country`, `city`, `state`, `zip`, `payment_method`, `payment_details`, `estimated_delivery`) VALUES
(1, NULL, '665fa8946bfb0', 4058, '2024-06-04 23:51:48', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, NULL),
(3, NULL, '665fa90c3fe4e', 610, '2024-06-04 23:53:48', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, NULL),
(7, NULL, '665faab989fb9', 2590, '2024-06-05 00:00:57', 'eeeee', 'vrgrgeg', 'ewfwfwegf23@gmail.com', '05335558585', 'er', 'er', 'United States', 'istanbul', 'ümraniye', '34666', NULL, NULL, NULL),
(9, NULL, '665faea5d6429', 2610, '2024-06-05 00:17:41', 'eeee', 'eeeeee', 'kwfeggervuz@gmail.com', '05355643363', 'Azeeeiz Bulvarı', '45eeee', 'United States', 'Istanbul', 'İstanbul', '34755', NULL, NULL, NULL),
(11, NULL, '66600037f39a7', 2125, '2024-06-05 06:05:43', 'muro', 'james', 'lalalalameneof@hotmail.com', '056694944744', 'azkamodnffj lolana', '123 nununme', 'Algeria', 'ankara', 'bağcılar', '22193', NULL, NULL, NULL),
(13, NULL, '66600135f24d9', 19560, '2024-06-05 06:09:57', 'norne', 'kolman', 'ronaldomessi@mynet.com', '05638339292', '123', '123', 'Albania', 'Mersin', 'moranlu', '10293', NULL, NULL, NULL),
(15, NULL, '6660d1a371e94', 6010, '2024-06-05 20:59:15', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, NULL),
(17, NULL, '6660d590d3895', 935, '2024-06-05 21:16:00', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, NULL),
(24, NULL, '666112fb06128', 1472, '2024-06-06 01:38:03', 'stephen', 'curry', 'stepcurry@gmail.com', '+33 3442235', '12', 'ee', 'United States', 'newyork', 'mokuda', '225566', NULL, NULL, NULL),
(26, NULL, '666114bc4f5f0', 70, '2024-06-06 01:45:32', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, NULL),
(27, NULL, '66611ab2c3a4c', 3010, '2024-06-06 02:10:58', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-10'),
(28, NULL, '66611d31ba11c', 9130, '2024-06-06 02:21:37', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-18'),
(29, NULL, '666133f50c765', 510, '2024-06-06 03:58:45', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-22'),
(30, NULL, '66613a9bc3645', 12295, '2024-06-06 04:27:07', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-26'),
(31, NULL, '666142fe2723f', 7758, '2024-06-06 05:02:54', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-07-08'),
(32, NULL, '66614b7fbadbc', 610, '2024-06-06 05:39:11', 'kverbetb', 'tenetn', 'romsnfnfvuz@gmail.com', '05333764444', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-18'),
(33, NULL, '6661c9eeb5775', 3010, '2024-06-06 14:38:38', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-10'),
(34, NULL, '6661d64813a94', 19679, '2024-06-06 15:31:20', 'jordan', 'micheal', 'jordanmichael@outlook.com', '+44 393939393', 'LA', 'LA', 'United States', 'CALİFORNİA', 'CALİFORNİA', '8829', NULL, NULL, '2025-01-16'),
(35, NULL, '6661d8e5f369d', 3600, '2024-06-06 15:42:29', 'Tuanna', 'yerlikaya', 'tuossarayerikaya@gmail.com', '0533755383', 'maltepe', 'tunceli merkez', 'United States', 'tunceli', 'merkez', '62000', NULL, NULL, '2024-06-18'),
(36, NULL, '666201f5de367', 8456, '2024-06-06 18:37:41', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-09-14'),
(38, NULL, '666202e399896', 1579, '2024-06-06 18:41:39', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-30'),
(39, NULL, '666218bc4c257', 1235, '2024-06-06 20:14:52', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-06-26'),
(40, NULL, '66621dbe63e9e', 113246, '2024-06-06 20:36:14', 'Ertürk', 'Eryavuz', 'erturkeryavuz@gmail.com', '05347643363', 'Aziz Bulvarı', '45', 'United States', 'Istanbul', 'İstanbul', '34758', NULL, NULL, '2024-11-09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 28, 4, 100),
(2, 1, 24, 8, 456),
(3, 3, 22, 6, 100),
(4, 7, 19, 4, 400),
(5, 7, 21, 4, 245),
(6, 9, 18, 4, 300),
(7, 9, 28, 4, 100),
(8, 9, 17, 1, 1000),
(9, 11, 21, 2, 245),
(10, 11, 19, 1, 400),
(11, 11, 17, 1, 1000),
(12, 11, 28, 1, 100),
(13, 11, 37, 1, 125),
(14, 13, 31, 3, 3040),
(15, 13, 33, 1, 30),
(16, 13, 16, 1, 10000),
(17, 13, 34, 4, 100),
(18, 15, 23, 2, 3000),
(19, 17, 35, 4, 200),
(20, 17, 37, 1, 125),
(21, 24, 24, 2, 456),
(22, 24, 36, 1, 250),
(23, 24, 27, 3, 100),
(24, 26, 33, 2, 30),
(25, 27, 23, 1, 3000),
(26, 28, 31, 3, 3040),
(27, 29, 37, 4, 125),
(28, 30, 37, 1, 125),
(29, 30, 31, 4, 3040),
(30, 31, 24, 3, 456),
(31, 31, 31, 2, 3040),
(32, 31, 28, 3, 100),
(33, 32, 35, 3, 200),
(34, 33, 23, 1, 3000),
(35, 34, 19, 14, 400),
(36, 34, 18, 15, 300),
(37, 34, 21, 13, 245),
(38, 34, 24, 14, 456),
(39, 35, 31, 1, 3040),
(40, 35, 19, 1, 400),
(41, 35, 32, 1, 150),
(42, 36, 24, 11, 456),
(43, 36, 21, 14, 245),
(44, 38, 39, 3, 223),
(45, 38, 26, 3, 300),
(46, 39, 21, 5, 245),
(47, 40, 17, 19, 1000),
(48, 40, 16, 9, 10000),
(49, 40, 26, 5, 300),
(50, 40, 24, 6, 456);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(65,0) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `image` varchar(100) NOT NULL,
  `category_id` int(100) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock_quantity`, `image`, `category_id`, `created_at`, `description`) VALUES
(16, 'bag lous vitton', 10000, 3, 'bag3.avif', 12, '2024-06-03 22:16:08.318894', 'classical'),
(17, 'lakers bag', 1000, 200, 'bag2.jpeg', 12, '2024-06-03 22:17:12.164911', 'black'),
(18, 'curry footwear', 300, 660, 'footwear1.jpeg', 10, '2024-06-03 22:18:06.463154', 'blue'),
(19, 'curry black footwear', 400, 224, 'footwear2.jpeg', 10, '2024-06-03 22:18:39.202716', 'black and shine'),
(21, 'curry footwear white', 245, 300, 'footwear4.jpeg', 10, '2024-06-03 22:20:44.606079', 'white'),
(22, 'hat white', 100, 330, 'hat1.webp', 8, '2024-06-03 22:23:26.329739', 'clippers hat'),
(23, 'nba bag', 3000, 5, 'bag1.jpeg', 12, '2024-06-03 22:24:02.030763', 'classical nba bag'),
(24, 'curry red footwear', 456, 4000, 'footwear3.jpeg', 10, '2024-06-03 22:26:10.726990', 'curry 2.5 red and black'),
(26, 'sixers allen iverson', 300, 5000, 'men jersey3.webp', 1, '2024-06-03 22:31:24.042811', 'black classic'),
(27, 'curry jersey ', 100, 10000, 'men jersey2.jpeg', 1, '2024-06-03 22:31:54.109174', 'blue and soft'),
(28, 'Lavine Jersey', 100, 22200, 'men jersey1.jpeg', 1, '2024-06-03 22:55:24.032079', 'red'),
(29, 'hand band nba', 55, 1000, 'accessories 1.jpeg', 9, '2024-06-05 05:56:17.263659', 'hand band blue nba'),
(30, 'nba hoodie mix', 440, 50, 'hoodie 1.jpeg', 5, '2024-06-05 05:57:10.847692', 'black all teams nba hoodie'),
(31, 'lakers jersey', 3040, 500, 'men jersey 4.jpg', 1, '2024-06-05 05:58:00.898047', 'black laker james jersey'),
(32, 'bulls short', 150, 1000, 'shorts 1.png', 6, '2024-06-05 05:58:38.012440', 'red and white chicago bulls short'),
(33, 'black socks', 30, 2000, 'socks 1.png', 11, '2024-06-05 05:59:22.963530', 'nba black tall socks'),
(34, 'lakers t-shirt', 100, 2000, 't-shirts 1.jpeg', 4, '2024-06-05 05:59:57.812200', 'purple lakers gold t-shirt'),
(35, 'lakers jersey', 200, 1500, 'teenager jersey 1.jpeg', 3, '2024-06-05 06:00:28.297141', 'lakers kids jersey'),
(36, 'bulls woman jersey', 250, 500, 'woman jersey 1.jpeg', 2, '2024-06-05 06:02:15.811083', 'chicago bulls dark rodman jersey for woman'),
(37, 'green tracksuit', 125, 1000, 'tracksuit 1.webp', 7, '2024-06-05 06:03:20.531874', 'milwaukee bucks green tracksuit'),
(38, 'philelphie jersey', 200, 3000, 'mens jersey 5.avif', 1, '2024-06-06 16:36:59.012653', 'blue shine philidelphia sixers embied jersey'),
(39, 'okc jersey', 223, 5000, 'mens jersey 6.avif', 1, '2024-06-06 16:37:35.557508', 'okc black and red jersey'),
(40, 'golden state jersey', 5000, 10000, 'mens jersey 7.webp', 1, '2024-06-06 16:39:05.652231', 'golden state black outdoor jersey curry edition'),
(41, 'lakers bryant', 349, 335, 'mens jersey 8.avif', 1, '2024-06-06 16:39:43.814175', 'lakers kobe bryant classical jersey'),
(42, 'white all star', 400, 2000, 'mens jersey 9.jpg', 1, '2024-06-06 16:40:12.358537', 'white all star jersey'),
(43, 'embied jersey', 100, 4000, 'men jersey 10.avif', 1, '2024-06-06 16:40:52.824385', 'blue classical'),
(44, 'toronto jersey', 300, 400, 'men jersey 11.jpeg', 1, '2024-06-06 16:41:17.570970', 'puruple toronte raptors jersey'),
(45, 'golden state yellow', 300, 455, 'men jersey 12.jpeg', 1, '2024-06-06 16:45:00.190422', 'golden state yellow jersey  stephen curry edition');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `first_name`, `last_name`) VALUES
(1, 'Quo', '$2y$10$k6YHaGet54fFeqTRBQGGJ.z247B0v1.a/hXARrjDgZN43bURPUii.', 'quo@gmail.com', '2024-06-06 14:20:31', 'Ertürk222', 'Eryavuz222'),
(2, 'weee', '$2y$10$DPV7lYcMVaVeeQc/p3r55uatr0kzAzD39uKxb.ghRAueYea5D2p.K', 'ert33333ryavuz@gmail.com', '2024-06-06 14:21:40', '3e3Ertürk', '3e3eEryavuz'),
(3, 'weee', '$2y$10$j2ORKR94MlsfIRFYMA82weK5uajj1gKXHRcA7RndFJ49nHasinc0G', 'ert33333ryavuz@gmail.com', '2024-06-06 14:23:49', '3e3Ertürk', '3e3eEryavuz'),
(4, 'curry', '$2y$10$L27khOUj7KuKA9Df1oCMyOAdYyt8qYDmx661Z6HxnHTHO3NjFqspG', 'curry@gmail.com', '2024-06-06 14:24:06', 'aaa', 'nbbb'),
(5, 'lebron', '$2y$10$oIuQ2BE5dIGV.JmKywXtQOTTztMdA.qag7Th2KD/TxeqzTkKwJO8S', 'lebron@gmail.com', '2024-06-06 14:29:43', 'aaa', 'aaaaa');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_username` (`admin_username`) USING HASH,
  ADD KEY `admin_status` (`admin_status`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Tablo için indeksler `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_id` (`order_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_ibfk_1` (`category_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Tablo için AUTO_INCREMENT değeri `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Tablo kısıtlamaları `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
