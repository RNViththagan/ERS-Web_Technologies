<?php
if(!isset($_SESSION)) session_start();

$get_name = "
    SELECT a.name, ad.title 
    FROM admin a 
    INNER JOIN admin_details ad 
    ON a.email = ad.email
    WHERE ad.email ='".$_SESSION['userid']."'";

$res = mysqli_query($con, $get_name)->fetch_assoc();
$userproftitle = $res['title'];
$userprofname = $res['name'];

?>
