<?php
session_start();
require_once 'database.php';
require_once 'controllers/LoginController.php';

$conn = require 'database.php';
$controller = new LoginController($conn);
$controller->login();
