<?php
require('admin_navigation.php');
require('database.php');
$stmt = $pdo->query('SELECT id, firstname, lastname, email, isActive, isManager, isAdmin FROM account');
$stmt->setFetchMode(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Datatables -->
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
</head>
<body>
<div class="body-format" style="padding: 20px; color: #FFFFFF">
    <div class="d-flex justify-content-start">
        <div class="p-2">
            <h1 style="text-align: left; font-size: 26px; margin-bottom:-5px">Manage Users</h1>
        </div>
    </div>

    <div class="border border-secondary rounded bg-dark">
        <div style="padding: 10px">
            <table id="user_table" class="table hover table-bordered table-dark">
                <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Active?</th>
                    <th scope="col">Manager?</th>
                    <th scope="col">Admin?</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                    <tr>
                        <td> <a href="admin_user_update?id=<?php echo $row['id']?>"><?php echo htmlspecialchars($row['id']) ?></a></td>
                        <td><?php echo htmlspecialchars($row['firstname']) ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                        <td>
                            <?php
                            $valid = "valid";
                            if($row['isActive'] == 0)
                            {
                                $valid = "invalid";
                                print '<form method="post" action="admin_user_table_update?id='.$row['id'].'"><input type="submit" name="switchtovalid" class="btn btn-secondary btn-sm" value='.$valid.'></a> </form>';
                            }
                            else
                            {
                                print '<form method="post" action="admin_user_table_update?id='.$row['id'].'"><input type="submit" name="switchtoinvalid" class="btn btn-secondary btn-sm" value='.$valid.'></a> </form>';
                            }

                            ?>
                        </td>
                        <td>
                            <?php
                            $valid = "valid";
                            if($row['isManager'] == 0)
                            {
                                $valid = "invalid";
                                print '<form method="post" action="admin_user_table_update?id='.$row['id'].'"><input type="submit" name="promoteToManager" class="btn btn-secondary btn-sm" value='.$valid.'></a> </form>';
                            }
                            else
                            {
                                print '<form method="post" action="admin_user_table_update?id='.$row['id'].'"><input type="submit" name="unpromoteToManager" class="btn btn-secondary btn-sm" value='.$valid.'></a> </form>';
                            }

                            ?>
                        </td>
                        <td>
                            <?php
                            $valid = "valid";
                            if($row['isAdmin'] == 0)
                            {
                                $valid = "invalid";
                                print '<form method="post" action="admin_user_table_update?id='.$row['id'].'"><input type="submit" name="promoteToAdmin" class="btn btn-secondary btn-sm" value='.$valid.'></a> </form>';
                            }
                            else
                            {
                                print '<form method="post" action="admin_user_table_update?id='.$row['id'].'"><input type="submit" name="unpromoteToAdmin" class="btn btn-secondary btn-sm" value='.$valid.'></a> </form>';
                            }

                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>


                </tbody>
            </table>
        </div>
    </div>
    <div>


<script>
    function searchTable()
    {
        var input, filter, table, tr, td, i, txtValue, radioValue;
        var temp = "";
        radioValue = document.getElementsByName("radio_choice");

        input = document.getElementById("search_input");

        filter = input.value.toUpperCase();
        table = document.getElementById("user_table");
        tr = table.getElementsByTagName("tr");
        for(i=0; i< radioValue.length; i++) {
            if (radioValue[i].checked == true) {
                temp = radioValue[i].value;

            }
        }
        document.getElementById("demo").innerHTML = temp;
        for(i=0; i < tr.length; i++)
        {
            if (temp == "radio_id") {
                td = tr[i].getElementsByTagName("td")[0];

            }
            if (temp == 'radio_firstname') {
                td = tr[i].getElementsByTagName("td")[1];
            }
            if (temp == 'radio_lastname') {
                td = tr[i].getElementsByTagName("td")[2];
            }
            if (temp == 'radio_email') {
                td = tr[i].getElementsByTagName("td")[3];
            }
            if (temp == 'radio_active') {
                td = tr[i].getElementsByTagName("td")[4];
            }
            if(td)
            {
                txtValue = td.textContent || td.innerText;

                if(txtValue.toUpperCase().indexOf(filter) > -1)
                {
                    tr[i].style.display ="";
                }
                else
                {
                    tr[i].style.display ="none";
                }
            }
        }
    }
</script>
</body>
</html>