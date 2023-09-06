<?php

require '../config/config.php';
require '../config/functions.php';

checkLogin();

$statement = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
$statement->execute();

header('location: index.php');

?>