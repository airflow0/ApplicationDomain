<?php
require('admin_navigation.php');
require('database.php');
$stmt = $pdo->query('SELECT id, firstname, lastname, email, isActive, isManager, isAdmin FROM account');
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

    <title>CountOnUs - Manage Users</title>
</head>

<body>
<div class="bd-highlight body-format" style="padding: 20px; color: #FFFFFF">
    <div>
        <h1 style="text-align: left; font-size: 26px; padding-bottom: 15px">Manage Users</h1>
    </div>

    <div class="border border-secondary rounded bg-dark">
        <div style="padding: 10px">
            <table id="user-table" class="table hover table-bordered table-dark" style="width: 100%">
                <thead>
                <tr>
                    <th>USER ID</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>EMAIL</th>
                    <th>ACTIVE?</th>
                    <th>MANAGER?</th>
                    <th>ADMIN?</th>
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
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $('#user-table').DataTable();
    } );
</script>

</body>

</html>