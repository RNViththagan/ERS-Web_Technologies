<?php

include("../config/connect.php");

$query = "SELECT * FROM admin_details WHERE email = 'stud_admin1@nexus.com'";
$result = mysqli_query($con, $query);
$admin = mysqli_fetch_assoc($result);

$title = isset($admin["title"]) ? $admin["title"] : "";
$name = isset($admin["name"]) ? $admin["name"] : "";
$fullName = isset($admin["fullName"]) ? $admin["fullName"] : "";
$email = isset($admin["email"]) ? $admin["email"] : "";
$department = isset($admin["department"]) ? $admin["department"] : "";
$mobileNo = isset($admin["mobileNo"]) ? $admin["mobileNo"] : "";
$profile_img = isset($admin['profile_img']) ? $admin['profile_img'] : "blankProfile.png";

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <link rel = "stylesheet" type = "text/css" href = "../../assets/css/profile.css">
</head>
<body>

    <div class="hero">
        <nav>
            <img src="../img/panels/logo.png" class="logo">
            
            <div class = "user" >
                <p>Saarukesan. P</p>
                <img id = "user-pic" src="../img/panels/user.jpg" onclick="toggleMenu()">
                <img id = "down" src="../img/panels/down.png" onclick="toggleMenu()">
            </div>
 
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <a href="#" class="sub-menu-link">
                        <img src="../img/panels/dashboard.png">
                        <p>Dashboard</p>
                    </a>
                    <a href="admin_profile.php" class="sub-menu-link">
                        <img src="../img/panels/profile.png">
                        <p>Profile</p>
                    </a>
                    <a href="admin_student.php" class="sub-menu-link">
                        <img src="../img/panels/student.png">
                        <p>Student</p>
                    </a>
                    <hr>
                    <a href="#" class="sub-menu-link">
                        <img src="../img/panels/logout.png">
                        <p>Logout</p>
                    </a>
                </div>
                <div class="detail-row">
                    <h5>Full Name:</h5>
                    <p><?php echo "$fullName"; ?></p>
                </div>
                <div class="detail-row">
                    <h5>Department:</h5>
                    <p><?php echo $department; ?></p>
                </div>
                <div class="detail-row">
                    <h5>Mobile:</h5>
                    <p><?php echo $mobileNo; ?></p>
                </div>
                
                <div class="w-full flex items-center justify-around">
                    <a href="index.php?page=updateProfile" class="btn fill-btn mx-auto mt-5">Update Details</a>
                    <a href="index.php?page=pwdChg" class="btn fill-btn mx-auto mt-5">Change Password</a>
                </div>
                
            </div>
    </div>

</div>


