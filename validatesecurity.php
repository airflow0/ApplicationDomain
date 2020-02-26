<?php
require('database.php');
$id = $_GET['id'];
$error ="";
if($id == "")
{
    header("Location: login.php");
    exit();
}
$stmt = $pdo->prepare("SELECT question, answer FROM securityQuestions WHERE id=:id");
$stmt->bindValue(":id", $id);
$stmt->execute();
$info = $stmt->fetch(PDO::FETCH_ASSOC);

$question = $info['question'];
$answer = trim($info['answer']);

if(isset($_POST['validate']))
{
    $panswer = trim($_POST['answer']);
    if($answer == $panswer)
    {
        $stmt = $pdo->prepare("UPDATE account SET reset=:reset WHERE id=:id");
        $stmt->bindValue(":reset", 1);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        session_start();
        $_SESSION['resetvalidity'] = true;
        header("Location: resetpassword?id=".$id);
    }
    else
    {
        $error = "Wrong answer please try again!";
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
        <h1> Security Question </h1>
        <p> Please fill the following to validate your account!</p>
        <form method="post">
            <br/>
            <?php echo $question ?>
            <br/>
            <span name="error"><?php echo $error ?></span>
            <br/>
            <input type="text" name="answer" placeholder="Answer" required/>
            <br/>
            <br/>
            <input type="submit" value="Submit" name="validate" min="6" max="30" required/>
        </form>
    </div>
</div>
</body>
</html>
