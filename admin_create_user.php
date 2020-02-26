<?php
require('admin_navigation.php');
require 'database.php';
session_start();
$time = date("Y-m-d H:i:s", time() + 259200); // 3 Days
$firstname = $lastname = $email = $password = $address = "";
if (isset($_POST['register'])) {
    $valid = true;
    $fnerr = $lnerr = $emailerr = $passworderr = $doberr = $addresserr = "";

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashedpassword = "";
    $DOB = trim($_POST['DOB']);
    $address = trim($_POST['address']);

    echo $email;
    if (empty($_POST['firstname'])) {
        $fnerr = "First name is required!";
        $valid = false;
    } else {
    }
    if (empty($_POST['lastname'])) {
        $lnerr = "Last name is required!";
        $valid = false;
    } else {
    }
    if (empty($_POST['email'])) {
        $emailerr = "Email is required";
        $valid = false;
    } else {
        $stmt = $pdo->prepare("SELECT email FROM account WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $emailerr = 'Email already exists!';
            $valid = false;
        }

        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailerr = "Invalid email!";
            $valid = false;
        }
    }
    if (empty($_POST['password'])) {
        $passworderr = "Password is required!";
        $valid = false;
    } else if (strlen($_POST['password']) > 60) {
        $passworderr = "Password cannot be greater than 60 characters!";
        $valid = false;
    } elseif (strlen($_POST['password']) < 8) {
        $passworderr = "Password cannot be less than 8 characters!";
        $valid = false;
    }
    else if  (!preg_match("/\d/", $password)) {
        $passworderr = "Password should contain at least one digit";
        $valid = false;
    }
    else if  (!preg_match("/[A-Z]/", $password)) {
        $passworderr = "Password must contain at least a single Upper Case letter.";
        $valid = false;
    }
    else if  (!preg_match("/[a-z]/", $password)) {
        $passworderr = "Password must contain at least a single letter.";
        $valid = false;
    }
    else if  (!preg_match("/\W/", $password)) {
        $passworderr = "Password should contain at least one special character";
        $valid = false;
    }
    else if  (preg_match("/\s/", $password)) {
        $passworderr = "Password should not contain any white space";
        $valid = false;
    }else {

    }
    if (empty($_POST['DOB'])) {
        $valid = false;
        $doberr = "Date of birth cannot be empty!";
    } else {
        $DOB = $_POST['DOB'];
    }
    if (empty($_POST['address'])) {
        $valid = false;
        $addresserr = "Address cannot be empty!";
    } else {
    }



    if ($valid == true) {
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('insert into account (firstname, lastname, email, password, dateofbirth, address, password_expiration_date) values (:firstname, :lastname, :email, :password, :DOB, :address, :password_expiration_date)');
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email );
        $stmt->bindValue(':password', $hashedpassword);
        $stmt->bindValue(':DOB', $DOB);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue("password_expiration_date", $time);
        $stmt->execute();


        $stmt = $pdo->prepare('SELECT id from account WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $getInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['userid'] = $getInfo['id'];
        $_SESION['loggedin'] = true;

        header('location:selectQuestion?id='.$getInfo['id']);
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
<div class="registrationContainer">

    <div class="registration-box">
        <br />
        <img src="/images/avatar3.png" class="avatar">
        <br />
        <h1> Register </h1>
        <p> Please fill the following to create a new account.</p>
        <form method="post">
            <br/>
            <span class="error"><?php echo $emailerr; ?></span>
            <input type="text" name="email" placeholder="Email" value="<?php echo $email ?>" required/>

            <br/>
            <span class="error"><?php echo $passworderr; ?> </span>
            <input type="password" name="password" placeholder="Password (Requires: Digit, Special Character, Uppercase, lowercase letter)" min="8" max="60" required/>

            <br/>
            <span class="error"><?php echo $fnerr; ?>
            <input type="text" name="firstname" placeholder="First name"/ value="<?php echo $firstname ?>" required>

            <br/>
            <span class="error"><?php echo $lnerr; ?>
            <input type="text" name="lastname" placeholder="Last name" value="<?php echo $lastname ?>" required/>

            <br/>
                <span class="error"><?php echo $doberr; ?>
            <input type="text" id="DOB" name="DOB" placeholder="Date of Birth" value="<?php echo $DOB ?>" required"/>

            <br/>
                    <span class="error"><?php echo $addresserr; ?>
            <input type="text" name="address" placeholder="Enter Address"/value="<?php echo $address ?>">

            <br/>
            <br/>
            <input type="submit" value="Register" name="register" required/>
        </form>
    </div>
</div>
</body>
</html>