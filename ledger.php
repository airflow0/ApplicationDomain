<?php

require('database.php');
if ($_SESSION['isAdmin'] = true) {
    require('admin_navigation.php');
} else {
    require('navigation.php');
}

$accountname = $_GET['accountname'];
$accountid = $_GET['accountid'];

$date = $description = $debit = $credit = $affected = $explanation = "";


if(isset($_POST['addjournal']))
{;
    $date = $_POST['date'];
    $description = $_POST['description'];
    $debit = str_replace(',', '', $_POST['debit']);
    $credit = str_replace(',', '', $_POST['credit']);
    $affected = $_POST['affected'];
    $explanation = $_POST['explanation'];

    $stmt = $pdo->prepare("INSERT into journal (accNumber, date, description, debit, credit, affected, explanation) VALUES (:accNumber, :date, :description, :debit, :credit, :affected, :explanation)");
    $stmt->bindValue(":accNumber", $accountid);
    $stmt->bindValue(":date", $date);
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":debit", $debit);
    $stmt->bindValue(":credit", $credit);
    $stmt->bindValue(":affected", $affected);
    $stmt->bindValue(":explanation", $explanation);
    $stmt->execute();
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
<div class="d-flex bd-highlight" style="margin-top: 100px;">
    <h1 class="p-2 flex-fill bd-highlight" style="text-align: left; margin-left: 60px; color: white; font-family: sans-serif; font-weight: bold"> Account Number: <?php echo $accountid ?> </h1>
    <h3 class="p-2 flex-fill bd-highlight" style="text-align: center; color: white; font-family: sans-serif; font-weight: bold"> Ledger</h3>
    <h1 class="p-2 flex-fill bd-highlight" style="text-align: right;  margin-right: 60px;  color: white; font-family: sans-serif; font-weight: bold"> Account Name: <?php echo $accountname ?></h1>

</div>


<div class="d-flex flex-column" style="margin-left: 50px; margin-right: 50px;">
    <div class="p-2">
        <table id="account_table" class="table table-dark">
            <thead>
            <tr>

                <th scope="col">Date</th>
                <th scope="col">Ref. ID</th>
                <th scope="col">Description</th>
                <th scope="col">Debit</th>
                <th scope="col">Credit</th>
                <th scope="col">Balance</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>2020-02-17</td>
                <td>G0</td>
                <td>Cash in the Bank</td>
                <td>30,000</td>
                <td>30,000</td>
                <td>30,000</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter" style="margin-left: 60px;">Add New Account</button>
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter" style="">Edit Journal</button>
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter" style="">Delete Journal</button>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add a new Journal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" >
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Date</span>
                        </div>
                        <input class="form-control" type="date" value="02/17/2020" name="date" id="example-date-input" required>
                    </div>

                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Desc.</span>
                        </div>
                        <input type="text" class="form-control" name="description" placeholder="Description" aria-label="description" aria-describedby="basic-addon1"required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Account</span>
                        </div>
                        <input type="text" class="form-control" name="affected" placeholder="Affected Account" aria-label="affected" aria-describedby="basic-addon1"required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Explanation</span>
                        </div>
                        <input type="text" class="form-control" name="explanation" placeholder="Explanation" aria-label="explanation" aria-describedby="basic-addon1"required>
                    </div>

                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Debit</span>
                        </div>
                        <input type="text" class="form-control" name="debit" placeholder="Debit"  pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" aria-label="Debit" max="13" aria-describedby="inputGroup-sizing-sm"required>
                    </div>

                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Credit</span>
                        </div>
                        <input type="text" class="form-control" name="credit" placeholder="Credit"  pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" aria-label="Credit" max="13" aria-describedby="inputGroup-sizing-sm" required>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" name="addjournal" id="addjournal" value="Add Journal" class="btn btn-success" />

            </div>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    $('#subcategoryCheck').click(function () {
        var checked = this.checked;
        console.log(checked);
        $('#subcategory').each(function () {
            $(this).prop('disabled', !checked);
        });
    });
    // Jquery Dependency

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
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

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
