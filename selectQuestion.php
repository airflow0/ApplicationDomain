<?php
require('database.php');
$id = $_GET['id'];

if(isset($_POST['qsubmit']))
{
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $stmt=$pdo->prepare("insert into securityQuestions (id, question, answer) values (:id, :question, :answer)");
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":question", $question);
    $stmt->bindValue(":answer", $answer);
    $stmt->execute();

    header("Location: login");
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
        <p> Please fill the following to create a new account.</p>
        <form method="post">
            <br/>
            <select name="question">
                <option value="What was your childhood nickname?">What was your childhood nickname? </option>
                <option value="In what city did you meet your spouse/significant other?">In what city did you meet your spouse/significant other? </option>
                <option value="What is the name of your favorite childhood friend?">What is the name of your favorite childhood friend?</option>
                <option value="What street did you live on in third grade?">What street did you live on in third grade?</option>
                <option value="What is the middle name of your youngest child?">What is the middle name of your youngest child?</option>
                <option value="What is your oldest sibling's middle name?">What is your oldest sibling's middle name?</option>
                <option value="What school did you attend for sixth grade?">What school did you attend for sixth grade?</option>
            </select>
            <br/>
            <input type="text" name="answer" placeholder="Answer" required/>
            <br/>
            <br/>
            <input type="submit" value="Submit" name="qsubmit" min="6" max="30" required/>
        </form>
    </div>
</div>
</body>
</html>
