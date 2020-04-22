<?php

require('database.php');
require('admin_navigation.php');
$referenceID = $_GET['referenceID'];
$asset = $pdo->query('SELECT accID, accName, description, date FROM assets');
$asset->setFetchMode(PDO::FETCH_ASSOC);
$liability = $pdo->query('SELECT accID, accName, description, date FROM liability');
$liability->setFetchMode(PDO::FETCH_ASSOC);
$equity = $pdo->query('SELECT accID, accName, description, date FROM equity');
$equity->setFetchMode(PDO::FETCH_ASSOC);
$expenses = $pdo->query('SELECT accID, accName, description, date FROM expenses');
$expenses->setFetchMode(PDO::FETCH_ASSOC);
$revenue = $pdo->query('SELECT accID, accName, description, date FROM revenue');
$revenue->setFetchMode(PDO::FETCH_ASSOC);


$time = date("Y-m-d H:i:s", time());
$clientID = $_SESSION['userid'];


$stmt = $pdo->prepare('SELECT firstname, lastname FROM account WHERE id=:id');
$stmt->bindValue(":id", $clientID);
$stmt->execute();
$userinfo = $stmt->fetch(PDO::FETCH_ASSOC);
$f_display = $userinfo['firstname'];
$l_display = $userinfo['lastname'];
$clientName = $f_display." ".$l_display;

$journal_data = $pdo->prepare('SELECT journal_data_id, accName, description, debit, credit FROM journal_data WHERE referenceID=:referenceID');
$journal_data->bindValue(":referenceID", $referenceID);
$journal_data->execute();
$journal_data->setFetchMode(PDO::FETCH_ASSOC);

$journal_date = $pdo->prepare('SELECT dateCreated FROM journal WHERE referenceID=:referenceID');
$journal_date->bindValue(":referenceID", $referenceID);
$journal_date->execute();
$j_d_fetch = $journal_date->fetch(PDO::FETCH_ASSOC);
$date = $j_d_fetch['dateCreated'];
$date_php = strtotime($date);
$formatted = date("m/d/yy", $date_php);

$balance = updateBalance($pdo, $referenceID);
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
    if($balance != 0)
    {
        $stmt=$pdo->prepare('UPDATE journal SET status=-1 WHERE referenceID=:referenceID');
        $stmt->bindValue(':referenceID', $referenceID);
        $stmt->execute();
    }
    else
    {
        $stmt=$pdo->prepare('UPDATE journal SET status=0 WHERE referenceID=:referenceID');
        $stmt->bindValue(':referenceID', $referenceID);
        $stmt->execute();
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

    <title>CountOnUs - Journal Entry</title>
    <script type="text/javascript">
        $(document).ready(function () {
            #journal-table-view
            var table = $('#journal-table-view').DataTable({
                dom: 'lfBrtip',
                buttons: [
                    'print'
                ]
            });
            $("#journal-table-view_wrapper > .dt-buttons").appendTo("div.p-2");
            var referenceID = '<?php echo $referenceID ?>';
            $('#journal-table-view tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });
            $('#addLineSubmit').click(function(){
                var rowCount = table.data().length;
                var accountID = $('#modalAddLine #accountCategoryOption').val();
                var debit = $('#modalAddLine #debit').val();
                var credit = $('#modalAddLine #credit').val();
                var addDescription = $('#modalAddLine #addDescription').val();
                var type = "addLine";
                $.ajax(
                    {
                        url: 'post/journal_post',
                        method: 'post',
                        data :{type:type,rowCount:rowCount, accountID: accountID, debit:debit, credit:credit, addDescription: addDescription, referenceID: referenceID},
                        success(data)
                        {
                            alert(data);
                            $('#modalAddLine').hide();
                            location.reload();
                        }
                    }
                );


            });
            $('#editLine').click(function() {
                if(table.row('.selected').any())
                {
                    $('#modalEditLine').modal('show');
                    var data = table.row('.selected').data();
                    var debitorcredit = 0;
                    $('#modalEditLine #accountCategoryOption').val(data[1]);
                    $('#modalEditLine #debit').val(data[3]);
                    $('#modalEditLine #credit').val(data[4]);
                    $('#modalEditLine #editDescription').val(data[2]);
                }
                else
                {
                    alert('You must select a row in the table before modification!');
                }
            });
            $('#EditLineSubmit').click(function(){
                var rowCount = table.row('.selected').index();
                var accountname = $('#modalEditLine #accountCategoryOption').val();
                var debit = $('#modalEditLine #debit').val();
                var credit = $('#modalEditLine #credit').val();
                var addDescription = $('#modalEditLine #editDescription').val();
                var type = "editLine";
                alert(rowCount + ' ' + accountname + 'type');
                $.ajax(
                    {
                        url: 'post/journal_post',
                        method: 'post',
                        data :{type:type,rowCount:rowCount, accountname: accountname, debit:debit, credit:credit, addDescription: addDescription, referenceID: referenceID},
                        success(data)
                        {
                            alert(data);
                            $('#modalEditLine').hide();
                            location.reload();
                        }
                    }
                );
            });
            $('#deleteLine').click(function(){
                if(table.row('.selected').any())
                {
                    var data = table.row('.selected').data();
                    if(window.confirm("Do you really want to delete the account " + data[0] + ", Account: " + data[1]))
                    {
                        var rowCount = table.row('.selected').index();
                        var type = "deleteLine";
                        $.ajax(
                            {
                                url: 'post/journal_post',
                                method: 'post',
                                data :{type:type,rowCount:rowCount, referenceID: referenceID},
                                success(data)
                                {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        );
                    }

                }
                else
                {
                    alert('You must select a row in the table before modification!');
                }
            });
        });
    </script>

</head>

<body>
<div class="body-format" style="padding: 20px; color: #FFFFFF">
    <h1 style="text-align: left; font-size: 26px; padding-bottom: 5px">Current Balance: <?php
        $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
        echo $fmt->formatCurrency($balance, "USD")."\n";
        ?>

    </h1>
    <div class="d-flex justify-content-between" style="padding-bottom: 5px">
        <div class="p-2">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="journal-date">Journal Date</span>
                </div>
                <input type="date" class="form-control" placeholder="" aria-label="Select date" aria-describedby="journal-date" value="<?php echo date('m/d/yy'); ?>">
            </div>
        </div>
        <div class="p-2">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="journal-no">Journal No.</span>
                </div>
                <input type="text" class="form-control" placeholder="<?php echo $referenceID; ?>" aria-label="#" aria-describedby="journal-no" disabled>
            </div>
        </div>
    </div>
    <div class="border border-secondary rounded bg-dark">
        <div style="padding: 10px">
            <table id="journal-table-view" class="table hover table-striped table-bordered table-dark" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ACCOUNT</th>
                    <th>DESCRIPTION</th>
                    <th>DEBITS</th>
                    <th>CREDITS</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($rowAssets = $journal_data->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rowAssets['journal_data_id']); ?></td>
                        <td><?php echo htmlspecialchars($rowAssets['accName']); ?></td>
                        <td><?php echo htmlspecialchars($rowAssets['description']); ?></td>
                        <td><?php echo htmlspecialchars($rowAssets['debit']); ?></td>
                        <td><?php echo htmlspecialchars($rowAssets['credit']); ?></td>
                    </tr>
                <?php  endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-start" style="padding-top: 5px; padding-bottom: 18px">
        <div class="p-2">
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAddLine">Add line</button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" id="editLine">Edit line</button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" id="deleteLine">Delete line</button>

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
                <form method="post" id="addJournalEntry" class="was-validated">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Added By</span>
                        </div>
                        <input type="text" class="form-control" placeholder="<?php echo $clientName ?>" value="<?php echo $clientName ?>" aria-label="accountName" aria-describedby="basic-addon1" id="addPerson" disabled>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Account Category</label>
                        </div>
                        <select class="custom-select" id="accountCategoryOption" required>
                            <option value="" selected>Choose...</option>
                            <?php while ($rowAssets = $asset->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accID']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Asset</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $liability->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accID']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Liability</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $equity->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accID']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Equity</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $expenses->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accID']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Expenses</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $revenue->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accID']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Revenue</option>
                            <?php endwhile; ?>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Debit" aria-label="accountName" aria-describedby="basic-addon1" id="debit" data-type='currency' required>
                        <input type="text" class="form-control" placeholder="Credit" aria-label="accountName" aria-describedby="basic-addon1" id="credit" data-type='currency' required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>


                    </div>

                    <!-- Input for description-->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Description</span>

                        </div>
                        <textarea class="form-control" aria-label="With textarea" id="addDescription" required></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addLineSubmit">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php

$asset = $pdo->query('SELECT accID, accName, description, date FROM assets');
$asset->setFetchMode(PDO::FETCH_ASSOC);
$liability = $pdo->query('SELECT accID, accName, description, date FROM liability');
$liability->setFetchMode(PDO::FETCH_ASSOC);
$equity = $pdo->query('SELECT accID, accName, description, date FROM equity');
$equity->setFetchMode(PDO::FETCH_ASSOC);
$expenses = $pdo->query('SELECT accID, accName, description, date FROM expenses');
$expenses->setFetchMode(PDO::FETCH_ASSOC);
$revenue = $pdo->query('SELECT accID, accName, description, date FROM revenue');
$revenue->setFetchMode(PDO::FETCH_ASSOC);

?>
<!-- edit line -->
<div class="modal fade bg-dark" id="modalEditLine" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add line to journal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form method="post" id="addJournalEntry" class="was-validated">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Edited By</span>
                        </div>
                        <input type="text" class="form-control" placeholder="<?php echo $clientName ?>" value="<?php echo $clientName ?>" aria-label="accountName" aria-describedby="basic-addon1" id="addPerson" disabled>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Account Category</label>
                        </div>
                        <select class="custom-select" id="accountCategoryOption" required>
                            <option value="" selected>Choose...</option>
                            <?php while ($rowAssets = $asset->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accName']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Asset</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $liability->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accName']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Liability</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $equity->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accName']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Equity</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $expenses->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accName']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Expenses</option>
                            <?php endwhile; ?>

                            <?php while ($rowAssets = $revenue->fetch()):?>
                                <option value="<?php echo htmlspecialchars($rowAssets['accName']) ?>"><?php echo htmlspecialchars($rowAssets['accName']) ?> - Revenue</option>
                            <?php endwhile; ?>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Debit" aria-label="accountName" aria-describedby="basic-addon1" id="debit" data-type='currency' required>
                        <input type="text" class="form-control" placeholder="Credit" aria-label="accountName" aria-describedby="basic-addon1" id="credit" data-type='currency' required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Input for description-->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Description</span>
                        </div>
                        <textarea class="form-control" aria-label="With textarea" id="editDescription" required></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="EditLineSubmit">Edit</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>

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

</body>

</html>
