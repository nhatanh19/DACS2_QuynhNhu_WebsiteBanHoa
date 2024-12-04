-- Tạo bảng order_details để lưu chi tiết từng sản phẩm trong đơn hàng
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Xóa khóa ngoại cũ từ bảng orders
ALTER TABLE `orders` DROP FOREIGN KEY `orders_ibfk_1`;

-- Sửa lại bảng orders
ALTER TABLE `orders` 
  DROP COLUMN `product_id`,
  DROP COLUMN `quantity`,
  MODIFY `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00';
