<?php

require('database.php');
require('admin_navigation.php');

$accountID = $_GET['accountid'];
$accountName = $_GET['accountname'];

$journal_data = $pdo->prepare("SELECT * FROM journal_data WHERE accID=:accID");
$journal_data->bindValue(":accID", $accountID);
$journal_data->execute();
$journal_data->setFetchMode(PDO::FETCH_ASSOC);

$balance = 0;
$count = 0;
$balance_array = [];

$balance_troll = $pdo->prepare("SELECT * FROM journal_data WHERE accID=:accID");
$balance_troll->bindValue(":accID", $accountID);
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
    array_push($balance_array, $balance);

}
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- Datatables -->
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	
	<title>CountOnUs - Account Ledger</title>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#ledger-table-view').DataTable();

        } );

    </script>
</head>

<body>
	<div class="bd-highlight body-format" style="padding: 20px; color: #FFFFFF">
		<div>
			<h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Ledger<span style="float: right">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="account-name">Account</span>
  					</div>
  					<input type="text" class="form-control" placeholder="<?php  echo $accountName ?>" aria-label="Account name" aria-describedby="account-name" disabled>
				</div>
			</span></h1>
		</div>

		<div class="border border-secondary rounded bg-dark">
			<div style="padding: 10px">
				<table id="ledger-table-view" class="table hover table-striped table-bordered table-dark" style="width: 100%">
					<thead>
						<tr>
							<th>DATE OF ENTRY</th>
							<th>DESCRIPTION</th>
							<th>DEBIT</th>
							<th>CREDIT</th>
							<th>BALANCE</th>
							<th style="width: 5%">PR</th>
						</tr>
					</thead>
					<tbody>
                    <?php
                    $i = 0;
                    while ($rowAssets = $journal_data->fetch()): ?>
						<tr>
							<td>
                                <?php
                                $rID = $rowAssets['referenceID'];
                                $stmt = $pdo->prepare('SELECT dateCreated FROM journal where referenceID=:referenceID');
                                $stmt->bindValue(":referenceID", $rID);
                                $stmt->execute();
                                $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
                                $dateCreated = $stmt['dateCreated'];
                                echo htmlspecialchars($dateCreated);
                                ?>

                            </td>
							<td><?php echo htmlspecialchars($rowAssets['description']); ?></td>
							<td><?php echo htmlspecialchars($rowAssets['debit']); ?></td>
							<td><?php echo htmlspecialchars($rowAssets['credit']); ?></td>
							<td>
                                <?php
                                $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                                echo $fmt->formatCurrency($balance_array[$i], "USD")."\n";
                                $i++;
							?></td>
							<td><a class="btn btn-secondary btn-sm" href="/edit_journal?referenceID=<?php echo $rowAssets['referenceID']; ?>" role="button">View</a></td>
						</tr>
                    <?php  endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="d-flex justify-content-start" style="padding-top: 5px">
			<div class="p-2">
				<a class="btn btn-primary" href="#" role="button">Add journal entry</a>
			</div>
		</div>
	</div>



</body>

</html>
