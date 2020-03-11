<?php

require('database.php');
if ($_SESSION['isAdmin'] = true) {
    require('admin_navigation.php');
} else {
    require('navigation.php');
}

$accIDS = $pdo->prepare("SELECT accID FROM assets");
$accIDS->execute();
$accIDS->setFetchMode(PDO::FETCH_ASSOC);

$count = 0;
$balance_array = [];
$balance_total = 0;
$balance_total_array = [];
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
            $balance_total = $balance + $debit_money;
        }
        $credit_money = preg_replace('/[^\d,\.]/', '', $transaction['credit']);
        $credit_money = str_replace(',', '', $credit_money);
        if($credit_money != null)
        {
            $balance = $balance - $credit_money;
            $balance_total = $balance - $credit_money;
        }
        array_push($balance_total_array, $balance_total);
    }
    array_push($balance_array, $balance);
}
print_r($balance_array);
print_r($balance_total)




?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>CountOnUs - Balance Sheet</title>
</head>

<body>
<div class="bd-highlight body-format" style="padding: 20px; color: #FFFFFF">
    <div style="padding-bottom: 10px">
        <h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Balance Sheet<span style="float: right">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="as-of">As of</span>
  					</div>
  					<input type="date" class="form-control" placeholder="MM/DD/YYYY" aria-label="As of" aria-describedby="as-of">
				</div>
			</span></h1>
    </div>

    <div class="border border-secondary rounded bg-white">
        <div style="padding: 10px">
            <table id="bal-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th style="width:10%" scope="row">ASSETS:</th>
                    <td style="width:65%"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Asset #1</td>
                    <td>100.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Asset #2</td>
                    <td>200.00</td>
                </tr>
                <tr>
                    <td></td>
                    <th scope="row">Total Assets</th>
                    <td>300.00</td>
                </tr>

                </tbody>
            </table>

            <table id="liab-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th style="width: 10%" scope="row">LIABILITIES:</th>
                    <td style="width:65%"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Liability #1</td>
                    <td>10.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Liability #2</td>
                    <td>20.00</td>
                </tr>
                <tr>
                    <td></td>
                    <th scope="row">Total Liabilities</th>
                    <td>30.00</td>
                </tr>

                </tbody>
            </table>

            <table id="equity-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th style="width: 10%" scope="row">EQUITIES:</th>
                    <td style="width:65%"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Equity #1</td>
                    <td>200.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Equity #2</td>
                    <td>70.00</td>
                </tr>
                <tr>
                    <td></td>
                    <th scope="row">Total Equities</th>
                    <td>270.00</td>
                </tr>

                </tbody>
            </table>

            <table id="liab-equity-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th  style="width: 75%" scope="row">LIABILITIES + EQUITY:</th>
                    <td>300.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>

</html>
