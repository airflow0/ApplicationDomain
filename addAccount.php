<?php
require('database.php');
$title_message = "Add a new Account";
$clientID = $_SESSION['userid'];
$accountName = $description = $category = $accountError = "";
if ($_SESSION['isAdmin'] = true) {
    require('admin_navigation.php');
} else {
    require('navigation.php');
}
if(isset($_POST['insert']))
{
    $valid = true;
    $accountName = trim($_POST['account_name']);
    $description = trim($_POST['account_description']);
    $category = trim($_POST['category']);


    $stmt = $pdo->prepare('SELECT accName from accountnames WHERE accName=:accName');
    $stmt->bindValue(':accName', $accountName);
    $stmt->execute();
    if($stmt->rowCount() > 0)
    {
        $accountError = "There is already an account that has this name. Please try again!";
        $valid = false;
    }
    if($valid)
    {
        if($category === "Assets")
        {

            $stmt = $pdo->prepare("INSERT into assets (accName, description, date, createdby) values (:accName, :description, NOW(), :userid)");
            $stmt->bindValue(":accName", $accountName);
            $stmt->bindValue(":description", $description);
            $stmt->bindValue(":userid", $clientID);
            $stmt->execute();
            updateAccountNames($pdo, $accountName);
            $title_message = "Account has been added!";

        }
        else if($category === "Liabilities")
        {
            $stmt = $pdo->prepare("INSERT into liability (accName, description, date, createdBy) values (:accName, :description, NOW(), :userid)");
            $stmt->bindValue(":accName", $accountName);
            $stmt->bindValue(":description", $description);
            $stmt->bindValue(":userid", $clientID);
            $stmt->execute();
            updateAccountNames($pdo, $accountName);
            $title_message = "Account has been added!";
        }
        else if($category === "Equity")
        {
            $stmt = $pdo->prepare("INSERT into equity (accName, description, date, createdBy) values (:accName, :description, NOW(), :userid)");
            $stmt->bindValue(":accName", $accountName);
            $stmt->bindValue(":description", $description);
            $stmt->bindValue(":userid", $clientID);
            $stmt->execute();
            updateAccountNames($pdo, $accountName);
            $title_message = "Account has been added!";
        }
        else if($category === "Revenue")
        {
            $stmt = $pdo->prepare("INSERT into revenue (accName, description, date, createdBy) values (:accName, :description, NOW(), :userid)");
            $stmt->bindValue(":accName", $accountName);
            $stmt->bindValue(":description", $description);
            $stmt->bindValue(":userid", $clientID);
            $stmt->execute();
            updateAccountNames($pdo, $accountName);
            $title_message = "Account has been added!";
        }
        else if($category === "Expenses")
        {
            $stmt = $pdo->prepare("INSERT into expenses (accName, description, date, createdBy) values (:accName, :description, NOW(), :userid)");
            $stmt->bindValue(":accName", $accountName);
            $stmt->bindValue(":description", $description);
            $stmt->bindValue(":userid", $clientID);
            $stmt->execute();
            updateAccountNames($pdo, $accountName);
            $title_message = "Account has been added!";
        }
        else
        {

        }
    }
}
function updateAccountNames(PDO $pdo, $accname)
{
    $stmt = $pdo->prepare("INSERT into accountnames VALUES (:accname)");
    $stmt->bindValue(":accname", $accname);
    $stmt->execute();
}
?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<h3 style="text-align: center; margin-top: 50px; color: white; font-family: sans-serif; font-weight: bold"> <?php echo $title_message ?></h3>
<div class="container justify-content-center" style="margin-top: 50px;">
    <form method="post">
        <span class="error" style="color:white"><?php echo $accountError; ?></span>
        <br />
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Account Name</span>
            </div>

            <input type="text" class="form-control" name="account_name" id="account_name" value="<?php echo $accountName ?>" required>
        </div>

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Category</label>
            </div>
            <select class="custom-select" id="category" name="category" value="<?php echo $category ?> required>
                <option value="" selected></option>
                <option value="Assets">Assets</option>
                <option value="Liabilities">Liabilities</option>
                <option value="Equity">Equity</option>
                <option value="Revenue">Revenue</option>
                <option value="Expenses">Expenses</option>
            </select>
        </div>

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Description</span>
            </div>
            <textarea class="form-control" value="<?php echo $description ?>" name="account_description"  id="account_description" aria-label="With textarea" required></textarea>
        </div>

        <a href="charts" class="btn btn-secondary " role="button" aria-pressed="true">Back</a>
        <input type="submit" name="insert" value="Insert" class="btn btn-success"/>
    </form>
</div>


</body>
</html>