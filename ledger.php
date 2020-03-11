<?php

require('database.php');
require('admin_navigation.php');

$accountID = $_GET['accountid'];
$accountName = $_GET['accountname'];

$journal_data = $pdo->prepare("SELECT * FROM journal_data WHERE accID=:accID");
$journal_data->bindValue(":accID", $accountID);
$journal_data->execute();
$journal_data->setFetchMode(PDO::FETCH_ASSOC);
$debitarray = [];
$debit = $pdo->prepare("SELECT debit FROM journal_data WHERE accID=:accID");
$debit->bindValue(":accID", $accountID);
$debit->execute();
$debit->setFetchMode(PDO::FETCH_ASSOC);
while($debit_row = $debit->fetch()):
    $money = preg_replace('/[^\d,\.]/', '', $debit_row['debit']);
    $money = str_replace(',', '', $money);
    array_push($debitarray, $money);
endwhile;


$creditarray = [];
$credit = $pdo->prepare("SELECT credit FROM journal_data WHERE accID=:accID");
$credit->bindValue(":accID", $accountID);
$credit->execute();
$credit->setFetchMode(PDO::FETCH_ASSOC);
while($credit_row = $credit->fetch()):
    $money = preg_replace('/[^\d,\.]/', '', $credit_row['credit']);
    $money = str_replace(',', '', $money);
    array_push($creditarray, $money);
endwhile;

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

        $("input[data-type='currency']").on({
            keyup: function () {
                formatCurrency($(this));
            },
            blur: function () {
                formatCurrency($(this), "blur");
            }
        });

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "$" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "$" + input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
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
				<table id="ledger-table-view" class="table hover table-bordered table-dark" style="width: 100%">
					<thead>
						<tr>
							<th>DATE OF ENTRY</th>
							<th>DESCRIPTION</th>
							<th>DEBIT</th>
							<th>CREDIT</th>
							<th>BALANCE</th>
							<th>PR</th>
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
                                $fmt = new NumberFormatter( 'de_DE', NumberFormatter::CURRENCY );
                                echo $fmt->formatCurrency(1234567.891234567890000, "EUR")."\n";
                                echo $balance_array[$i];
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
