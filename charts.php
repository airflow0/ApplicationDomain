<?php


if ($_SESSION['isAdmin'] = true) {
    require('admin_navigation.php');
} else {
    require('navigation.php');
}
$stmt = $pdo->prepare('SELECT accName from accountnames');
$stmt->execute();
$accountNames = $stmt->fetchAll(\PDO::FETCH_ASSOC);


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

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#account_table').DataTable();

            $('#account_table tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('#account_table tbody').on('dblclick', 'tr', function () {
                var data = table.row( this ).data();
                var url = 'accountview?accountname=' +data[0] +'&accountid='+data[1];
                $(location).attr('href',url);
            } );
        });
    </script>
</head>
<body>
<h3 style="text-align: center; margin-top: 100px; color: white; font-family: sans-serif; font-weight: bold"> Chart of Accounts</h3>
<div class="d-flex flex-column" style="margin-left: 50px; margin-right: 50px;">
    <div class="p-2">
        <table id="account_table" class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Account Name</th>
                <th scope="col">Account ID</th>
                <th scope="col">Description</th>
                <th scope="col">Account Category</th>
                <th scope="col">Date/Time Added</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($rowAssets = $asset->fetch()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($rowAssets['accName']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['accID']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['description']) ?></td>
                    <td>Asset</td>
                    <td><?php echo htmlspecialchars($rowAssets['date']) ?></td>
                </tr>
            <?php endwhile; ?>
            <?php
            while ($rowAssets = $liability->fetch()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($rowAssets['accName']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['accID']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['description']) ?></td>
                    <td>Liability</td>
                    <td><?php echo htmlspecialchars($rowAssets['date']) ?></td>
                </tr>
            <?php endwhile; ?>
            <?php
            while ($rowAssets = $equity->fetch()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($rowAssets['accName']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['accID']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['description']) ?></td>
                    <td>Equity</td>
                    <td><?php echo htmlspecialchars($rowAssets['date']) ?></td>
                </tr>
            <?php endwhile; ?>
            <?php
            while ($rowAssets = $revenue->fetch()):
            ?>
            <tr>
                <td><?php echo htmlspecialchars($rowAssets['accName']) ?></td>
                <td><?php echo htmlspecialchars($rowAssets['accID']) ?></td>
                <td><?php echo htmlspecialchars($rowAssets['description']) ?></td>
                <td>Revenue</td>
                <td><?php echo htmlspecialchars($rowAssets['date']) ?></td>
            </tr>
            <?php endwhile; ?>
            <?php
            while ($rowAssets = $expenses->fetch()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($rowAssets['accName']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['accID']) ?></td>
                    <td><?php echo htmlspecialchars($rowAssets['description']) ?></td>
                    <td>Expenses</td>
                    <td><?php echo htmlspecialchars($rowAssets['date']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter" disabled style="margin-left:60px;">
    Add Account
</button>
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter" disabled>
    Edit Account
</button>
<a href="accountView" class="btn btn-secondary " role="button" aria-pressed="true"> View Account</a>
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter" disabled>
    Delete Account
</button>
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
