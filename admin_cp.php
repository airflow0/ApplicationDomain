<?php
require('database.php');
require('admin_navigation.php');
$f_display = $l_display = $d_display = $a_display =  $picture = "";
$clientID = $_SESSION['userid'];

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
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="body-format" style="padding: 20px; color: #FFFFFF;">
    <div class="d-flex justify-content-between" style="margin-bottom: -15px">
        <div class="p-2">
            <h1 style="text-align: left; font-size: 26px">Dashboard</h1>
        </div>

        <div class="p-2">
            <h1 style="text-align: left; font-size: 26px">Company AAA</h1>
        </div>
    </div>
    <div class="row" style="padding:10px; color: black">
        <div class="col-sm-3">
            <!--quick links-->
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Quick Links</h5>
                    <div class="row" style="padding: 10px">
                        <a href="journal_entry" class="btn btn-primary" style="width:400px">Add journal entry</a>
                    </div>
                    <div class="row" style="padding:10px">
                        <a href="charts" class="btn btn-primary" style="width:400px">View accounts</a>
                    </div>
                </div>
            </div>
            <!--important messages-->
            <div class="card bg-dark text-white" style="margin-top: 30px">
                <div class="card-body">
                    <h5 class="card-title">Important Messages</h5>
                    <div class="alert alert-secondary" role="alert">
                        <a href="#" class="alert-link">Pending journal entry</a> created by user Tanner Johnson.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        <a href="#" class="alert-link">Pending journal entry</a> created by user James Lee.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        <a href="#" class="alert-link">Brianna Howard</a> has now been added as a user.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!--financial ratios-->
        <div class="col-sm-9">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Financial Ratios</h5>
                    <div class="d-flex justify-content-around">
                        <div class="p-2 rounded" style="background-color: rgba(49, 199, 49, 0.568); margin: 10px; width: 30%">
                            <div style="padding:20px">
                                <h3 style="text-align: center"><b>Current Ratio</b></h3>
                                <h1 style="text-align: center; font-size:100px"><b>1.54</b></h1>
                                <p style="text-align: center; font-size: 20px">Current Ratio = Assets / Liabilities</p>
                            </div>
                        </div>
                        <div class="p-2 rounded" style="background-color: rgba(49, 199, 49, 0.568); margin: 10px; width: 30%">
                            <div style="padding:20px">
                                <h3 style="text-align: center"><b>Asset-to-Equity</b></h3>
                                <h1 style="text-align: center; font-size:100px"><b>1.25</b></h1>
                                <p style="text-align: center; font-size: 20px">Asset-to-Equity = Assets / Equity</p>
                            </div>
                        </div>
                        <div class="p-2 rounded" style="background-color: rgba(253, 233, 47, 0.623); margin: 10px; width: 30%">
                            <div style="padding:20px">
                                <h3 style="text-align: center"><b>Debt-to-Assets</b></h3>
                                <h1 style="text-align: center; font-size:100px"><b>0.65</b></h1>
                                <p style="text-align: center; font-size: 20px">Debt-to-Assets = Liabilities / Assets</p>
                            </div>
                        </div>
                    </div>
                </div>
                    <a class="btn btn-secondary float-right" href="#finan_modal" data-toggle="modal" style="margin-left:80%; margin-right:40px; margin-bottom: 20px">View financial reports</a>
            </div>
        </div>
    </div>
</div>

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
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!--
<script>
    $(function () {
        $("#upload_link").on('click', function (e) {
            e.preventDefault();
            $("#upload:hidden").trigger('click');
        });
    });
</script>
<div class="d-inline-flex p-2 ">
        <div class="profilecontainer">
            <div class="profilepic">
                <img src="<?php echo $picture ?>"/>
                <p>a</p>
                <div class="layer">
                </div>
                <form action="upload" method="post" enctype="multipart/form-data">
                    <input id="upload" type="file" name="fileToUpload" onchange="this.form.submit()"/>
                    <a href="" id="upload_link">
                        <div class="wrapimage">
                            <label class="edit glyphicon glyphicon-pencil" for="changePicture" type="file" title="Change picture" style="color:white;">Edit</label>
                        </div>
                    </a>
                </form>
            </div>
            <div class="profile_info">
                <div class="profile_info_name"> @<?php echo $f_display ?>  <?php print' '.$l_display ?></div>
            </div>
        </div>
</div> -->
</body>
</html>