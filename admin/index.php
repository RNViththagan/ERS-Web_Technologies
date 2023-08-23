<?php
session_start();

if (!isset($_SESSION['role'])) {

    header("location:../login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
            rel="shortcut icon"
            href="../assets/img/logo/ERS_logo_icon.ico"
            type="image/x-icon"/>
    <title>ERS | Admin</title>

    <link rel = "stylesheet" type = "text/css" href = "../assets/css/style_index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
</head>
<body>

    <div class="hero">
        <nav>
            <img src="../assets/img/panels/logo.png" class="logo">

            <div class = "user" >
                <p>Saarukesan. P</p>
                <svg class="user-pic" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 46 44"  onclick="toggleMenu()">
                    <ellipse cx="22.924" cy="22" rx="22.924" ry="22" fill="white"/>
                    <path d="M22.9242 22.1692C24.9552 22.1692 26.9031 21.3758 28.3393 19.9635C29.7755 18.5512 30.5823 16.6357 30.5823 14.6385C30.5823 12.6412 29.7755 10.7257 28.3393 9.31341C26.9031 7.90111 24.9552 7.1077 22.9242 7.1077C20.8931 7.1077 18.9452 7.90111 17.5091 9.31341C16.0729 10.7257 15.2661 12.6412 15.2661 14.6385C15.2661 16.6357 16.0729 18.5512 17.5091 19.9635C18.9452 21.3758 20.8931 22.1692 22.9242 22.1692ZM20.19 24.9933C14.2968 24.9933 9.52246 29.6882 9.52246 35.4834C9.52246 36.4483 10.3182 37.2308 11.2994 37.2308H34.549C35.5302 37.2308 36.3259 36.4483 36.3259 35.4834C36.3259 29.6882 31.5515 24.9933 25.6584 24.9933H20.19Z" fill="black"/>
                </svg>
                <img src="../assets/img/panels/down.png" onclick="toggleMenu()">
            </div>

            <!-- <img src="../img/panels/user.png" class="user-pic" onclick="toggleMenu()"> -->
 
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <!-- <div class="user-info">
                        <svg class="user-pic" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 46 44"  onclick="toggleMenu()">
                            <ellipse cx="22.924" cy="22" rx="22.924" ry="22" fill="white"/>
                            <path d="M22.9242 22.1692C24.9552 22.1692 26.9031 21.3758 28.3393 19.9635C29.7755 18.5512 30.5823 16.6357 30.5823 14.6385C30.5823 12.6412 29.7755 10.7257 28.3393 9.31341C26.9031 7.90111 24.9552 7.1077 22.9242 7.1077C20.8931 7.1077 18.9452 7.90111 17.5091 9.31341C16.0729 10.7257 15.2661 12.6412 15.2661 14.6385C15.2661 16.6357 16.0729 18.5512 17.5091 19.9635C18.9452 21.3758 20.8931 22.1692 22.9242 22.1692ZM20.19 24.9933C14.2968 24.9933 9.52246 29.6882 9.52246 35.4834C9.52246 36.4483 10.3182 37.2308 11.2994 37.2308H34.549C35.5302 37.2308 36.3259 36.4483 36.3259 35.4834C36.3259 29.6882 31.5515 24.9933 25.6584 24.9933H20.19Z" fill="black"/>
                        </svg>
                        <h2>James Aldrino</h2>
                    </div>
                    <hr> -->

                    <a href="../admin" class="sub-menu-link">
                        <img src="../assets/img/panels/dashboard.png">
                        <p>Dashboard</p>
                        <!-- <span>></span> -->
                    </a>
                    <a href="#" class="sub-menu-link">
                        <img src="../assets/img/panels/profile.png">
                        <p>Profile</p>
                        <!-- <span>></span> -->
                    </a>
                    <?php if ($_SESSION['role'] == "Admin_Student") {?>
                    <a href="index.php?page=addstd" class="sub-menu-link">
                        <img src="../assets/img/panels/student.png">
                        <p>Student</p>
                        <!-- <span>></span> -->
                    </a>
                    <?php } ?>
                    <?php if ($_SESSION['role'] == "Admin_Subject") {?>
                    <a href="index.php?page=subcomb" class="sub-menu-link">
                        <img src="../assets/img/panels/profile.png">
                        <p>Subject combination</p>
                        <!-- <span>></span> -->
                    </a>
                    <?php } ?>
                    <hr>
                    <a href="../logout.php" class="sub-menu-link">
                        <img src="../assets/img/panels/logout.png">
                        <p>Logout</p>
                        <!-- <span>></span> -->
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <div class = "card">
        <?php
        if ($_SESSION['role'] == "Admin_Student") {
            if(isset($_GET['page'])){
                if($_GET['page'] === "addstd"){
                    include("add_student.php");
                }
                else
                    include("subj_admin_dashboard.php");
            }
            else
                include("stud_admin_dashboard.php");
        }elseif ($_SESSION['role'] == "Admin_Subject")
            if(isset($_GET['page'])){
                if($_GET['page'] === "subcomb"){
                    include("subject_combination.php");
                }
                else
                    include("subj_admin_dashboard.php");
            }
            else
                include("subj_admin_dashboard.php");
        ?>
    </div>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script>
    


</body>
</html>