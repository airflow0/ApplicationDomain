<?php

require('database.php');
require('admin_navigation.php');

$accountName = $_GET['accountname'];
$accountID = $_GET['accountid'];

$stmt = $pdo->prepare("SELECT eventID,modifiedBy,dateModified,time,details from eventlog where accID=:accID");
$stmt->bindValue(":accID", $accountID);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

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

    <title>CountOnUs - Event Log</title>
</head>

<body>
<div class="bd-highlight body-format" style="padding: 20px; color: #FFFFFF">
    <div>
        <h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Event Log<span style="float: right">
				<div class="input-group mb-3">
  					<div class="input-group-prepend">
    					<span class="input-group-text" id="account-name">Account</span>
  					</div>
                    <input type="text" class="form-control" placeholder="<?php echo $accountID ?>" aria-label="Account name" aria-describedby="account-name" disabled>
				</div>
			</span></h1>
    </div>

    <div class="border border-secondary rounded bg-dark">
        <div style="padding: 10px">
            <table id="ledger-table-view" class="table hover table-bordered table-dark" style="width: 100%">
                <thead>
                <tr>
                    <th>EVENT ID</th>
                    <th>MODIFIED BY</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th>DETAILS</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while($row = $stmt->fetch()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['eventID']) ?></td>
                    <td><?php echo htmlspecialchars($row['modifiedBy']) ?></td>
                    <td><?php echo htmlspecialchars($row['dateModified']) ?></td>
                    <td><?php echo htmlspecialchars($row['time']) ?></td>
                    <td><?php echo htmlspecialchars($row['details']) ?></td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $('#ledger-table-view').DataTable();
    } );

</body>
</html>