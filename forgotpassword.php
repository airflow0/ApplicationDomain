<?php
session_start();
require('database.php');
$emailerr = "";
$valid = true;
if (isset($_POST['forgotpassword'])) {
    $email = trim($_POST['email']);
    echo $email;
    $stmt = $pdo->prepare("SELECT email FROM account WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $emailerr = 'Email already exists!';
        $valid = false;
    }
    $emailerr = 'Email does not exist!';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerr = "Invalid email!";
        $valid = false;
    }
    $stmt = $pdo->prepare("SELECT id FROM account where email= :email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    if(valid)
    {
        header("Location: validatesecurity?id=".$id['id']);
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
<img class="mx-auto d-block" src="images/logo-revised.png" style="width: 300px; padding: 20px">
<div class="registrationContainer">

    <div class="registration-box">
        <a href="login"><p class="glyphicon glyphicon-menu-left"></p>Back to Login</a>
        <br/>
        <img src="/images/avatar3.png" class="avatar">
        <br/>
        <h1> Find Password </h1>
        <p> Please fill the following to reset your password!</p>
        <form method="post">
            <br/>
            <span class="error"><span class="error"><?php echo $emailerr; ?></span>
            <input type="text" name="email" placeholder="Email" required/>
            <br/>
            <br/>
            <input type="submit" value="Next" name="forgotpassword" min="6" max="30" required/>
        </form>
    </div>
</div>
</body>
</html>