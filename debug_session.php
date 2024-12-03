<?php
session_start();
echo "<pre>";
echo "Session Data:\n";
print_r($_SESSION);
echo "\n\nChecking isLoggedIn():\n";
require_once 'includes/session.php';
var_dump(isLoggedIn());

if (isLoggedIn()) {
    echo "\n\nUser Info from Database:\n";
    $conn = require 'database.php';
    $userInfo = getCurrentUser($conn);
    print_r($userInfo);
}
echo "</pre>";
