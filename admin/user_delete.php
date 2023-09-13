<?php
require '../config/config.php';
require '../config/functions.php';

checkAdmin();

$stmt = $pdo->prepare('DELETE FROM users WHERE id='.$_GET['id']);
$stmt->execute();

echo "<script> 
alert('Successfully deleted!!');
window.location.href='user_show.php';
</script>";

?>