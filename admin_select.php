<?php
session_start();
print_r($_SESSION);
include("connect.php");
$sql = "select role from admin where email = '" . $_SESSION['userid'] . "'";

if ($result = mysqli_query($con, $sql)) {
    $obj = mysqli_fetch_assoc($result);
    $_SESSION['role'] = $obj['role'];
    if ($obj['role'] == "Admin_Master"){
        echo "goto master";
        header("location:master/index.php");
    }
    else
        header("location:admin/index.php");
    exit();

}
?>
