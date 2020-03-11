<?php

require('database.php');
require('admin_navigation.php');

$journal_data = $pdo->query('SELECT referenceID, createdBy, dateCreated, status from journal');
$journal_data->execute;
$journal_data->setFetchMode(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

    <title>CountOnUs - List of General Journal Entries</title>

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#list-journal-table-view').DataTable();
            $('#list-journal-table-view tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });
            $('#list-journal-table-view tbody').on('dblclick', 'tr', function () {
                var data = table.row( this ).data();
                var url = 'edit_journal?referenceID=' +data[0];
                $(location).attr('href',url);
            } );
            $('#list-journal-table-view tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr') ).data();
                var referenceID = data[0];
                $('#modalStatus').modal('show');
                if(data[4] == "Rejected")
                {
                    $('#modalStatus #select-status').val(-1);
                } else if(data[4] == "Pending")
                {
                    $('#modalStatus #select-status').val(0);
                }
                else if(data[4] == "Approved")
                {
                    $('#modalStatus #select-status').val(1);
                }
                var type = "getMemo";
                $.ajax(
                    {
                        url: 'post/list_journals_post',
                        method: 'post',
                        data :{ type: type, referenceID },
                        success(data)
                        {
                            $('#modalStatus #reason-status').val(data);

                        }
                    }
                );

                $('#update_status').click(function(){
                    type = "update";
                    var status = $('#modalStatus #select-status').children("option:selected").val();
                    var memo = $('#modalStatus #reason-status').val();
                    $.ajax(
                        {
                            url: 'post/list_journals_post',
                            method: 'post',
                            data :{ type: type, referenceID:referenceID, memo: memo, status: status },
                            success(data)
                            {
                                $('#modalStatus').hide();
                                location.reload();
                            }
                        }
                    );
                });
            } );

        });
    </script>
</head>

<body>
<div class="body-format" style="padding: 20px; color: #FFFFFF">
    <div class="d-flex justify-content-between" style="margin-bottom: -15px">
        <div class="p-2">
            <h1 style="text-align: left; font-size: 26px">List of General Journal Entries</h1>
        </div>

        <div class="p-2">
            <a class="btn btn-primary" href="journal_entry" role="button">Add journal entry</a>
        </div>
    </div>

    <div class="border border-secondary rounded bg-dark" style="width: 100%">
        <div style="padding: 10px; width: 100%">
            <table id="list-journal-table-view" class="table hover table-striped table-bordered table-dark" style="width: 100%">
                <thead>
                <tr>
                    <th>JOURNAL #</th>
                    <th>DATE</th>
                    <th>NAME</th>
                    <th>STATUS</th>
                    <th style="width:9%"></th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($rowAssets = $journal_data->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rowAssets['referenceID']); ?></td>
                        <td><?php echo htmlspecialchars($rowAssets['dateCreated']); ?></td>

                        <td><?php
                            $stmt = $pdo->prepare('SELECT firstname, lastname FROM account WHERE id=:id');
                            $stmt->bindValue(":id", $rowAssets['createdBy']);
                            $stmt->execute();
                            $userinfo = $stmt->fetch(PDO::FETCH_ASSOC);
                            $f_display = $userinfo['firstname'];
                            $l_display = $userinfo['lastname'];

                            $clientName = $f_display." ".$l_display;

                            echo htmlspecialchars($clientName); ?>
                        </td>
                        <td><?php
                            $status = htmlspecialchars($rowAssets['status']);
                            if($status == -1)
                            {
                                echo 'Denied';
                            } elseif ($status == 0)
                            {
                                echo 'Pending';
                            }
                            else
                            {
                                echo 'Approved';
                            }


                            ?></td>
                        <td>
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    id="status">Update status
                            </button>
                        </td>
                    </tr>
                <?php  endwhile; ?>
                </tbody>
            </table>
        </div>
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
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="-1">Rejected</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="reason-status">Memo</label>
                        <textarea class="form-control" id="reason-status" rows="5"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="update_status">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
