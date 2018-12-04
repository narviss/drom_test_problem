<?php
session_start();
header('Content-Type: text/html; charset=UTF8');
Error_Reporting(E_ALL & ~E_NOTICE);

$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;

require('config/config.php');
require('config/database.php');
require('route.php');

new Router($user);

?>
