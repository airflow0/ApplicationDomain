<?php
require('database.php');
if(isset($_POST['switchtovalid']))
{
    $getID = $_GET['id'];
    $stmt=$pdo->prepare("UPDATE account SET isActive=:isvalid where id=:id");
    $stmt->bindValue(":isvalid", "1");
    $stmt->bindValue(":id", $getID);
    $stmt->execute();
    header('Location: admin_user_table');
    exit;
}
if(isset($_POST['switchtoinvalid']))
{
    $getID = $_GET['id'];
    $stmt=$pdo->prepare("UPDATE account SET isActive=:isvalid where id=:id");
    $stmt->bindValue(":isvalid", "0");
    $stmt->bindValue(":id", $getID);
    $stmt->execute();
    header('Location: admin_user_table');
    exit;
}
if(isset($_POST['promoteToManager']))
{
    $getID = $_GET['id'];
    $stmt=$pdo->prepare("UPDATE account SET isManager=:isvalid where id=:id");
    $stmt->bindValue(":isvalid", "1");
    $stmt->bindValue(":id", $getID);
    $stmt->execute();
    header('Location: admin_user_table');
    exit;
}
if(isset($_POST['unpromoteToManager']))
{
    $getID = $_GET['id'];
    $stmt=$pdo->prepare("UPDATE account SET isManager=:isvalid where id=:id");
    $stmt->bindValue(":isvalid", "0");
    $stmt->bindValue(":id", $getID);
    $stmt->execute();
    header('Location: admin_user_table');
    exit;
}
if(isset($_POST['promoteToAdmin']))
{
    $getID = $_GET['id'];
    $stmt=$pdo->prepare("UPDATE account SET isAdmin=:isvalid where id=:id");
    $stmt->bindValue(":isvalid", "1");
    $stmt->bindValue(":id", $getID);
    $stmt->execute();
    header('Location: admin_user_table');
    exit;
}
if(isset($_POST['unpromoteToAdmin']))
{
    $getID = $_GET['id'];
    $stmt=$pdo->prepare("UPDATE account SET isAdmin=:isvalid where id=:id");
    $stmt->bindValue(":isvalid", "0");
    $stmt->bindValue(":id", $getID);
    $stmt->execute();
    header('Location: admin_user_table');
    exit;
}
?>

