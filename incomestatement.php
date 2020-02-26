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

    <h3 class="p-2 flex-fill bd-highlight" style="text-align: center; color: white; font-family: sans-serif; font-weight: bold"> Income Statement</h3>
</div>

<h3 class="p-2 flex-fill bd-highlight" style="text-align: Left; color: white; font-family: sans-serif; font-weight: bold; margin-left:60px;"> Revenue</h3>
<div class="d-flex flex-column" style="margin-left: 50px; margin-right: 50px;">
    <div class="p-2">
        <table id="account_table" class="table table-dark">
            <thead>
            <tr>

                <th scope="col">Description</th>
                <th scope="col">Currency</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Sales</td>
                <td>$</td>
                <td>10,000</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<h3 class="p-2 flex-fill bd-highlight" style="text-align: Left; color: white; font-family: sans-serif; font-weight: bold; margin-left:60px;"> Expenses</h3>
<div class="d-flex flex-column" style="margin-left: 50px; margin-right: 50px;">
    <div class="p-2">
        <table id="account_table" class="table table-dark">
            <thead>
            <tr>

                <th scope="col">Cost of Goods Sold</th>
                <th scope="col">Currency</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Payable</td>
                <td>$</td>
                <td>10,000</td>
            </tr>

            </tbody>
        </table>
    </div>
</div>

<h3 class="p-2 flex-fill bd-highlight" style="text-align: Left; color: white; font-family: sans-serif; font-weight: bold; margin-left:60px;"> Net Income</h3>
<div class="d-flex flex-column" style="margin-left: 50px; margin-right: 50px;">
    <div class="p-2">
        <table id="account_table" class="table table-dark">
            <thead>
            <tr>

                <th scope="col">Description</th>
                <th scope="col">Currency</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Total:</td>
                <td></td>
                <td>$0.00</td>
            </tr>
            </tbody>
        </table>
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
