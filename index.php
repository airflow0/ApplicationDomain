<!DOCTYPE html>
<?php
require 'database.php';
?>
<head>
<title> Website name  </title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/font-face.css">
</head>
    <body>
       <?php require('navigation.php'); ?>
       <?php
       session_start();
       if($_SESSION['loggedin'] == false)
       {
           header('Location: login');
           exit;
       }
       else if($_SESSION['isAdmin'] || $_SESSION['isManager'])
       {
           header("Location: admin_cp");
           exist;
       }
       else
       {
           header('Location: dashboard');
           exit;
       }
       ?>
    </body>
</html>