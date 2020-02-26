
<?php

require('admin_navigation.php');
require 'database.php';
require('authorizationCheck.php');
$id = $_GET['id'];
$firstname = $lastname = $DOB = $email = $address = "";
$displaymessage = "";
$stmt = $pdo->prepare("SELECT firstname, lastname, dateofbirth, email, address, picture_directory FROM account WHERE id=:id");
$stmt->bindValue(":id", $id);
$stmt->execute();
$info = $stmt->fetch(PDO::FETCH_ASSOC);

$firstname = $info['firstname'];
$lastname = $info['lastname'];
$DOB = $info['dateofbirth'];
$email = $info['email'];
$address = $info['address'];
$picture_directory = $info['picture_directory'];

if(isset($_POST['saveuser']))
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $DOB = $_POST['DOB'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $pdo->prepare("UPDATE account SET firstname=:fn, lastname=:ln, dateofbirth=:DOB, email=:email, address=:address WHERE id=:id");
    $stmt->bindValue(":fn", $firstname);
    $stmt->bindValue(":ln", $lastname);
    $stmt->bindValue(":DOB", $DOB);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":address", $address);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    $displaymessage = "User saved!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="registrationContainer">
    <div class="registration-box">
        <img src="<?php echo $picture_directory ?>" class="avatar">
        <br />
        <h1> Update User </h1>
        <p><?php echo $displaymessage ?></p>
        <form method="post">
            <input type="text" name="email" placeholder="Email" value="<?php echo $email ?>" onkeyup="enable(this)" required/>
            <br/>
            <input type="text" name="firstname" placeholder="First name" value="<?php echo $firstname ?>">
            <br/>

            <input type="text" name="lastname" placeholder="Last name" value="<?php echo $lastname ?>"/>
            <br/>
            <input type="text" id="DOB" name="DOB" placeholder="Date of Birth" value="<?php echo $DOB ?>"/>
            <br/>


                <input type="text" name="address" placeholder="Enter Address" value="<?php echo $address ?>"/>
            <br/>

            <br/>
            <input id="saveUser" type="submit" value="Save" name="saveuser" min="6" max="30"/>
        </form>
    </div>
</div>
<script>
    function enable(text)
    {
        var submit = document.getElementById(saveUser);

    }
</script>
</body>
</html>
