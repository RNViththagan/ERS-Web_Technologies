<?php
ob_start();
session_start();
print_r($_SESSION);
include("connect.php");
$sql = "select role from admin where email = '" . $_SESSION['userid'] . "'";
if ($result = mysqli_query($con, $sql)) {
    $obj = mysqli_fetch_assoc($result);
    $_SESSION['role'] = $obj['role'];
    if ($obj['role'] == "Admin_Master"){
        header("Location:master");
        exit;
    }
    else{
        header("Location:admin");
        exit;
    }

}
?>
