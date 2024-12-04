-- Thêm cột user_id
ALTER TABLE `orders` ADD `user_id` int NULL AFTER `id`;

-- Cập nhật dữ liệu hiện có (giả sử lấy user_id đầu tiên từ bảng users)
UPDATE `orders` SET `user_id` = (SELECT `id` FROM `users` LIMIT 1);

-- Thêm ràng buộc NOT NULL sau khi đã cập nhật dữ liệu
ALTER TABLE `orders` MODIFY `user_id` int NOT NULL;

-- Thêm khóa ngoại
ALTER TABLE `orders` ADD CONSTRAINT `fk_orders_users` 
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);
