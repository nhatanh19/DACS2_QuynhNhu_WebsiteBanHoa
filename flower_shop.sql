-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 03, 2024 lúc 03:50 PM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `flower_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Hoa sinh nhật', 'hoa-sinh-nhat', NULL),
(2, 'Hoa cưới', 'hoa-cuoi', NULL),
(3, 'Hoa kỷ niệm', 'hoa-ky-niem', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `note` text,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stock` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `image_url`, `stock`, `created_at`) VALUES
(4, 1, 'Hoa Hồng Đỏ', 'Bó hoa hồng đỏ tươi thắm, tượng trưng cho tình yêu mãnh liệt', 450000.00, 'img/hoa3.jpg', 25, '2024-01-15 01:30:00'),
(5, 1, 'Hoa Lan Tím', 'Hoa lan tím quý phái và sang trọng', 850000.00, 'img/hoa1.jpg', 15, '2024-01-16 02:15:00'),
(6, 1, 'Hoa Cẩm Chướng', 'Bó hoa cẩm chướng nhiều màu sắc tươi tắn', 350000.00, 'img/hoa5.jpg', 30, '2024-01-17 03:20:00'),
(7, 1, 'Hoa Ly Trắng', 'Bó hoa ly trắng tinh khôi và thuần khiết', 550000.00, 'img/hoa2.jpg', 20, '2024-01-18 04:30:00'),
(8, 1, 'Hoa Hướng Dương', 'Bó hoa hướng dương tràn đầy năng lượng', 400000.00, 'img/hoa7.jpg', 18, '2024-01-19 06:45:00'),
(9, 1, 'Hoa Tulip Hồng', 'Bó hoa tulip hồng nhẹ nhàng, lãng mạn', 750000.00, 'img/hoa4.jpg', 22, '2024-01-20 07:20:00'),
(10, 1, 'Hoa Baby Trắng', 'Bó hoa baby trắng tinh khôi', 280000.00, 'img/hoa3.jpg', 35, '2024-01-29 09:45:00'),
(11, 1, 'Hoa Cúc Tana', 'Bó hoa cúc tana rực rỡ', 320000.00, 'img/hoa4.jpg', 28, '2024-02-01 02:30:00'),
(12, 1, 'Hoa Hồng Vàng', 'Bó hoa hồng vàng tươi sáng, biểu tượng của tình bạn', 500000.00, 'img/hoa8.jpg', 20, '2024-02-05 10:00:00'),
(13, 1, 'Hoa Mẫu Đơn', 'Bó hoa mẫu đơn sang trọng và quý phái', 950000.00, 'img/hoa6.jpg', 15, '2024-02-07 11:30:00'),
(14, 1, 'Hoa Cẩm Tú Cầu', 'Bó hoa cẩm tú cầu nhiều màu sắc', 600000.00, 'img/hoa2.jpg', 25, '2024-02-10 03:00:00'),
(15, 1, 'Hoa Đào', 'Bó hoa đào tươi tắn, biểu tượng của mùa xuân', 700000.00, 'img/hoa5.jpg', 18, '2024-02-12 04:15:00'),
(16, 1, 'Hoa Oải Hương', 'Bó hoa oải hương thơm ngát, giúp thư giãn', 650000.00, 'img/hoa1.jpg', 22, '2024-02-15 05:45:00'),
(17, 1, 'Hoa Cúc Họa Mi', 'Bó hoa cúc họa mi trắng tinh khôi', 300000.00, 'img/hoa7.jpg', 30, '2024-02-18 06:30:00'),
(18, 1, 'Hoa Thược Dược', 'Bó hoa thược dược rực rỡ sắc màu', 400000.00, 'img/hoa3.jpg', 20, '2024-02-20 07:50:00'),
(19, 1, 'Hoa Sen', 'Bó hoa sen thanh khiết và tinh tế', 550000.00, 'img/hoa8.jpg', 25, '2024-02-22 08:40:00'),
(20, 1, 'Hoa Mộc Lan', 'Bó hoa mộc lan sang trọng và quý phái', 800000.00, 'img/hoa6.jpg', 15, '2024-02-25 09:30:00'),
(21, 1, 'Hoa Bách Hợp', 'Bó hoa bách hợp tinh khiết và thanh cao', 600000.00, 'img/hoa2.jpg', 18, '2024-02-28 10:20:00'),
(22, 1, 'Hoa Cát Tường', 'Bó hoa cát tường mang lại may mắn', 450000.00, 'img/hoa5.jpg', 28, '2024-03-01 11:15:00'),
(23, 1, 'Hoa Phong Lan', 'Bó hoa phong lan quý phái và sang trọng', 950000.00, 'img/hoa4.jpg', 12, '2024-03-03 12:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,  -- Sử dụng cột này cho cả username và full_name
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address TEXT,
  PRIMARY KEY (phone),
  UNIQUE KEY (id),
  UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
-- ALTER TABLE `users`
--   MODIFY `id` int NOT NULL AUTO_INCREMENT,
--   ADD UNIQUE KEY `username` (`username`),
--   ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
