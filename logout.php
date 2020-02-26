<?php
require('database.php');
session_start();
$id = $_SESSION['clientID'];
$stmt = $pdo->prepare('UPDATE account SET loginattempt=:loginattempt WHERE id=:id');
$stmt->bindValue(":loginattempt", 0);
$stmt->bindValue(":id", $id);
$stmt->execute();
session_destroy();
header('Location: Login');
exit;
?>