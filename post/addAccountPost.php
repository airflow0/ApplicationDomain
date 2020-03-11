<?php
require('../database.php');
if(isset($_POST['accountname']))
{
    $time = date("Y-m-d H:i:s", time());
    $clientID = $_SESSION['userid'];
    $accountName = trim($_POST['accountname']);
    $description = $_POST['description'];
    $stmt = $pdo->prepare("SELECT accName FROM accountnames where accName = :accName");
    $stmt->bindValue(':accName', $accountName);
    $stmt->execute();
    if($stmt->rowCount() > 0)
    {
        echo 'existerror';
    }
    else
    {
        if($_POST['category'] == 1)
        {
            $stmt = $pdo->prepare('INSERT into assets (accName, description, date, createdBy, LastEditBy) values (:accName, :description, :date, :createdBy, :editBy)');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':date', $time);
            $stmt->bindValue(':createdBy', $clientID);
            $stmt->bindValue(':editBy', $clientID);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into accountnames(accName) values (:accName)");
            $stmt->bindValue(':accName', $accountName);
            $stmt->execute();
            echo 'Account has been successfully added!';

        }
        else if ($_POST['category'] == 2)
        {
            $stmt = $pdo->prepare('INSERT into liability (accName, description, date, createdBy, LastEditBy) values (:accName, :description, :date, :createdBy, :editBy)');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':date', $time);
            $stmt->bindValue(':createdBy', $clientID);
            $stmt->bindValue(':editBy', $clientID);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into accountnames(accName) values (:accName)");
            $stmt->bindValue(':accName', $accountName);
            $stmt->execute();
            echo 'Account has been successfully added!';


        }
        else if ($_POST['category'] == 3)
        {
            $stmt = $pdo->prepare('INSERT into equity (accName, description, date, createdBy, LastEditBy) values (:accName, :description, :date, :createdBy, :editBy)');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':date', $time);
            $stmt->bindValue(':createdBy', $clientID);
            $stmt->bindValue(':editBy', $clientID);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into accountnames(accName) values (:accName)");
            $stmt->bindValue(':accName', $accountName);
            $stmt->execute();
            echo 'Account has been successfully added!';
        }
        else if ($_POST['category'] == 4)
        {
            $stmt = $pdo->prepare('INSERT into revenue (accName, description, date, createdBy, LastEditBy) values (:accName, :description, :date, :createdBy, :editBy)');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':date', $time);
            $stmt->bindValue(':createdBy', $clientID);
            $stmt->bindValue(':editBy', $clientID);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into accountnames(accName) values (:accName)");
            $stmt->bindValue(':accName', $accountName);
            $stmt->execute();
            echo 'Account has been successfully added!';
        }
        else if ($_POST['category'] == 5)
        {
            $stmt = $pdo->prepare('INSERT into expenses (accName, description, date, createdBy, LastEditBy) values (:accName, :description, :date, :createdBy, :editBy)');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':date', $time);
            $stmt->bindValue(':createdBy', $clientID);
            $stmt->bindValue(':editBy', $clientID);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into accountnames(accName) values (:accName)");
            $stmt->bindValue(':accName', $accountName);
            $stmt->execute();
            echo 'Account has been successfully added!';
        }
        else
        {
            echo 'no';
        }
    }

}
?>