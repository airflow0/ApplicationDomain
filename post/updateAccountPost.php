<?php
require('../database.php');
if(isset($_POST['accountname']))
{
    $clientID = $_SESSION['userid'];
    $date = date("Y-m-d", time());
    $time = date("H:i:s", time()); // 3 Days
    $accountName = trim($_POST['accountname']);
    $accountID = $_POST['accountId'];
    $description = $_POST['description'];
    echo($accountID);
    $stmt = $pdo->prepare("SELECT accName FROM accountnames where accName = :accName");
    $stmt->bindValue(':accName', $accountName);
    $stmt->execute();
        if($_POST['category'] == 1)
        {

            $details = "";
            $stmt = $pdo->prepare('SELECT accName, description from assets where accID= :accID');
            $stmt->bindValue(":accID", $accountID);
            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_ASSOC);
            $previousName = $check['accName'];
            $previousDescription = $check['description'];

            if($accountName != $previousName)
            {
                $details = $details."Account name changed to ".$accountName."; ";
            }
            if($description != $previousDescription)
            {
                $details = $details."Description was changed to: ".$description."; ";
            }
            $stmt = $pdo->prepare('UPDATE assets SET accName=:accName, description=:description WHERE accID=:accID');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':accID', $accountID);
            $stmt->execute();

            $stmt = $pdo->prepare("UPDATE accountnames SET accName=:accName, accountType=1 WHERE accName=:previousAccName");
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':previousAccName', $previousName);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into eventlog(modifiedBy, dateModified, time, details, accID) values (:modifiedBy, :date, :time, :details, :accID)");
            $stmt-> bindValue(":modifiedBy", $clientID);
            $stmt-> bindValue(":date", $date);
            $stmt-> bindValue(":time", $time);
            $stmt-> bindValue(":details", $details);
            $stmt-> bindValue(":accID", $accountID);
            $stmt->execute();


        }
        else if ($_POST['category'] == 2)
        {
            $details = "";
            $stmt = $pdo->prepare('SELECT accName, description from liability where accID= :accID');
            $stmt->bindValue(":accID", $accountID);
            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_ASSOC);
            $previousName = $check['accName'];
            $previousDescription = $check['description'];

            if($accountName != $previousName)
            {
                $details = $details."Account name changed to ".$accountName."; ";
            }
            if($description != $previousDescription)
            {
                $details = $details."Description was changed to: ".$description."; ";
            }
            $stmt = $pdo->prepare('UPDATE liability SET accName=:accName, description=:description WHERE accID=:accID');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':accID', $accountID);
            $stmt->execute();

            $stmt = $pdo->prepare("UPDATE accountnames SET accName=:accName, accountType=2 WHERE accName=:previousAccName");
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':previousAccName', $previousName);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into eventlog(modifiedBy, dateModified, time, details, accID) values (:modifiedBy, :date, :time, :details, :accID)");
            $stmt-> bindValue(":modifiedBy", $clientID);
            $stmt-> bindValue(":date", $date);
            $stmt-> bindValue(":time", $time);
            $stmt-> bindValue(":details", $details);
            $stmt-> bindValue(":accID", $accountID);
            $stmt->execute();


        }
        else if ($_POST['category'] == 3)
        {
            $details = "";
            $stmt = $pdo->prepare('SELECT accName, description from equity where accID= :accID');
            $stmt->bindValue(":accID", $accountID);
            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_ASSOC);
            $previousName = $check['accName'];
            $previousDescription = $check['description'];

            if($accountName != $previousName)
            {
                $details = $details."Account name changed to ".$accountName."; ";
            }
            if($description != $previousDescription)
            {
                $details = $details."Description was changed to: ".$description."; ";
            }
            $stmt = $pdo->prepare('UPDATE equity SET accName=:accName, description=:description WHERE accID=:accID');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':accID', $accountID);
            $stmt->execute();

            $stmt = $pdo->prepare("UPDATE accountnames SET accName=:accName, accountType=3 WHERE accName=:previousAccName");
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':previousAccName', $previousName);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into eventlog(modifiedBy, dateModified, time, details, accID) values (:modifiedBy, :date, :time, :details, :accID)");
            $stmt-> bindValue(":modifiedBy", $clientID);
            $stmt-> bindValue(":date", $date);
            $stmt-> bindValue(":time", $time);
            $stmt-> bindValue(":details", $details);
            $stmt-> bindValue(":accID", $accountID);
            $stmt->execute();
        }
        else if ($_POST['category'] == 4)
        {
            $details = "";
            $stmt = $pdo->prepare('SELECT accName, description from revenue where accID= :accID');
            $stmt->bindValue(":accID", $accountID);
            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_ASSOC);
            $previousName = $check['accName'];
            $previousDescription = $check['description'];

            if($accountName != $previousName)
            {
                $details = $details."Account name changed to ".$accountName."; ";
            }
            if($description != $previousDescription)
            {
                $details = $details."Description was changed to: ".$description."; ";
            }
            $stmt = $pdo->prepare('UPDATE revenue SET accName=:accName, description=:description WHERE accID=:accID');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':accID', $accountID);
            $stmt->execute();

            $stmt = $pdo->prepare("UPDATE accountnames SET accName=:accName, accountType=4 WHERE accName=:previousAccName");
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':previousAccName', $previousName);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into eventlog(modifiedBy, dateModified, time, details, accID) values (:modifiedBy, :date, :time, :details, :accID)");
            $stmt-> bindValue(":modifiedBy", $clientID);
            $stmt-> bindValue(":date", $date);
            $stmt-> bindValue(":time", $time);
            $stmt-> bindValue(":details", $details);
            $stmt-> bindValue(":accID", $accountID);
            $stmt->execute();
        }
        else if ($_POST['category'] == 5)
        {
            $details = "";
            $stmt = $pdo->prepare('SELECT accName, description from expenses where accID= :accID');
            $stmt->bindValue(":accID", $accountID);
            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_ASSOC);
            $previousName = $check['accName'];
            $previousDescription = $check['description'];

            if($accountName != $previousName)
            {
                $details = $details."Account name changed to ".$accountName."; ";
            }
            if($description != $previousDescription)
            {
                $details = $details."Description was changed to: ".$description."; ";
            }
            $stmt = $pdo->prepare('UPDATE expenses SET accName=:accName, description=:description WHERE accID=:accID');
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':accID', $accountID);
            $stmt->execute();

            $stmt = $pdo->prepare("UPDATE accountnames SET accName=:accName, accountType=5 WHERE accName=:previousAccName");
            $stmt->bindValue(':accName', $accountName);
            $stmt->bindValue(':previousAccName', $previousName);
            $stmt->execute();

            $stmt = $pdo->prepare("INSERT into eventlog(modifiedBy, dateModified, time, details, accID) values (:modifiedBy, :date, :time, :details, :accID)");
            $stmt-> bindValue(":modifiedBy", $clientID);
            $stmt-> bindValue(":date", $date);
            $stmt-> bindValue(":time", $time);
            $stmt-> bindValue(":details", $details);
            $stmt-> bindValue(":accID", $accountID);
            $stmt->execute();
    }

}
?>