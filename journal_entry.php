<?php
require('database.php');

$time = date("Y-m-d H:i:s", time());
$clientID = $_SESSION['userid'];
$date = date("Y-m-d", time());
$time_ = date("H:i:s", time());

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


$stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
$stmt->bindValue(":id", $clientID);
$stmt->execute();
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
$name = $userInfo['firstname'].' '.$userInfo['lastname'];

$logDesc = $name . ' created a journal with a reference ID: '.$referenceID. ' on '.$date;

$stmt = $pdo->prepare('INSERT into eventlog(modifiedBy, dateModified, time, details) values ( :modifiedBy, :dateModified, :time, :details)');
$stmt->bindValue(':modifiedBy', $clientID);
$stmt->bindValue(':dateModified', $date);
$stmt->bindValue(':time', $time_);
$stmt->bindValue(':details', $logDesc);
$stmt->execute();

header("Location: edit_journal?referenceID=".$referenceID);

?>