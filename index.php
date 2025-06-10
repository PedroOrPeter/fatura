<?php
require_once 'config.php';
require_once 'app/model/User.php';
require_once 'app/controller/UserController.php';

$controller = new UserController($pdo);
$controller->handleRequest();
