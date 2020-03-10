<?php
require('../database.php');
if(isset($_POST['account_name']))
{
    $accountname = $_POST['account_name'];
    $category = $_POST['category'];

    if($category == 'Asset')
    {
        $stmt = $pdo->prepare('DELETE from assets WHERE accName=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();

        echo "Account securely deleted";
    }
    else if( $category == 'Liability')
    {
        $stmt = $pdo->prepare('DELETE from liability,accountnames WHERE accName=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();
        echo "Account securely deleted";
    }
    else if ($category == 'Equity')
    {
        $stmt = $pdo->prepare('DELETE from equity,accountnames WHERE accName=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();
        echo "Account securely deleted";
    }
    else if ($category == 'Revenue')
    {
        $stmt = $pdo->prepare('DELETE from revenue,accountnames WHERE accName=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();
        echo "Account securely deleted";
    }
    else if( $category == 'Expenses')
    {
        $stmt = $pdo->prepare('DELETE from expenses,accountnames WHERE accName=:accName');
        $stmt->bindValue(':accName', $accountname);
        $stmt->execute();
        echo "Account securely deleted";
    }
    $stmt = $pdo->prepare('DELETE from accountnames WHERE accName=:accName');
    $stmt->bindValue(':accName', $accountname);
    $stmt->execute();
}
?>