<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('MYSQL_USER','root');
define('MYSQL_PASSWORD','');
define('MYSQL_HOST','localhost');
// define('MYSQL_PORT',3307);
define('MYSQL_DATABASE','blog');

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
);

$pdo = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD,$options);