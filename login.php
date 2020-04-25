<!DOCTYPE html>
<?php
require 'database.php';
$errormsg = "Welcome!";
session_start();
if ($_SESSION['loggedin'] == true) {
    header('Location: dashboard');
}
if (isset($_POST['login'])) {
    $emailerr = $passworderr = "";
    $email = trim($_POST['email']);
    $loginpassword2 = trim($_POST['loginpassword2']);
    $ip = $_SERVER['REMOTE_ADDR'];
    $t = time();
    $diff = (time() - 600);


    $stmt = $pdo->prepare("SELECT id, email, password, isActive, isManager, isAdmin, loginattempt, password_expiration_date FROM account WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $verified = $stmt->fetch(PDO::FETCH_ASSOC);
    $emailConfirm = $verified['email'];
    $passwordConfirm = $verified['password'];
    $isActivated = $verified['isActive'];
    $isManager = $verified['isManager'];
    $isAdmin = $verified['isAdmin'];
    $loginAttempt = $verified['loginattempt'];
    $password_expiration_date = $verified['password_expiration_date'];

    $date1 = time();
    $date2 = strtotime(date($password_expiration_date));
    $date3 = $date2 - $date1;
    $date4 = round($date3 / (3600 * 24));
    $attempts = 3;
    $lgNonIDCount = checkNonIDAttempts($pdo, $ip, $diff);
    if ($lgNonIDCount >= $attempts) {
        $errormsg = "You have exceeded the number of logins!";
    } else {
        if ($verified === false) {
            updateNonIDAttempt($pdo, $ip, $t);
            $lgNonIDCount = checkNonIDAttempts($pdo, $ip, $diff);
            $errormsg = "Invalid email. You have out " . $lgNonIDCount . " of " . $attempts . " attempts left to login!";
        } else {
            if ($date4 <= 0) {
                $errormsg = "Password has expired!";
            } else {
                if ($loginAttempt <= $attempts) {
                    if ($isActivated === 1) {
                        $hashedPassword = password_verify($loginpassword2, $passwordConfirm);
                        if ($hashedPassword == true) {
                            $_SESSION['userid'] = $verified['id'];
                            $_SESSION['loggedin'] = true;
                            if ($isAdmin === 1 || $isManager === 1) {
                                $_SESSION['isAdmin'] = true;
                                $_SESSION['isManager'] = true;
                                if ($date4 <= 3) {
                                    updateLoginAttempt($pdo, 0, $emailConfirm);
                                    $errormsg = "You have less than 3 days before your password expires! Please contact an admin!";
                                    echo "<script type='text/javascript'>alert('$errormsg');</script>";
                                    echo "<script>setTimeout(\"location.href = '/admin_cp';\",1500);</script>";
                                    exit;
                                } else {
                                    updateLoginAttempt($pdo, 0, $emailConfirm);
                                    header('Location: admin_cp');
                                    exit;
                                }


                            } else {
                                if ($date4 <= 3) {
                                    updateLoginAttempt($pdo, 0, $emailConfirm);
                                    $errormsg = "You have less than 3 days before your password expires! Please contact an admin!";
                                    echo "<script type='text/javascript'>alert('$errormsg');</script>";
                                    header("Refresh: 0.1; url=dashboard");
                                    exit;
                                } else {
                                    updateLoginAttempt($pdo, 0, $emailConfirm);
                                    header('Location: dashboard');
                                    exit;
                                }
                            }
                        } else {

                            $loginAttempt += 1;
                            updateLoginAttempt($pdo, $loginAttempt, $emailConfirm);
                            updateNonIDAttempt($pdo, $ip, $t);
                            $lgNonIDCount = checkNonIDAttempts($pdo, $ip, $diff);
                            $errormsg = "Invalid password. You have " . $lgNonIDCount . " out of " . $attempts . " attempts left to login!";
                        }
                    } else {
                        $errormsg = 'Account is not activated. Please contact an administrator for access!';
                    }
                } else {
                    $errormsg = "Your account is locked! Please contact an administrator!";
                }
            }
        }
    }
}
function updateNonIDAttempt(PDO $pdo, $ip, $t)
{
    $stmt = $pdo->prepare("INSERT into login_limit VALUES (null, :ip, :time)");
    $stmt->bindValue(":ip", $ip);
    $stmt->bindValue(":time", $t);
    $stmt->execute();
}

function checkNonIDAttempts(PDO $pdo, $ip, $diff)
{
    $stmt = $pdo->prepare("SELECT count(*) from login_limit WHERE ipAddress= :ip AND timeDiff > :timeDiff");
    $stmt->bindValue(":ip", $ip);
    $stmt->bindValue(":timeDiff", $diff);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count;
}

function updateLoginAttempt(PDO $pdo, $data, $email)
{

    $stmt = $pdo->prepare("UPDATE account SET loginattempt=:loginattempt WHERE email=:email");
    $stmt->bindValue(":loginattempt", $data);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
}

?>

<head>
    <title> Website name </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>


        <img class="mx-auto d-block" src="images/logo-revised.png" style="width: 15%; padding: 20px">


<div class="loginContainer">
    <div class="login-box">
        <img src="/images/avatar3.png" class="avatar">
        <h1><span class="error"><?php echo $errormsg ?></span></h1>
        <form method="post">
            <p>Email</p>
            <input type="text" name="email" placeholder="Enter Email" required>
            <span class="error"> <?php $emailerr ?></span>
            <p>Password</p>
            <input type="password" name="loginpassword2" placeholder="Enter Password" required min="6">
            <span class="error"> <?php $passworderr ?></span>
            <input type="submit" name="login" value="Login">
            <input type="checkbox" value="RememberMe" id="RememberMe"> <label for="RememberMe">Remember Me</label>
        </form>
        <a href="registration">Create an Account</a> | <a href="forgotpassword">Forget Password</a>

    </div>
</div>
</body>
</html>