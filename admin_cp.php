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

$event = $pdo->prepare('SELECT details from eventlog');
$event->execute();
$event->setFetchMode(PDO::FETCH_ASSOC);


$accIDS = $pdo->prepare("SELECT accID FROM assets");
$accIDS->execute();
$accIDS->setFetchMode(PDO::FETCH_ASSOC);

$count = 0;
$balance_array = [];
while($accounts = $accIDS->fetch())
{
    $balance = 0;
    $balance_troll = $pdo->prepare("SELECT * FROM journal_data WHERE accID=:accID");
    $balance_troll->bindValue(":accID", $accounts['accID']);
    $balance_troll->execute();
    $balance_troll->setFetchMode(PDO::FETCH_ASSOC);
    while($transaction = $balance_troll->fetch())
    {
        $debit_money = preg_replace('/[^\d,\.]/', '', $transaction['debit']);
        $debit_money = str_replace(',', '', $debit_money);
        if($debit_money != null)
        {
            $balance = $balance + $debit_money;
        }
        $credit_money = preg_replace('/[^\d,\.]/', '', $transaction['credit']);
        $credit_money = str_replace(',', '', $credit_money);
        if($credit_money != null)
        {
            $balance = $balance - $credit_money;
        }
    }
    array_push($balance_array, $balance);
}


$liability_accIDS = $pdo->prepare("SELECT accID FROM liability");
$liability_accIDS->execute();
$liability_accIDS->setFetchMode(PDO::FETCH_ASSOC);

$count = 0;
$lia_balance_array = [];
while($li_accounts = $liability_accIDS->fetch())
{
    $li_balance = 0;
    $li_balance_troll = $pdo->prepare("SELECT * FROM journal_data WHERE accID=:accID");
    $li_balance_troll->bindValue(":accID", $li_accounts['accID']);
    $li_balance_troll->execute();
    $li_balance_troll->setFetchMode(PDO::FETCH_ASSOC);
    while($li_transaction = $li_balance_troll->fetch())
    {
        $li_debit_money = preg_replace('/[^\d,\.]/', '', $li_transaction['debit']);
        $li_debit_money = str_replace(',', '', $li_debit_money);
        if($li_debit_money != null)
        {
            $li_balance = $li_balance + $li_debit_money;
        }
        $li_credit_money = preg_replace('/[^\d,\.]/', '', $li_transaction['credit']);
        $li_credit_money = str_replace(',', '', $li_credit_money);
        if($li_credit_money != null)
        {
            $li_balance = $li_balance - $li_credit_money;
        }

    }
    array_push($lia_balance_array, $li_balance);
}

$equity_accIDS = $pdo->prepare("SELECT accID FROM equity");
$equity_accIDS->execute();
$equity_accIDS->setFetchMode(PDO::FETCH_ASSOC);

$count = 0;
$eq_balance_array = [];
while($accounts = $equity_accIDS->fetch())
{
    $balance = 0;
    $balance_troll = $pdo->prepare("SELECT * FROM journal_data WHERE accID=:accID");
    $balance_troll->bindValue(":accID", $accounts['accID']);
    $balance_troll->execute();
    $balance_troll->setFetchMode(PDO::FETCH_ASSOC);
    while($transaction = $balance_troll->fetch())
    {
        $debit_money = preg_replace('/[^\d,\.]/', '', $transaction['debit']);
        $debit_money = str_replace(',', '', $debit_money);
        if($debit_money != null)
        {
            $balance = $balance - $debit_money;
        }
        $credit_money = preg_replace('/[^\d,\.]/', '', $transaction['credit']);
        $credit_money = str_replace(',', '', $credit_money);
        if($credit_money != null)
        {
            $balance = $balance + $credit_money;
        }

    }
    array_push($eq_balance_array, $balance);
}

$asset_sum = array_sum($balance_array);
$lia_sum = array_sum($lia_balance_array);
$eq_sum = array_sum($eq_balance_array);
if($lia_sum == 0)
{
    $currentRatio = 0;
}
else
{
    $currentRatio = $asset_sum/$lia_sum;
}
if($eq_sum == 0)
{
    $assetToRation = 0;
}
else
{
    $assetToRation = $asset_sum/$lia_sum;
}
if($asset_sum == 0)
{
    $debtToAssets = 0;
}
else
{
    $debtToAssets = $asset_sum/$lia_sum;
}

$C_format = number_format((float) $currentRatio, 2, '.', '');
$atR_format = number_format((float) $assetToRation, 2, '.', '');
$dtoA = number_format((float) $debtToAssets, 2, '.', '');


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<script type="text/javascript">
    $(document).ready(function () {
        var cRatio = "<?php echo $C_format; ?>";
        var  ATOE = "<?php echo $atR_format; ?>";
        var DTOA = "<?php echo $dtoA; ?>";


        if( cRatio >= 1.2)
        {
            $("#currentRatio").css("background-color","rgba(49, 199, 49, 0.568)");
        }
        else if ( cRatio < 1.2 && cRatio >= 0.8 )
        {
            $("#currentRatio").css("background-color","rgba(253, 233, 47, 0.623)");
        }
        else
        {
            $("#currentRatio").css("background-color","red");
        }

        if( ATOE >= 1.5)
        {
            $("#atoe").css("background-color","red");
        }
        else if ( ATOE < 1.5 && ATOE > 1)
        {
            $("#atoe").css("background-color","rgba(253, 233, 47, 0.623)");
        }
        else
        {
            $("#atoe").css("background-color","rgba(49, 199, 49, 0.568)");
        }

        if( DTOA >= 1.2)
        {
            $("#dtoa").css("background-color","red");
        }
        else if ( DTOA < 1.2 && DTOA > 1)
        {
            $("#dtoa").css("background-color","rgba(253, 233, 47, 0.623)");
        }
        else
        {
            $("#dtoa").css("background-color","rgba(49, 199, 49, 0.568)");
        }


    });
</script>
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
                    <?php
                        $i = 0;
                        while($eventdetails = $event->fetch())
                        {
                            if($i >= 10)
                            {
                                break;
                            }
                        ?>
                        <div class="alert alert-secondary" role="alert">
                            <?php echo $eventdetails['details']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <?php
                            $i++;
                        }
                    ?>

                </div>
            </div>
        </div>

        <!--financial ratios-->
        <div class="col-sm-9">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Financial Ratios</h5>
                    <div class="d-flex justify-content-around">
                        <div class="p-2 rounded" id='currentRatio' style="background-color: rgba(49, 199, 49, 0.568); margin: 10px; width: 30%">
                            <div style="padding:20px">
                                <h3 style="text-align: center"><b>Current Ratio</b></h3>
                                <h1 style="text-align: center; font-size:100px"><b><?php echo $C_format; ?></b></h1>
                                <p style="text-align: center; font-size: 20px">Current Ratio = Assets / Liabilities</p>
                            </div>
                        </div>
                        <div class="p-2 rounded" id='atoe'style="background-color: rgba(49, 199, 49, 0.568); margin: 10px; width: 30%">
                            <div style="padding:20px">
                                <h3 style="text-align: center"><b>Asset-to-Equity</b></h3>
                                <h1 style="text-align: center; font-size:100px"><b><?php echo $atR_format; ?></b></h1>
                                <p style="text-align: center; font-size: 20px">Asset-to-Equity = Assets / Equity</p>
                            </div>
                        </div>
                        <div class="p-2 rounded" id="dtoa" style="background-color: rgba(253, 233, 47, 0.623); margin: 10px; width: 30%">
                            <div style="padding:20px">
                                <h3 style="text-align: center"><b>Debt-to-Assets</b></h3>
                                <h1 style="text-align: center; font-size:100px"><b><?php echo $dtoA; ?></b></h1>
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