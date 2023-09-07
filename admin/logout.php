<?php
session_start();

require '../config/functions.php';

checkAdmin();
session_destroy();

header('location: login.php');
?>


