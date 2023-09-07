<?php
session_start();

require 'config/functions.php';

checkLogin();
session_destroy();

echo "<script>alert('Successfully logout your Acount!'); window.location = 'index.php';</script>";
// header('location: index.php');
?>


