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
	
	<title>CountOnUs - Chart of Accounts</title>

</head>

<body>
	<div style="padding: 20px; color: #FFFFFF">
		<div class="d-flex justify-content-between">
        	<div class="p-2">
            	<h1 style="text-align: left; font-size: 24px">Chart of Accounts</h1>
        	</div>

        	<div class="p-2">
            	 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEmail">Email</button>
        	</div>
    	</div>

		<div class="border border-secondary rounded bg-dark">
			<div style="padding: 10px">
				<table id="journal-table-view" class="table hover table-bordered table-dark" style="width: 100%">
					<thead>
						<tr>
							<th>ACCOUNT NAME</th>
							<th>ACCOUNT ID</th>
							<th>DESCRIPTION</th>
							<th>CATEGORY</th>
							<th>DATE/TIME ADDED</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Cash</td>
							<td>101</td>
							<td>Cash acct for business</td>
							<td>Asset</td>
							<td>03/01/2020 4:00 PM</td>
						</tr>
						<tr>
							<td>Payroll Expenses</td>
							<td>202</td>
							<td>Payroll acct. for business</td>
							<td>Expense</td>
							<td>03/01/2020 5:00 PM</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="d-flex justify-content-start" style="padding-top: 5px">
			<div class="p-2">
				<a class="btn btn-secondary btn-sm" href="#" role="button">Add account</a>
				<a class="btn btn-secondary btn-sm" href="#" role="button">View account details</a>
			</div>
		</div>
	</div>

	  <!-- Modal -->
  <div class="modal fade bg-dark" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Compose Email Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-light">
          <form>
            <!-- Input for email recipient(s)-->
            <div class="form-group">
              <div class="row">
                <div class="col-sm-auto">
                  <label for="inputTo">To</label>
                </div>
                <div class="col-lg">  
                  <input type="email" class="form-control" id="inputTo" placeholder="Enter recipient(s)' email address" required>
                </div>
                <div class="col-sm-auto">
                  <button type="button" class="btn btn-secondary btn-sm" style="padding-left: 8px">Search</button>
                </div>
              </div>
            </div>

            <!-- Input for email subject-->
            <div class="form-group">
              <div class="row">
                <div class="col-sm-auto">
                  <label for="inputSubject">Subject</label>
                </div>
                <div class="col-lg">
                  <input type="text" class="form-control" id="inputSubject" placeholder="Enter subject">
                </div>
              </div>
            </div>

            <!-- Input for email message-->
            <div class="form-group">
              <label for="inputMessage">Message</label>
              <textarea class="form-control" id="inputMessage" rows="12" placeholder="..."></textarea>
            </div>

            <!--Input for attachments-->
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Attachments</span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputAttachment">
                <label class="custom-file-label" for="inputAttachment">Choose file(s)</label>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Send</button>
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

	    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 

</body>

</html>
