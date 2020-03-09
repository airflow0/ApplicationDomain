<?php
session_start();
require('database.php');
if(!$_SESSION['loggedin'])
{
    header("Location: login");
}

$f_display = $l_display = $d_display = $a_display =  $picture = "";
$clientID = $_SESSION['userid'];

$stmt = $pdo->prepare('SELECT firstname, lastname, dateofbirth, address,email, picture_directory FROM account WHERE id=:id');
$stmt->bindValue(":id", $clientID);
$stmt->execute();
$userinfo = $stmt->fetch(PDO::FETCH_ASSOC);

$f_display = $userinfo['firstname'];
$l_display = $userinfo['lastname'];
$d_display = $userinfo['dateofbirth'];
$a_display = $userinfo['address'];
$picture = $userinfo['picture_directory'];
$email = $userinfo['email'];


?>

<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div class="navibar row d-inline-flex" style="margin: 0px;width: 100%;max-width: 100%;max-height: 100%;height: 10%;min-height: 10%;min-width: 100%;">
    <div class="col d-inline-flex justify-content-center align-items-center align-content-center" style="padding: 0px;min-height: 100%;width: 100%;height: 100%;min-width: 10%;max-height: 100%;">
        <a href="/dashboard">
            <img src="images/logo-revised.png" style="margin-left: -30%;max-width: 96%;width: 96px;height: 100px;max-height: 100%;"/>
        </a>

    </div>
    <div class="col text-center d-inline-flex justify-content-center align-items-center" style="padding: 0px;min-width: 70%;">
        <ul class="list-unstyled d-flex flex-fill justify-content-center" style="margin-top: 0px;margin-bottom: 0px;">
            <li class="d-inline-flex flex-fill justify-content-center align-items-center">
            <a class="d-inline-flex flex-fill justify-content-center" href="">Charts</a>
            <a class="d-inline-flex flex-fill justify-content-center" href="#">Temporary Content Link #2</a>
            <a class="d-inline-flex flex-fill justify-content-center" href="#">Temporary Content Link #3</a>
            <a class="d-inline-flex flex-fill justify-content-center" href="#">Temporary Content Link #4</a>
            <a class="d-inline-flex flex-fill justify-content-center" href="#">Temporary Content Link #5</a>
            </li>
        </ul>
    </div>
    <div class="col d-inline-flex justify-content-center align-items-center" style="padding: 0px;">
        <div class="col d-inline-flex justify-content-center" style="padding: 0px;min-width: 10%;">
            <div class="navibardrop dropdown">
                <li class="dropdown d-inline-flex justify-content-center align-items-center">
                    <img src="<?php echo $picture ?>"/>
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $f_display ?>  <?php print' '.$l_display ?></a>
                    <ul class="dropdown-menu dropdown-menu-center" role="menu">
                        <li>
                            <a id="dropdownlink">Email: <?php echo $email ?> </a>
                            <a id="dropdownlink" href="logout?id=<?php echo $clientID ?>">Sign out</a>
                        </li>

                    </ul>
                </li>
            </div>
        </div>
    </div>
</div>
</body>
</html>