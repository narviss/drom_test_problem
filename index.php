<?php
session_start();
header('Content-Type: text/html; charset=UTF8');

$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;

require('config/config.php'); //Файл конфига
require('config/database.php'); //Файл работы с БД
require('route.php'); //Роутер

new Router($user);

?>
