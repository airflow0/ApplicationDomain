<?php
require('database.php');
session_start();
$UserID = $_SESSION['userid'];
echo $UserID;
$target_dir = "uploads/".$UserID."/";
if(!file_exists($target_dir))
{
    mkdir($target_dir, 0700);
}
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);



$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $stmt=$pdo->prepare("UPDATE account SET picture_directory=:picture WHERE id=:id");
        $stmt->bindValue(":picture", $target_file);
        $stmt->bindValue(":id", $UserID);
        $stmt->execute();
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
if($_SESSION['isAdmin'] || $_SESSION['isManager'])
{
    header ('Location: admin_cp');
    exit;
}
else
{
    header ('Location: dashboard');
    exit;
}
?>