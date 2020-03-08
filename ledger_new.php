<?php

require('database.php');
if ($_SESSION['isAdmin'] = true) {
    require('admin_navigation.php');
} else {
    require('navigation.php');
}
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Datatables -->
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	
	<title>CountOnUs - Ledger View</title>
</head>

<body>
	<div style="padding: 50px">
		<div>
			<h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Ledger<span style="float: right">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="account-name">Account</span>
  					</div>
  					<input type="text" class="form-control" placeholder="Account name" aria-label="Account name" aria-describedby="account-name">
				</div>
			</span></h1>
		</div>
		<div class="border border-secondary rounded">
			<div style="padding: 10px">
				<table id="ledger-table-view" class="table hover table-bordered" style="width: 100%">
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
						<tr>
							<td>03/01/2020</td>
							<td></td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td><a class="btn btn-secondary btn-sm" href="#" role="button">View</a></td>
						</tr>
						<tr>
							<td>03/03/2020</td>
							<td>Cash acquistion and payroll</td>
							<td>1500</td>
							<td>5000</td>
							<td>3500</td>
							<td><a class="btn btn-secondary btn-sm" href="#" role="button">View</a></td>
						</tr>

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

	<script type="text/javascript">
		$(document).ready( function () {
			$('#ledger-table-view').DataTable();
		} );
	</script>

</body>

</html>
