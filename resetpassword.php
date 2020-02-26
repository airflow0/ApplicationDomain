<?php
require('database.php');
$passworderr = "";
$id = $_GET['id'];
session_start();
if(!$_SESSION['resetvalidity'] == true)
{
    header('Location: login');
}
$stmt = $pdo->prepare("SELECT reset, password_expiration_date FROM account WHERE id=:id");
$stmt->bindValue(":id", $id);
$stmt->execute();
$sinfo = $stmt->fetch(PDO::FETCH_ASSOC);
$reset = $sinfo['reset'];
$expirationDate =$sinfo['password_expiration_date'];
$newDate = date('Y-m-d H:i:s', strtotime("+60 days"));

if($reset != 1)
{
    header("Location: login");
}
if(isset($_POST['reset']))
{
    $validator = true;
    $password = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);

    if (empty($password)) {
        $passworderr = "Password is required!";
        $validator = false;
    } else if (strlen($password) > 60) {
        $passworderr = "Password cannot be greater than 60 characters!";
        $validator = false;
    } elseif (strlen($password) < 8) {
        $passworderr = "Password cannot be less than 8 characters!";
        $validator = false;
    }
    else if  (!preg_match("/\d/", $password)) {
        $passworderr = "Password should contain at least one digit";
        $validator = false;
    }
    else if  (!preg_match("/[A-Z]/", $password)) {
        $passworderr = "Password must contain at least a single Upper Case letter.";
        $validator = false;
    }
    else if  (!preg_match("/[a-z]/", $password)) {
        $passworderr = "Password must contain at least a single letter.";
        $validator = false;
    }
    else if  (!preg_match("/\W/", $password)) {
        $passworderr = "Password should contain at least one special character";
        $validator = false;
    }
    else if  (preg_match("/\s/", $password)) {
        $passworderr = "Password should not contain any white space";
        $validator = false;
    }else if($password != $password2) {
        $passworderr = "Password cofirmation error!";
        $validator = false;
    }
    $stmt= $pdo->prepare("select password from account where id=:id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    $previouspassword = $info['password'];
    if(password_verify($password, $previouspassword))
    {
       $passworderr = "Previous passwords cannot be used!";
        $validator = false;
    }
    if($validator)
    {
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE account SET password=:password1, previouspassword=:password2, reset=:reset, password_expiration_date=:date where id=:id");
        $stmt->bindValue(":password1", $hashedpassword);
        $stmt->bindValue(":password2", $previouspassword);
        $stmt->bindValue(":reset", 0);
        $stmt->bindValue(":date", $newDate);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        header("Location: login");
    }

}



?>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<img src="images/logo.png" style="width: 5%;"/>
<div class="registrationContainer">

    <div class="registration-box">
        <br />
        <img src="/images/avatar3.png" class="avatar">
        <br />
        <h1> Reset Password </h1>
        <p> Please fill the following to reset your password!</p>
        <form method="post">
            <br/>
            <span class="error"><?php echo $passworderr ?></span>
            <br/>
            <input type="password" name="password1" placeholder="Password" required/>
            <br/>
            <input type="password" name="password2" placeholder="Confirm Password" required/>
            <br/>
            <br/>
            <input type="submit" value="Submit" name="reset" min="6" max="30" required/>
        </form>
    </div>
</div>
</body>
</html>
