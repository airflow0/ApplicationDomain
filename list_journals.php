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
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

    <title>CountOnUs - List of General Journal Entries</title>
</head>

<body>
<div style="padding: 20px; color: #FFFFFF">
    <div class="d-flex justify-content-between" style="padding-bottom: 5px">
        <div class="p-2">
            <h1 style="text-align: left; font-size: 24px">List of General Journal Entries</h1>
        </div>
    </div>
    <div class="p-2">
        <div class="input-group mb-3">
            <a class="btn btn-primary" href="#" role="button">New journal entry</a>
        </div>
    </div>
</div>


<div class="border border-secondary rounded bg-dark" style="width: 100%">
    <div style="padding: 10px; width: 100%">
        <table id="list-journal-table-view" class="table hover table-bordered table-dark" style="width: 100%">
            <thead>
            <tr>
                <th>JOURNAL #</th>
                <th>DATE</th>
                <th>ACCOUNT</th>
                <th>NAME</th>
                <th>STATUS</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>2</td>
                <td>03/01/2020</td>
                <td>Payroll</td>
                <td>tjohnson</td>
                <td>Pending</td>
                <td>
                    <div class="d-flex">
                        <div class="p-2">
                            <a class="btn btn-secondary" href="#" role="button">View</a>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#modalStatus">Update status
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>03/03/2020</td>
                <td>Payroll</td>
                <td>tjohnson</td>
                <td>Pending</td>
                <td>
                    <div class="d-flex">
                        <div class="p-2">
                            <a class="btn btn-secondary" href="#" role="button">View</a>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#modalStatus">Update status
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bg-dark" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Update journal entry status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form>
                    <div class="form-group">
                        <label for="select-status">Status</label>
                        <select class="form-control" id="select-status">
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Rejected</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="reason-status">Memo</label>
                        <textarea class="form-control" id="reason-status" rows="5"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#list-journal-table-view').DataTable();
        });

        $('#list-journal-table-view').dataTable({
            "columnDefs": [
                {"width": "15%", "targets": 5}
            ]
        });
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

</body>

</html>
