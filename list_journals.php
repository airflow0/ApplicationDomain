<?php

require('database.php');
require('admin_navigation.php');

$journal_data = $pdo->query('SELECT referenceID, createdBy, dateCreated, status, balance from journal');
$journal_data->execute;
$journal_data->setFetchMode(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare('SELECT referenceID from journal');
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($j = $stmt->fetch()):
    updateBalance($pdo, $j['referenceID']);

endwhile;


function updateBalance(PDO $pdo, $referenceID)
{
    $balance = 0;

    $stmt = $pdo->prepare('SELECT * FROM journal_data WHERE referenceID=:referenceID');
    $stmt->bindValue(':referenceID', $referenceID);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($transaction = $stmt->fetch())
    {
        $debit_money = preg_replace('/[^\d,\.]/', '', $transaction['debit']);
        $debit_money = str_replace(',', '', $debit_money);
        $credit_money = preg_replace('/[^\d,\.]/', '', $transaction['credit']);
        $credit_money = str_replace(',', '', $credit_money);
        if($transaction['accountType'] == 1)
        {
            if($debit_money != null)
            {
                $balance = $balance + $debit_money;
            }
            if($credit_money != null)
            {
                $balance = $balance - $credit_money;
            }
        }
        else if ($transaction['accountType'] == 2)
        {
            if($debit_money != null)
            {
                $balance = $balance - $debit_money;
            }
            if($credit_money != null)
            {
                $balance = $balance + $credit_money;
            }
        }
        else if ($transaction['accountType'] == 3)
        {
            if($debit_money != null)
            {
                $balance = $balance - $debit_money;
            }
            if($credit_money != null)
            {
                $balance = $balance + $credit_money;
            }
        }
        else if ($transaction['accountType'] == 4)
        {
            if($debit_money != null)
            {
                $balance = $balance - $debit_money;
            }
            if($credit_money != null)
            {
                $balance = $balance + $credit_money;
            }
        }
        else if ($transaction['accountType'] == 5)
        {
            if($debit_money != null)
            {
                $balance = $balance + $debit_money;
            }
            if($credit_money != null)
            {
                $balance = $balance - $credit_money;
            }
        }
        else
        {

        }
    }
    $stmt=$pdo->prepare('UPDATE journal SET balance=:balance WHERE referenceID=:referenceID');
    $stmt->bindValue(':balance', $balance);
    $stmt->bindValue(':referenceID', $referenceID);
    $stmt->execute();

    $stmt = $pdo->prepare('SELECT status FROM journal where referenceID=:referenceID');
    $stmt->bindValue(':referenceID', $referenceID);
    $stmt->execute();
    $relay = $stmt->fetch(PDO::FETCH_ASSOC);
    $status = $relay['status'];
    if($status != 1)
    {
        if($balance != 0)
        {
            $stmt=$pdo->prepare('UPDATE journal SET status=-1 WHERE referenceID=:referenceID');
            $stmt->bindValue(':referenceID', $referenceID);
            $stmt->execute();
        }
    }

    return $balance;
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

    <title>CountOnUs - List of General Journal Entries</title>

    <script type="text/javascript">

        $(document).ready(function () {
            var table = $('#list-journal-table-view').DataTable({
                dom: 'lfBrtip',
                buttons: [
                    'print'
                ]
            });
            $("#list-journal-table-view_wrapper > .dt-buttons").appendTo("div.print_button");

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
            <a><img class="calendar-icon" src="images/calendar.png" style="width:30px; margin-right: 10px" alt="Calendar" data-toggle="modal" data-target="#modalCalendar"></a>
            <a class="btn btn-primary" href="journal_entry" role="button">Add journal entry</a>
        </div>
    </div>
    <div class="border border-secondary rounded bg-dark" style="width: 100%">
        <div style="padding: 10px; width: 100%">
            <table id="list-journal-table-view" class="table hover table-striped table-bordered table-dark" style="width: 100%">
                <thead>
                <tr>
                    <th>JOURNAL #</th>
                    <th>ACCOUNTS</th>
                    <th>DATE ADDED</th>
                    <th>NAME</th>
                    <th>BALANCE</th>
                    <th>STATUS</th>
                    <th style="width:9%"></th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($rowAssets = $journal_data->fetch()):

                    ?>

                    <tr>
                        <td><?php echo htmlspecialchars($rowAssets['referenceID']); ?></td>
                       <!-------- ADD ACCOUNTS TO TABLE ------------->
                        <td><?php
                            $stmt = $pdo->prepare('SELECT accName from journal_data WHERE referenceID=:referenceID');
                            $stmt->bindValue(':referenceID', $rowAssets['referenceID']);
                            $stmt->execute();
                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            $arr = [];
                            while($name = $stmt->fetch()):
                                $name_f = $name['accName'];
                                if(in_array($name_f, $arr))
                                {

                                }
                                else
                                {
                                    array_push($arr, $name_f);
                                }
                            endwhile;

                                print_r(implode(', ', $arr));


                            ?></td>
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
                        <td>
                            <?php
                            $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
                            echo $fmt->formatCurrency($rowAssets['balance'], "USD")."\n";

                            ?>
                        </td>
                        <td><?php
                            $status = htmlspecialchars($rowAssets['status']);
                            if($status == -1)
                            {
                                echo 'Rejected';
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

<div class="print_button" style="margin-left: 20px"></div>

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
</div>

<!-- Calendar modal -->
<div class="modal fade bg-dark" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Select date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="from" >From</label>
                        </div>
                        <div class="col-md">
                            <input type="date" class="form-control" id="from"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-sm-3">
                                <label for="to">To</label>
                            </div>
                            <div class="col-md">
                                <input type="date" class="form-control" id="to"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row" style="margin-top: 15px">
                            <div class="form-check">
                                <div class="col-md">
                                    <input class="form-check-input" type="checkbox" value="" id="show-all-dates">
                                    <label class="form-check-label" for="show-all-dates">
                                        Show all dates
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
