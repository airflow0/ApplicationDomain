<?php
require('admin_navigation.php');
require('database.php');
$stmt = $pdo->query('SELECT id, firstname, lastname, email, isActive, isManager, isAdmin FROM account');
$stmt->setFetchMode(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div class="container-fluid">
    <div class="d-flex flex-column" style="margin-left: 10px; margin-right:10px; ">
        <div class="search">
            <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search_input" onkeyup="searchTable()">
            <div class="admin_user_radio btn-group btn-group-toggle" data-toggle="buttons" style="width:50%;" >
                <label class="btn btn-secondary active">
                    <input type="radio" name="radio_choice" value="radio_id" id="option1"  autocomplete="off" checked> ID
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="radio_choice" value="radio_firstname" id="option2" autocomplete="off"> First Name
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="radio_choice" value="radio_lastname" id="option2" autocomplete="off"> Last Name
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="radio_choice" value="radio_email" id="option3" autocomplete="off"> Email
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="radio_choice" value="radio_active" id="option4" autocomplete="off"> Active
                </label>
            </div>
        </div>

        <div class="p-2">
            <table class="table table-dark" id="user_table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
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

            </table></div>


        <p id="demo"></p>
    </div>
</div>
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