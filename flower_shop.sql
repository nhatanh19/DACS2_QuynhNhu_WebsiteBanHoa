-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 04, 2024 lúc 05:29 AM
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
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `note` text,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--



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
(4, 1, 'Hoa Hồng Đỏ', 'Bó hoa hồng đỏ tươi thắm, tượng trưng cho tình yêu mãnh liệt', 450000.00, 'img/hoa3.jpg', 25, '2024-01-14 18:30:00'),
(5, 1, 'Hoa Lan Tím', 'Hoa lan tím quý phái và sang trọng', 850000.00, 'img/hoa1.jpg', 15, '2024-01-15 19:15:00'),
(6, 1, 'Hoa Cẩm Chướng', 'Bó hoa cẩm chướng nhiều màu sắc tươi tắn', 350000.00, 'img/hoa5.jpg', 30, '2024-01-16 20:20:00'),
(7, 1, 'Hoa Ly Trắng', 'Bó hoa ly trắng tinh khôi và thuần khiết', 550000.00, 'img/hoa2.jpg', 20, '2024-01-17 21:30:00'),
(8, 1, 'Hoa Hướng Dương', 'Bó hoa hướng dương tràn đầy năng lượng', 400000.00, 'img/hoa7.jpg', 18, '2024-01-18 23:45:00'),
(9, 1, 'Hoa Tulip Hồng', 'Bó hoa tulip hồng nhẹ nhàng, lãng mạn', 750000.00, 'img/hoa4.jpg', 22, '2024-01-20 00:20:00'),
(10, 1, 'Hoa Baby Trắng', 'Bó hoa baby trắng tinh khôi', 280000.00, 'img/hoa3.jpg', 35, '2024-01-29 02:45:00'),
(11, 1, 'Hoa Cúc Tana', 'Bó hoa cúc tana rực rỡ', 320000.00, 'img/hoa4.jpg', 28, '2024-01-31 19:30:00'),
(12, 1, 'Hoa Hồng Vàng', 'Bó hoa hồng vàng tươi sáng, biểu tượng của tình bạn', 500000.00, 'img/hoa8.jpg', 20, '2024-02-05 03:00:00'),
(13, 1, 'Hoa Mẫu Đơn', 'Bó hoa mẫu đơn sang trọng và quý phái', 950000.00, 'img/hoa6.jpg', 15, '2024-02-07 04:30:00'),
(14, 1, 'Hoa Cẩm Tú Cầu', 'Bó hoa cẩm tú cầu nhiều màu sắc', 600000.00, 'img/hoa2.jpg', 25, '2024-02-09 20:00:00'),
(15, 1, 'Hoa Đào', 'Bó hoa đào tươi tắn, biểu tượng của mùa xuân', 700000.00, 'img/hoa5.jpg', 18, '2024-02-11 21:15:00'),
(16, 1, 'Hoa Oải Hương', 'Bó hoa oải hương thơm ngát, giúp thư giãn', 650000.00, 'img/hoa1.jpg', 22, '2024-02-14 22:45:00'),
(17, 1, 'Hoa Cúc Họa Mi', 'Bó hoa cúc họa mi trắng tinh khôi', 300000.00, 'img/hoa7.jpg', 30, '2024-02-17 23:30:00'),
(18, 1, 'Hoa Thược Dược', 'Bó hoa thược dược rực rỡ sắc màu', 400000.00, 'img/hoa3.jpg', 20, '2024-02-20 00:50:00'),
(19, 1, 'Hoa Sen', 'Bó hoa sen thanh khiết và tinh tế', 550000.00, 'img/hoa8.jpg', 25, '2024-02-22 01:40:00'),
(20, 1, 'Hoa Mộc Lan', 'Bó hoa mộc lan sang trọng và quý phái', 800000.00, 'img/hoa6.jpg', 15, '2024-02-25 02:30:00'),
(21, 1, 'Hoa Bách Hợp', 'Bó hoa bách hợp tinh khiết và thanh cao', 600000.00, 'img/hoa2.jpg', 18, '2024-02-28 03:20:00'),
(22, 1, 'Hoa Cát Tường', 'Bó hoa cát tường mang lại may mắn', 450000.00, 'img/hoa5.jpg', 28, '2024-03-01 04:15:00'),
(23, 1, 'Hoa Phong Lan', 'Bó hoa phong lan quý phái và sang trọng', 950000.00, 'img/hoa4.jpg', 12, '2024-03-03 05:00:00'),
(54, 2, 'Hoa Hồng Đỏ', 'Hoa hồng đỏ tươi thắm', 150000.00, 'img/hoa1.jpg', 100, '2023-09-30 17:00:00'),
(55, 3, 'Hoa Tulip', 'Hoa tulip nhập khẩu', 200000.00, 'img/hoa2.jpg', 50, '2023-10-01 17:00:00'),
(56, 2, 'Hoa Cẩm Tú Cầu', 'Hoa cẩm tú cầu xanh', 180000.00, 'img/hoa3.jpg', 75, '2023-10-02 17:00:00'),
(57, 3, 'Hoa Ly', 'Hoa ly thơm ngát', 220000.00, 'img/hoa4.jpg', 60, '2023-10-03 17:00:00'),
(58, 2, 'Hoa Lan', 'Hoa lan hồ điệp', 250000.00, 'img/hoa5.jpg', 40, '2023-10-04 17:00:00'),
(59, 3, 'Hoa Cúc', 'Hoa cúc vàng rực rỡ', 120000.00, 'img/hoa6.jpg', 90, '2023-10-05 17:00:00'),
(60, 2, 'Hoa Thược Dược', 'Hoa thược dược đủ màu', 160000.00, 'img/hoa7.jpg', 80, '2023-10-06 17:00:00'),
(61, 3, 'Hoa Hướng Dương', 'Hoa hướng dương tươi sáng', 140000.00, 'img/hoa8.jpg', 70, '2023-10-07 17:00:00'),
(62, 2, 'Hoa Mẫu Đơn', 'Hoa mẫu đơn kiêu sa', 300000.00, 'img/hoa1.jpg', 30, '2023-10-08 17:00:00'),
(63, 3, 'Hoa Sen', 'Hoa sen thanh tao', 170000.00, 'img/hoa2.jpg', 50, '2023-10-09 17:00:00'),
(64, 2, 'Hoa Đồng Tiền', 'Hoa đồng tiền may mắn', 130000.00, 'img/hoa3.jpg', 65, '2023-10-10 17:00:00'),
(65, 3, 'Hoa Cẩm Chướng', 'Hoa cẩm chướng đỏ', 190000.00, 'img/hoa4.jpg', 55, '2023-10-11 17:00:00'),
(66, 2, 'Hoa Phong Lan', 'Hoa phong lan tím', 230000.00, 'img/hoa5.jpg', 45, '2023-10-12 17:00:00'),
(67, 3, 'Hoa Lài', 'Hoa lài thơm ngát', 110000.00, 'img/hoa6.jpg', 85, '2023-10-13 17:00:00'),
(68, 2, 'Hoa Mai', 'Hoa mai vàng ngày Tết', 210000.00, 'img/hoa7.jpg', 35, '2023-10-14 17:00:00'),
(69, 3, 'Hoa Cúc Họa Mi', 'Hoa cúc họa mi trắng', 150000.00, 'img/hoa8.jpg', 95, '2023-10-15 17:00:00'),
(70, 2, 'Hoa Dã Quỳ', 'Hoa dã quỳ vàng', 125000.00, 'img/hoa1.jpg', 75, '2023-10-16 17:00:00'),
(71, 3, 'Hoa Bách Hợp', 'Hoa bách hợp trắng', 240000.00, 'img/hoa2.jpg', 65, '2023-10-17 17:00:00'),
(72, 2, 'Hoa Tigon', 'Hoa tigon hồng', 135000.00, 'img/hoa3.jpg', 55, '2023-10-18 17:00:00'),
(73, 3, 'Hoa Cẩm Tú', 'Hoa cẩm tú cầu hồng', 185000.00, 'img/hoa4.jpg', 45, '2023-10-19 17:00:00'),
(74, 2, 'Hoa Cúc Đại Đóa', 'Hoa cúc đại đóa vàng', 155000.00, 'img/hoa5.jpg', 35, '2023-10-20 17:00:00'),
(75, 3, 'Hoa Mộc Lan', 'Hoa mộc lan trắng', 270000.00, 'img/hoa6.jpg', 25, '2023-10-21 17:00:00'),
(76, 2, 'Hoa Lưu Ly', 'Hoa lưu ly xanh', 145000.00, 'img/hoa7.jpg', 95, '2023-10-22 17:00:00'),
(77, 3, 'Hoa Anh Đào', 'Hoa anh đào Nhật Bản', 260000.00, 'img/hoa8.jpg', 85, '2023-10-23 17:00:00'),
(78, 2, 'Hoa Cẩm Tú Cầu', 'Hoa cẩm tú cầu xanh', 180000.00, 'img/hoa1.jpg', 75, '2023-10-24 17:00:00'),
(79, 3, 'Hoa Ly', 'Hoa ly thơm ngát', 220000.00, 'img/hoa2.jpg', 60, '2023-10-25 17:00:00'),
(80, 2, 'Hoa Lan', 'Hoa lan hồ điệp', 250000.00, 'img/hoa3.jpg', 40, '2023-10-26 17:00:00'),
(81, 3, 'Hoa Cúc', 'Hoa cúc vàng rực rỡ', 120000.00, 'img/hoa4.jpg', 90, '2023-10-27 17:00:00'),
(82, 2, 'Hoa Thược Dược', 'Hoa thược dược đủ màu', 160000.00, 'img/hoa5.jpg', 80, '2023-10-28 17:00:00'),
(83, 3, 'Hoa Hướng Dương', 'Hoa hướng dương tươi sáng', 140000.00, 'img/hoa6.jpg', 70, '2023-10-29 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

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
  ADD KEY `fk_orders_users` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
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
ALTER TABLE `users`
  ADD PRIMARY KEY (`phone`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
