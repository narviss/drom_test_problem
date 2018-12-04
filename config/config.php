<?php
/**
 * Конфигурационный файл
 * Site: http://bezramok-tlt.ru
 * Регистрация пользователя письмом
 */

//Адрес базы данных
define('DBSERVER','localhost');

//Логин БД
define('DBUSER','root');

//Пароль БД
define('DBPASSWORD','');

//БД
define('DATABASE','drom_test');

//Errors
define('ERROR_CONNECT','Немогу соеденится с БД');

//Errors
define('NO_DB_SELECT','Данная БД отсутствует на сервере');

//Адрес хоста сайта
define('HOST','http://'. $_SERVER['HTTP_HOST'] .'/');

?>
