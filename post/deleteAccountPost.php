<?php
require('../database.php');
if(isset($_POST['account_name']))
{
    $accountname = $_POST['account_name'];
    $category = $_POST['category'];
    echo $category;
    if($category == 'Asset')
    {

    }
    else if( $category == 'Liability')
    {

    }
    else if ($category == 'Equity')
    {

    }
    else if ($category == 'Revenue')
    {

    }
    else if( $category == 'Expenses')
    {

    }
}
?>