<?php
if(!isset($_SESSION)) session_start();
$get_name = "SELECT name
FROM admin
WHERE email ='".$_SESSION['userid']."'";
$res = mysqli_query($con, $get_name)->fetch_assoc();
$userprofname = $res['name'];

?>
