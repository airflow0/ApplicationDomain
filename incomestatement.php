<?php

require('database.php');
if ($_SESSION['isAdmin'] = true) {
    require('admin_navigation.php');
} else {
    require('navigation.php');
}

$accountname = $_GET['accountname'];
$accountid = $_GET['accountid'];

$date = $description = $debit = $credit = $affected = $explanation = "";


if(isset($_POST['addjournal']))
{;
    $date = $_POST['date'];
    $description = $_POST['description'];
    $debit = str_replace(',', '', $_POST['debit']);
    $credit = str_replace(',', '', $_POST['credit']);
    $affected = $_POST['affected'];
    $explanation = $_POST['explanation'];

    $stmt = $pdo->prepare("INSERT into journal (accNumber, date, description, debit, credit, affected, explanation) VALUES (:accNumber, :date, :description, :debit, :credit, :affected, :explanation)");
    $stmt->bindValue(":accNumber", $accountid);
    $stmt->bindValue(":date", $date);
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":debit", $debit);
    $stmt->bindValue(":credit", $credit);
    $stmt->bindValue(":affected", $affected);
    $stmt->bindValue(":explanation", $explanation);
    $stmt->execute();
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
<div class="d-flex bd-highlight" style="margin-top: 100px;">

    <h3 class="p-2 flex-fill bd-highlight" style="text-align: center; color: white; font-family: sans-serif; font-weight: bold"> Income Statement</h3>
</div>

<h3 class="p-2 flex-fill bd-highlight" style="text-align: Left; color: white; font-family: sans-serif; font-weight: bold; margin-left:60px;"> Revenue</h3>
<div class="d-flex flex-column" style="margin-left: 50px; margin-right: 50px;">
    <div class="p-2">
        <table id="account_table" class="table table-dark">
            <thead>
            <tr>

<body>
<div class="bd-highlight body-format" style="padding: 20px; color: #FFFFFF">
    <div style="padding-bottom: 10px">
        <h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Income Statement<span style="float: right">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="month-year">Month/Year</span>
  					</div>
  					<input type="text" class="form-control" placeholder="MM/YYYY" aria-label="Month/year" aria-describedby="month-year">
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
                <tr>
                    <td></td>
                    <td scope="row">Revenue #1</td>
                    <td>100.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Revenue #2</td>
                    <td>200.00</td>
                </tr>
                <tr>
                    <td></td>
                    <th scope="row">Total Revenues</th>
                    <td>300.00</td>
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
                <tr>
                    <td></td>
                    <td scope="row">Expense #1</td>
                    <td>10.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td scope="row">Expense #2</td>
                    <td>20.00</td>
                </tr>
                <tr>
                    <td></td>
                    <th scope="row">Total Expenses</th>
                    <td>30.00</td>
                </tr>

                </tbody>
            </table>

            <table id="net-table" class="table table-striped table-bordered table-dark" style="width: 100%">
                <tbody>
                <tr>
                    <th  style="width: 75%" scope="row">NET INCOME:</th>
                    <td>270.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>

</html>
