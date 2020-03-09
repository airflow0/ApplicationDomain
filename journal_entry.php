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
	
	<title>CountOnUs - Journal Entry</title>
</head>

<body>
	<div class="body-format" style="padding: 20px; color: #FFFFFF">
		<h1 style="text-align: left; font-size: 26px; padding-bottom: 5px">Journal Entry #</h1>
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
							<td><button type="button" class="btn btn-secondary btn-sm" href="#">Edit</button></td>
						</tr>
						<tr>
							<td>2</td>
							<td>Payroll Expenses</td>
							<td>1500</td>
							<td></td>
							<td>Expense as wages for employees</td>
							<td>tjohnson</td>
							<td><button type="button" class="btn btn-secondary btn-sm" href="#">Edit</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="d-flex justify-content-start" style="padding-top: 5px; padding-bottom: 18px">
			<div class="p-2">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAddLine">Add line</button>
				<a class="btn btn-secondary" href="#" role="button">Clear all lines</a>
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

    <!-- Modal for adding a line to journal -->
    <div class="modal fade bg-dark" id="modalAddLine" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add line to journal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <form>
                        <!-- Input for account name -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <label for="inputAccount">Account</label>
                                </div>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="inputAccount" placeholder="Enter account name" required>
                                </div>
                            </div>
                        </div>

                        <!-- Input for debits -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <label for="inputDebits">Debits</label>
                                </div>
                                <div class="col-lg">
                                    <input type="number" class="form-control" id="inputDebits" placeholder="Enter value for debits">
                                </div>
                            </div>
                        </div>

                        <!-- Input for credits-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <label for="inputCredits">Credits</label>
                                </div>
                                <div class="col-lg">
                                    <input type="number" class="form-control" id="inputCredits" placeholder="Enter value for credits">
                                </div>
                            </div>
                        </div>

                        <!-- Input for description-->
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea class="form-control" id="inputDescription" rows="3" placeholder="..."></textarea>
                        </div>

                        <!--Input for name-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <label for="inputName">Name</label>
                                </div>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="inputName" placeholder="Enter User ID" required>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add</button>
                </div>
                </form>
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
