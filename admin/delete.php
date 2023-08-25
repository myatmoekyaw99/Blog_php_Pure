<?php

require '../config/config.php';
require '../config/functions.php';

checkAdmin();

$statement = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
$statement->execute();

header('location: index.php');

?>