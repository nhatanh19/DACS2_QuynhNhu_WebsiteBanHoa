<?php
require_once 'cart_functions.php';

header('Content-Type: application/json');

$response = [
    'success' => true,
    'count' => getCartCount()
];

echo json_encode($response);
