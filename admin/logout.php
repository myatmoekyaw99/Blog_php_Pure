<?php
session_start();

require '../config/functions.php';

checkLogin();
session_destroy();

header('location: login.php');
?>


