<?php

require('database.php');
if ($_SESSION['isAdmin'] = true) {
    require('admin_navigation.php');
} else {
    require('navigation.php');
}

$time = date("m/yy", time());


$rev = $pdo->prepare('SELECT accID, accName FROM revenue');
$rev->execute();
$rev_array = [];
while ($revenue = $rev->fetch(PDO::FETCH_ASSOC)) {
    $rev_balance = 0;
    $stmt = $pdo->prepare('SELECT * FROM journal_data where accID=:accID');
    $stmt->bindValue('accID', $revenue['accID']);
    $stmt->execute();
    while ($rev_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rev_debit = preg_replace('/[^\d,\.]/', '', $rev_data['debit']);
        $rev_debit = str_replace(',', '', $rev_debit);
        if ($rev_debit != null) {
            $rev_balance = $rev_balance - $rev_debit;
        }
        $rev_credit = preg_replace('/[^\d,\.]/', '', $rev_data['credit']);
        $rev_credit = str_replace(',', '', $rev_credit);
        if ($rev_credit != null) {
            $rev_balance = $rev_balance + $rev_credit;
        }

    }
    array_push($rev_array, $rev_balance);
}
$rev_sum = array_sum($rev_array);





?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>CountOnUs - Retained Earnings Statement</title>
</head>

<body>
<div class="bd-highlight body-format" style="padding: 20px; color: #FFFFFF">
    <div style="padding-bottom: 10px">
        <h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Retained Earnings Statement<span style="float: right">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="month-year">Month/Year</span>
  					</div>
  					<input type="text" class="form-control" placeholder="MM/YYYY" aria-label="Month/year" aria-describedby="month-year" value="<?php echo $time; ?>">
				</div>
			</span></h1>
    </div>

    <div class="border border-secondary rounded bg-white">
        <div style="padding: 10px">
            <table id="re-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th style="width: 65%" scope="row">INITIAL RETAINED EARNINGS</th>
                    <td>$0.00</td>
                </tr>
                <tr>
                    <th style="width: 65%" scope="row">ADD: NET INCOME</th>
                    <td><?php
                        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                        echo $fmt->formatCurrency($rev_sum, "USD") . "\n";
                        ?> </td>
                </tr>
                <tr>
                    <th style="width: 65%" scope="row">TOTAL</th>
                    <td><?php
                        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                        echo $fmt->formatCurrency($rev_sum, "USD") . "\n";
                        ?> </td>
                </tr>
                <tr>
                    <th style="width: 65%" scope="row">LESS: DIVIDENDS</th>
                    <td>($0.00)</td>
                </tr>
                <tr>
                    <th style="width: 65%" scope="row">RETAINED EARNINGS</th>
                    <td><?php
                        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                        echo $fmt->formatCurrency($rev_sum, "USD") . "\n";
                        ?> </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>

</body>

</html>
