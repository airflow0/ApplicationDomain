<?php

require('admin_navigation.php');
require('database.php');
$f_display = $l_display = $d_display = $a_display =  $picture = "";
$clientID = $_SESSION['userid'];

$stmt = $pdo->prepare('SELECT firstname, lastname, dateofbirth, address, picture_directory FROM account WHERE id=:id');
$stmt->bindValue(":id", $clientID);
$stmt->execute();
$userinfo = $stmt->fetch(PDO::FETCH_ASSOC);

$f_display = $userinfo['firstname'];
$l_display = $userinfo['lastname'];
$d_display = $userinfo['dateofbirth'];
$a_display = $userinfo['address'];
$picture = $userinfo['picture_directory'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<script>
    $(function () {
        $("#upload_link").on('click', function (e) {
            e.preventDefault();
            $("#upload:hidden").trigger('click');
        });
    });
</script>
<div class="d-inline-flex p-2 ">
    <div class="profilecontainer">
        <div class="profilepic">
            <img src="<?php echo $picture ?>"/>
            <p>a</p>
            <div class="layer">
            </div>
            <form action="upload" method="post" enctype="multipart/form-data">
                <input id="upload" type="file" name="fileToUpload" onchange="this.form.submit()"/>
                <a href="" id="upload_link">
                    <div class="wrapimage">
                        <label class="edit glyphicon glyphicon-pencil" for="changePicture" type="file" title="Change picture" style="color:white;">Edit</label>
                    </div>
                </a>
            </form>
        </div>
        <div class="profile_info">
            <div class="profile_info_name"> @<?php echo $f_display ?>  <?php print' '.$l_display ?></div>
        </div>
    </div>
</div>
</body>
</html>