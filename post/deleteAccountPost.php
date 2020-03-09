<?php
require('../database.php');
if(isset($_POST['account_name']))
{
    $accountname = $_POST['account_name'];
    $category = $_POST['category'];
    echo $category;
    if($category == 'Asset')
    {
        echo 'Asset';
    }
    else if( $category == 'Liability')
    {
        echo 'Liability';
    }
    else if ($category == 'Equity')
    {
        echo 'Equity';
    }
    else if ($category == 'Revenue')
    {
        echo 'Revenue';
    }
    else if( $category == 'Expenses')
    {
        echo 'Expenses';
    }
}
?>