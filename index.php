<?php

header('Content-Type: text/html; charset=utf-8');
require('route.php');
include('category/main/head.html');
new Router();
include('category/main/footer.html');
?>
