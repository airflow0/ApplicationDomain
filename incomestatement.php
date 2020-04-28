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



$exp = $pdo->prepare('SELECT accID, accName FROM expenses');
$exp->execute();
$exp_array = [];
while ($expense = $exp->fetch(PDO::FETCH_ASSOC)) {
    $exp_balance = 0;
    $stmt = $pdo->prepare('SELECT * FROM journal_data where accID=:accID');
    $stmt->bindValue('accID', $expense['accID']);
    $stmt->execute();
    while ($exp_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $exp_debit = preg_replace('/[^\d,\.]/', '', $exp_data['debit']);
        $exp_debit = str_replace(',', '', $exp_debit);
        if ($exp_debit != null) {
            $exp_balance = $exp_balance + $exp_debit;
        }
        $exp_credit = preg_replace('/[^\d,\.]/', '', $exp_data['credit']);
        $exp_credit = str_replace(',', '', $exp_credit);
        if ($rev_credit != null) {
            $exp_balance = $exp_balance - $exp_credit;
        }
    }
    array_push($exp_array, $exp_balance);
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>CountOnUs - Income Statement</title>
</head>

<body>
<div class="bd-highlight body-format" style="padding: 20px; color: #FFFFFF">
    <div style="padding-bottom: 10px">
        <h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Income Statement<span style="float: right">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="month-year">Month/Year</span>
  					</div>
  					<input type="text" class="form-control" placeholder="MM/YYYY" aria-label="As Of"
                           aria-describedby="month-year" value="<?php echo $time; ?>">
				</div>
			</span></h1>
    </div>

    <div class="border border-secondary rounded bg-white">
        <div style="padding: 10px">
            <table id="rev-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th style="width:10%" scope="row">REVENUES:</th>
                    <td style="width:65%"></td>
                    <td></td>
                </tr>
                <?php
                $accIDS = $pdo->prepare("SELECT accName FROM revenue");
                $accIDS->execute();
                $accIDS->setFetchMode(PDO::FETCH_ASSOC);
                $i = 0;
                $rev_total = 0;
                while($accNames = $accIDS->fetch()):
                    {
                        $rev_total = $rev_total + $rev_array[$i];
                        ?>
                        <tr>
                            <td>
                            </td>
                            <td scope="row"><?php echo htmlspecialchars($accNames['accName']); ?></td>
                            <td><?php $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                                echo $fmt->formatCurrency($rev_array[$i], "USD")."\n";

                                ?></td>
                        </tr>

                        <?php
                        $i++;
                    }
                endwhile;
                ?>
                <tr>
                    <td></td>
                    <th scope="row">Total Revenue</th>
                    <td><?php
                        $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                        echo $fmt->formatCurrency($rev_total, "USD")."\n";
                        ?></td>
                </tr>

                </tbody>
            </table>

            <table id="exp-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th style="width: 10%" scope="row">EXPENSES:</th>
                    <td style="width:65%"></td>
                    <td></td>
                </tr>
                <?php
                $accIDS = $pdo->prepare("SELECT accName FROM expenses");
                $accIDS->execute();
                $accIDS->setFetchMode(PDO::FETCH_ASSOC);
                $i = 0;
                $exp_total = 0;
                while($accNames = $accIDS->fetch()):
                    {
                        $exp_total = $exp_total + $exp_array[$i];
                        ?>
                        <tr>
                            <td>
                            </td>
                            <td scope="row"><?php echo htmlspecialchars($accNames['accName']); ?></td>
                            <td><?php $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                                echo $fmt->formatCurrency($exp_array[$i], "USD")."\n";

                                ?></td>
                        </tr>

                        <?php
                        $i++;
                    }
                endwhile;
                ?>
                <tr>
                    <td></td>
                    <th scope="row">Total Expenses</th>
                    <td><?php
                        $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                        echo $fmt->formatCurrency($exp_total, "USD")."\n";
                        ?></td>
                </tr>

                </tbody>
            </table>

            <table id="net-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th style="width: 75%" scope="row">NET INCOME:</th>
                    <td><?php
                        $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                        echo $fmt->formatCurrency($rev_total - $exp_total, "USD")."\n";
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
<button type="button" class="btn btn-secondary" style="margin-left:20px;" onclick="window.print()">Print</button>
</body>

</html>
