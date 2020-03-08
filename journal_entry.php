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
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- Datatables -->
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	
	<title>CountOnUs - Journal View</title>
</head>

<body>
	<div style="padding: 50px; color: #FFFFFF">
		<h1 style="text-align: left; font-size: 24px; padding-bottom: 5px">Journal Entry #</h1>
		<div class="d-flex justify-content-between" style="padding-bottom: 5px">
			<div class="p-2">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="journal-date">Journal Date</span>
  					</div>
  					<input type="date" class="form-control" placeholder="Select date" aria-label="Select date" aria-describedby="journal-date">
				</div>
			</div>
			<div class="p-2">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="journal-no">Journal No.</span>
  					</div>
  					<input type="text" class="form-control" placeholder="#" aria-label="#" aria-describedby="journal-no">
				</div>
			</div>
		</div>
		<div class="border border-secondary rounded bg-dark">
			<div style="padding: 10px">
				<table id="journal-table-view" class="table hover table-bordered table-dark" style="width: 100%">
					<thead>
						<tr>
							<th>#</th>
							<th>ACCOUNT</th>
							<th>DEBITS</th>
							<th>CREDITS</th>
							<th>DESCRIPTION</th>
							<th>NAME</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Cash</td>
							<td></td>
							<td>5000</td>
							<td>Cash recieved as service payment</td>
							<td>tjohnson</td>
							<td><a class="btn btn-secondary btn-sm" href="#" role="button">Edit</a></td>
						</tr>
						<tr>
							<td>2</td>
							<td>Payroll Expenses</td>
							<td>1500</td>
							<td></td>
							<td>Expense as wages for employees</td>
							<td>tjohnson</td>
							<td><a class="btn btn-secondary btn-sm" href="#" role="button">Edit</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="d-flex justify-content-start" style="padding-top: 5px; padding-bottom: 18px">
			<div class="p-2">
				<a class="btn btn-secondary btn-sm" href="#" role="button">Add line</a>
				<a class="btn btn-secondary btn-sm" href="#" role="button">Clear all lines</a>
			</div>
		</div>

		<!--Input for attachments-->
		<div class="input-group mb-3" style="padding-left: 5px; padding-right: 5px">
			<div class="input-group-prepend">
				<span class="input-group-text">Attachments</span>
			</div>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="inputAttachment">
				<label class="custom-file-label" for="inputAttachment">Choose file(s)</label>
			</div>
		</div>
		
		<div class="d-flex justify-content-end" style="padding-top: 5px; padding-bottom: 18px">
			<div class="p-2">
				<a class="btn btn-secondary" href="#" role="button">Cancel</a>
				<a class="btn btn-primary" href="#" role="button">Submit Entry</a>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready( function () {
			$('#journal-table-view').DataTable();
		} );
	</script>

</body>

</html>
