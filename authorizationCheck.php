<?php
session_start();
if($_SESSION['isAdmin'] == false && $_SESSION['isManager'] == false)
{
    header("Location: login");
    exit;
}
?>