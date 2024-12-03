<?php
session_start();
require_once 'database.php';
require_once 'controllers/RegisterController.php';

$conn = require 'database.php';
$controller = new RegisterController($conn);
$controller->register();
