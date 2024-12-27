<?php
require_once './models/Order.php';

class OrderController {
    private $orderModel;

    public function __construct($db) {
        $this->orderModel = new Order($db);
    }

    public function getUserOrders($userId) {
        return $this->orderModel->getOrdersByUserId($userId);
    }

    public function getOrderDetails($orderId) {
        return $this->orderModel->getOrderDetails($orderId);
    }
}
