<?php
require("../database.php");
$date = date("Y-m-d", time());
$time_ = date("H:i:s", time());
$clientID = $_SESSION['userid'];

if($_POST['type'] == 'addLine') {
    $rowCount = $_POST['rowCount'];
    $accountID = $_POST['accountID'];
    $debit = $_POST['debit'];
    $credit = $_POST['credit'];
    $addDescription = $_POST['addDescription'];
    $referenceID = $_POST['referenceID'];
    $accountType = $accountID[0];



    $stmt = $pdo->prepare("SELECT accName from accountnames where accID=:accID");
    $stmt->bindValue(":accID", $accountID);
    $stmt->execute();
    $temp = $stmt->fetch(PDO::FETCH_ASSOC);
    $accountName = $temp['accName'];

    $addDebit = $debit;
    $addCredit = $credit;

    $stmt = $pdo->prepare("INSERT into journal_data(journal_data_id, accName, accID, accountType, description, debit, credit, referenceID) values (:journalID, :accName, :accID, :accountType, :description, :debit, :credit, :referenceID)");
    $stmt->bindValue(":journalID", $rowCount);
    $stmt->bindValue(":accName", $accountName);
    $stmt->bindValue(":accID", $accountID);
    $stmt->bindValue(":accountType", $accountType);
    $stmt->bindValue(":description", $addDescription);
    $stmt->bindValue(":debit", $addDebit);
    $stmt->bindValue(":credit", $addCredit);
    $stmt->bindValue(":referenceID", $referenceID);
    $stmt->execute();

    $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
    $stmt->bindValue(":id", $clientID);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $userInfo['firstname'].' '.$userInfo['lastname'];

    $logDesc = $name . ' created a journal data with a reference ID: '.$referenceID. ' on '.$date;

    $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
    $stmt->bindValue(':accID', $accountID);
    $stmt->bindValue(':modifiedBy', $clientID);
    $stmt->bindValue(':dateModified', $date);
    $stmt->bindValue(':time', $time_);
    $stmt->bindValue(':details', $logDesc);
    $stmt->execute();


    echo "Success!";



}
if($_POST['type'] == 'editLine')
{
    $rowCount = $_POST['rowCount'];
    $accountName = $_POST['accountname'];
    $debit = $_POST['debit'];
    $credit = $_POST['credit'];
    $addDescription = $_POST['addDescription'];
    $referenceID = $_POST['referenceID'];

    $addDebit = $debit;
    $addCredit = $credit;

    $stmt = $pdo->prepare("SELECT accID from accountnames where accName=:accountname");
    $stmt->bindValue(":accountname", $accountName);
    $stmt->execute();
    $temp = $stmt->fetch(PDO::FETCH_ASSOC);
    $accountID = $temp['accID'];
    $accountType = strval($accountID)[0];

    $stmt = $pdo->prepare("UPDATE journal_data SET accName=:accName, accID=:accID, accountType=:accountType, description=:description, debit=:debit, credit=:credit WHERE journal_data_id=:journalID AND referenceID=:referenceID");
    $stmt->bindValue(":journalID", $rowCount);
    $stmt->bindValue(":accName", $accountName);
    $stmt->bindValue(":accID", $accountID);
    $stmt->bindValue(":accountType", $accountType);
    $stmt->bindValue(":description", $addDescription);
    $stmt->bindValue(":debit", $addDebit);
    $stmt->bindValue(":credit", $addCredit);
    $stmt->bindValue(":referenceID", $referenceID);
    $stmt->execute();

    $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
    $stmt->bindValue(":id", $clientID);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $userInfo['firstname'].' '.$userInfo['lastname'];

    $logDesc = $name . ' edited a journal data with a reference ID: '.$referenceID. ' on '.$date;

    $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
    $stmt->bindValue(':accID', $accountID);
    $stmt->bindValue(':modifiedBy', $clientID);
    $stmt->bindValue(':dateModified', $date);
    $stmt->bindValue(':time', $time_);
    $stmt->bindValue(':details', $logDesc);
    $stmt->execute();

    echo 'Success!';

}
if($_POST['type'] == 'deleteLine')
{
    $rowCount = $_POST['rowCount'];
    $referenceID = $_POST['referenceID'];
    $stmt = $pdo->prepare("DELETE FROM journal_data WHERE journal_data_id=:journalID AND referenceID=:referenceID");
    $stmt->bindValue(":journalID", $rowCount);
    $stmt->bindValue(":referenceID", $referenceID);
    $stmt->execute();

    $stmt = $pdo->prepare('SELECT firstname, lastname FROM account where id=:id');
    $stmt->bindValue(":id", $clientID);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $userInfo['firstname'].' '.$userInfo['lastname'];

    $logDesc = $name . ' deleted a journal data with a reference ID: '.$referenceID. ' on '.$date;

    $stmt = $pdo->prepare('INSERT into eventlog(accID, modifiedBy, dateModified, time, details) values (:accID, :modifiedBy, :dateModified, :time, :details)');
    $stmt->bindValue(':accID', $accountID);
    $stmt->bindValue(':modifiedBy', $clientID);
    $stmt->bindValue(':dateModified', $date);
    $stmt->bindValue(':time', $time_);
    $stmt->bindValue(':details', $logDesc);
    $stmt->execute();

    echo "Successfull deleted!";
}
?>

