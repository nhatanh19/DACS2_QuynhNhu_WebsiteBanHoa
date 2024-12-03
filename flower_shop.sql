-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 03, 2024 lúc 02:31 PM
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
(10, 2, 'Bộ Bodysuit Cotton', 'Bộ bodysuit cotton mềm mại cho bé 0-6 tháng', 180000.00, 'img/baby1.jpg', 50, '2024-01-21 08:10:00'),
(11, 2, 'Tã Quần Huggies', 'Tã quần cao cấp size M (6-11kg)', 285000.00, 'img/baby3.jpg', 100, '2024-01-22 09:00:00'),
(12, 2, 'Sữa Enfamil A+', 'Sữa bột công thức cho bé 0-6 tháng', 485000.00, 'img/baby2.jpg', 40, '2024-01-23 02:00:00'),
(13, 2, 'Khăn Sữa Carter', 'Set 8 khăn sữa cotton mềm mịn', 120000.00, 'img/baby4.jpg', 75, '2024-01-24 03:30:00'),
(14, 2, 'Bộ Đồ Chơi Xúc Xắc', 'Bộ đồ chơi xúc xắc nhiều màu sắc', 150000.00, 'img/baby5.jpg', 45, '2024-01-25 04:45:00'),
(15, 3, 'Hộp Quà Tết Cao Cấp', 'Hộp quà tết cao cấp với các sản phẩm độc đáo', 1200000.00, 'img/hoa6.jpg', 15, '2024-01-26 06:20:00'),
(16, 3, 'Giỏ Trái Cây Nhập Khẩu', 'Giỏ trái cây nhập khẩu cao cấp', 850000.00, 'img/hoa8.jpg', 20, '2024-01-27 07:15:00'),
(17, 2, 'Bình Sữa Pigeon', 'Bình sữa chống sặc cho bé', 180000.00, 'img/baby1.jpg', 60, '2024-01-28 08:30:00'),
(18, 1, 'Hoa Baby Trắng', 'Bó hoa baby trắng tinh khôi', 280000.00, 'img/hoa3.jpg', 35, '2024-01-29 09:45:00'),
(19, 3, 'Giỏ Quà Tặng Sinh Nhật', 'Giỏ quà tặng sinh nhật sang trọng', 650000.00, 'img/hoa7.jpg', 25, '2024-01-30 10:00:00'),
(20, 2, 'Gối Chặn Cho Bé', 'Gối chặn hình thú dễ thương', 220000.00, 'img/baby5.jpg', 40, '2024-01-31 01:00:00'),
(21, 1, 'Hoa Cúc Tana', 'Bó hoa cúc tana rực rỡ', 320000.00, 'img/hoa4.jpg', 28, '2024-02-01 02:30:00'),
(22, 3, 'Hộp Quà Valentine', 'Hộp quà valentine lãng mạn', 750000.00, 'img/hoa1.jpg', 30, '2024-02-02 03:45:00'),
(23, 2, 'Đồ Chơi Phát Triển', 'Bộ đồ chơi phát triển trí tuệ', 350000.00, 'img/baby2.jpg', 35, '2024-02-03 04:20:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
