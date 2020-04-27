<?php
require('../database.php');
if(isset($_POST['account_name']))
{
    $accountname = $_POST['account_name'];
    $category = $_POST['category'];
    $clientID = $_SESSION['userid'];
    $date = date("Y-m-d", time());
    $time_ = date("H:i:s", time()); // 3 Days

    if($category == 'Asset')
    {
        try {
            $stmt = $pdo->prepare('DELETE from assets WHERE accID=:accName');
            $stmt->bindValue(':accName', $accountname);
            $stmt->execute();

        } catch (PDOException $e)
        {
            echo $e;
        }
        $stmt = $pdo->prepare('DELETE from accountnames WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();


        $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
        $stmt->bindValue(":id", $clientID);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $userInfo['firstname'].' '.$userInfo['lastname'];

        $logDesc = $name . ' deleted an account with an ID '.$accountName. ' on '.$date;

        $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
        $stmt->bindValue(':accID', $accountname);
        $stmt->bindValue(':modifiedBy', $clientID);
        $stmt->bindValue(':dateModified', $date);
        $stmt->bindValue(':time', $time_);
        $stmt->bindValue(':details', $logDesc);
        $stmt->execute();
        echo 'Account has been successfully added!';




        echo "Account securely deleted";

    }
    else if( $category == 'Liability')
    {
        $stmt = $pdo->prepare('DELETE from liability WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('DELETE from accountnames WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
        $stmt->bindValue(":id", $clientID);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $userInfo['firstname'].' '.$userInfo['lastname'];

        $logDesc = $name . ' deleted an account with an ID '.$accountName. ' on '.$date;

        $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
        $stmt->bindValue(':accID', $accountname);
        $stmt->bindValue(':modifiedBy', $clientID);
        $stmt->bindValue(':dateModified', $date);
        $stmt->bindValue(':time', $time_);
        $stmt->bindValue(':details', $logDesc);
        $stmt->execute();
        echo "Account securely deleted";
    }
    else if ($category == 'Equity')
    {
        $stmt = $pdo->prepare('DELETE from equity WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('DELETE from accountnames WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
        $stmt->bindValue(":id", $clientID);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $userInfo['firstname'].' '.$userInfo['lastname'];

        $logDesc = $name . ' deleted an account with an ID '.$accountName. ' on '.$date;

        $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
        $stmt->bindValue(':accID', $accountname);
        $stmt->bindValue(':modifiedBy', $clientID);
        $stmt->bindValue(':dateModified', $date);
        $stmt->bindValue(':time', $time_);
        $stmt->bindValue(':details', $logDesc);
        $stmt->execute();
        echo "Account securely deleted";
    }
    else if ($category == 'Revenue')
    {
        $stmt = $pdo->prepare('DELETE from revenue WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('DELETE from accountnames WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
        $stmt->bindValue(":id", $clientID);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $userInfo['firstname'].' '.$userInfo['lastname'];

        $logDesc = $name . ' deleted an account with an ID '.$accountName. ' on '.$date;

        $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
        $stmt->bindValue(':accID', $accountname);
        $stmt->bindValue(':modifiedBy', $clientID);
        $stmt->bindValue(':dateModified', $date);
        $stmt->bindValue(':time', $time_);
        $stmt->bindValue(':details', $logDesc);
        $stmt->execute();
        echo "Account securely deleted";
    }
    else if( $category == 'Expenses')
    {
        $stmt = $pdo->prepare('DELETE from expenses WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('DELETE from accountnames WHERE accID=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
        $stmt->bindValue(":id", $clientID);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $userInfo['firstname'].' '.$userInfo['lastname'];

        $logDesc = $name . ' deleted an account with an ID '.$accountName. ' on '.$date;

        $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
        $stmt->bindValue(':accID', $accountname);
        $stmt->bindValue(':modifiedBy', $clientID);
        $stmt->bindValue(':dateModified', $date);
        $stmt->bindValue(':time', $time_);
        $stmt->bindValue(':details', $logDesc);
        $stmt->execute();

        echo "Account securely deleted";
    }

}
?>