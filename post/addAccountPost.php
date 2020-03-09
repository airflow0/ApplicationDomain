<?php
require('../database.php');
if(isset($_POST['accountname']))
{
    $time = date("Y-m-d H:i:s", time()); // 3 Days
    $stmt = $pdo->prepare('INSERT into assets ')
    if($_POST['category'] == 1)
    {
        echo 'choose category #1';
    }
    else if ($_POST['category'] == 2)
    {
        echo 'choose category #2';
    }
    else if ($_POST['category'] == 3)
    {
        echo 'choose category #3';
    }
    else if ($_POST['category'] == 4)
    {
        echo 'choose category #4';
    }
    else if ($_POST['category'] == 5)
    {
        echo 'choose category #5';
    }
}
?>