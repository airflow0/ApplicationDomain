<?php

require('database.php');
require('admin_navigation.php');


$time = date("Y-m-d H:i:s", time());
$clientID = $_SESSION['userid'];

$journal = $pdo->query("SELECT * FROM journal");
$journal->execute();
$referenceID = $journal->rowCount() + 1;
$status = 0;
$stmt = $pdo->prepare('INSERT into journal(referenceID,dateCreated, status, createdBy) values (:referenceID,:dateCreated, :status, :createdBy)');
$stmt->bindValue(":referenceID", $referenceID);
$stmt->bindValue(":dateCreated", $time);
$stmt->bindValue(":status", $status);
$stmt->bindValue(":createdBy", $clientID);
$stmt->execute();

header("Location: edit_journal?referenceID=".$referenceID);

?>