<?php
session_start();
require('database.php');
if(!$_SESSION['loggedin'])
{
    header("Location: login");
}

$f_display = $l_display = $d_display = $a_display =  $picture = "";
$clientID = $_SESSION['userid'];
$admin = $_SESSION['isAdmin'];

$stmt = $pdo->prepare('SELECT firstname, lastname, dateofbirth, address, picture_directory FROM account WHERE id=:id');
$stmt->bindValue(":id", $clientID);
$stmt->execute();
$userinfo = $stmt->fetch(PDO::FETCH_ASSOC);

$f_display = $userinfo['firstname'];
$l_display = $userinfo['lastname'];
$d_display = $userinfo['dateofbirth'];
$a_display = $userinfo['address'];
$picture = $userinfo['picture_directory'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</head>
<body>

<nav class="navbar navbar-expand-sm shadow p-3 mb-5" style="background-color:#333F50; color:white">
    <a class="navbar-brand" href="<?php
    if($admin == "1")
    {
        echo "admin_cp";
    }
    else
    {
        echo "dashboard";
    }

    ?>"><img src="images/logo-revised.png" width="180" height="40" class="d-inline-block align-top"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse w-100" id="collapsingNavbar3" >
        <ul class="navbar-nav w-100 justify-content-center">

            <li class="nav-item" style="margin-left: 30px; margin-right: 30px;">
                <a class="nav-link nav-hover-link" href="charts">Chart of Accounts</a>
            <li class="nav-item" style="margin-left: 30px; margin-right: 30px;">
                <a class="nav-link nav-hover-link" href="list_journals">List of Journal Entries</a>
            </li>
            <li class="nav-item" style="margin-left: 30px; margin-right: 30px;">
                <a class="nav-link nav-hover-link" href="#finan_modal" data-toggle="modal">Financial Reports</a>
            </li>


            <?php

            if($admin == "1")
            {
                echo "<li class=\"nav-item\" style=\"margin-left: 30px; margin-right: 30px;\">
                <a class=\"nav-link nav-hover-link\" href=\"admin_user_table\">User Management</a>
            </li>";
            }
            else
            {

            }
            ?>

        </ul>
        <ul class="nav navbar-nav justify-content-end">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbaruser" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $picture ?>" class="rounded-circle z-depth2" width="50" height="50" style="margin-right: 5px" >
                    <?php echo $f_display ?>  <?php print' '.$l_display ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="logout">Sign out</a>
                </div>
            </li>

        </ul>
    </div>
</nav>

<!-- modal for financial reports -->
<div class="modal fade bg-dark" id="finan_modal" tabindex="-1" role="dialog" aria-labelledby="finan_modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectReportModalLabel">Select financial report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                <div class="modal-body">
                    <!-- table to select financial report -->
                    <table id="finan-report-table" class="table hover table-bordered table-striped table-dark">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td><a class="finan_item" href="/balancesheet">Balance Sheet</a></td>
                            </tr>
                            <tr>
                                <td><a class="finan_item" href="/incomestatement">Income Statement</a></td>
                            </tr>
                            <tr>
                                <td><a class="finan_item" href="/retainedearnings">Retained Earnings Statement</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>

        </div>
    </div>
</div>

</body>
</html>