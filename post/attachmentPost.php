<?php
require("../database.php");
$UserID = $_SESSION['userid'];
$referenceID = $_POST['referenceID'];
$file_name = $_POST['file_name'];
$target_dir = "../attachments/".$UserID."/";
$sql_dir = "/attachments/".$UserID."/".$file_name;

if(!file_exists($target_dir))
{
    mkdir($target_dir, 0700);
}
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        $stmt = $pdo->prepare('INSERT into attachments(attachmentURL, attachmentName, referenceID) values (:att,:attName, :referenceID)');
        $stmt->bindValue(':att', $sql_dir);
        $stmt->bindValue(':attName', $file_name);
        $stmt->bindValue('referenceID', $referenceID);
        $stmt->execute();
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>