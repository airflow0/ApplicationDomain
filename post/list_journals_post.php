<?php
require('../database.php');
if($_POST['type'] == 'getMemo')
{
    $referenceID = $_POST['referenceID'];
    $stmt = $pdo->prepare("SELECT memo from journal WHERE referenceID=:referenceID");
    $stmt->bindValue(":referenceID", $referenceID);
    $stmt->execute();
    $memo = $stmt->fetch(PDO::FETCH_ASSOC);
    $memoVerify = $memo['memo'];
    echo $memoVerify;
}
if($_POST['type'] == 'update')
{
    $referenceID = $_POST['referenceID'];
    $memo = $_POST['memo'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE journal SET status=:status, memo=:memo WHERE referenceID=:referenceID");
    $stmt->bindValue(":status", $status);
    $stmt->bindValue(":memo", $memo);
    $stmt->bindValue(":referenceID", $referenceID);
    $stmt->execute();
    echo "Updated!";
}
?>