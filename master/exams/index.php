<?php
ob_start();
if(!isset($_SESSION)){session_start();}
require($_SERVER['DOCUMENT_ROOT'] . '/config/connect.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] != "Admin_Master") {
    header("location:../../login.php");
    exit();
}

include("../../config/connect.php");
require_once ("../adminName.php");
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
            href="../../assets/img/logo/ERS_logo_icon.ico"
            type="image/x-icon"/>
    <title>ERS | Admin</title>

    <link rel="stylesheet" type="text/css" href="../../assets/css/style_index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
</head>
<body>

<div class="hero">
    <nav>
        <img src="../../assets/img/panels/logo.png" class="logo">

        <div class="user">
            <p><?php echo $userprofname?></p>
            <svg class="user-pic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 44" onclick="toggleMenu()">
                <ellipse cx="22.924" cy="22" rx="22.924" ry="22" fill="white"/>
                <path d="M22.9242 22.1692C24.9552 22.1692 26.9031 21.3758 28.3393 19.9635C29.7755 18.5512 30.5823 16.6357 30.5823 14.6385C30.5823 12.6412 29.7755 10.7257 28.3393 9.31341C26.9031 7.90111 24.9552 7.1077 22.9242 7.1077C20.8931 7.1077 18.9452 7.90111 17.5091 9.31341C16.0729 10.7257 15.2661 12.6412 15.2661 14.6385C15.2661 16.6357 16.0729 18.5512 17.5091 19.9635C18.9452 21.3758 20.8931 22.1692 22.9242 22.1692ZM20.19 24.9933C14.2968 24.9933 9.52246 29.6882 9.52246 35.4834C9.52246 36.4483 10.3182 37.2308 11.2994 37.2308H34.549C35.5302 37.2308 36.3259 36.4483 36.3259 35.4834C36.3259 29.6882 31.5515 24.9933 25.6584 24.9933H20.19Z"
                      fill="black"/>
            </svg>
            <img src="../../assets/img/panels/down.png" onclick="toggleMenu()">
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

                <a href="../" class="sub-menu-link">
                    <img src="../../assets/img/panels/dashboard.png">
                    <p>Dashboard</p>
                    <!-- <span>></span> -->
                </a>
                <a href="#" class="sub-menu-link">
                    <img src="../../assets/img/panels/profile.png">
                    <p>Profile</p>
                    <!-- <span>></span> -->
                </a>
                <a href="index.php" class="sub-menu-link">
                    <img src="../../assets/img/panels/student.png">
                    <p>Exams</p>
                    <!-- <span>></span> -->
                </a>
                <a href="../index.php?page=addAdmin" class="sub-menu-link">
                    <img src="../../assets/img/panels/profile.png">
                    <p>Add Admin</p>
                    <!-- <span>></span> -->
                </a>
                <hr>
                <a href="../../logout.php" class="sub-menu-link">
                    <img src="../../assets/img/panels/logout.png">
                    <p>Logout</p>
                    <!-- <span>></span> -->
                </a>
            </div>
        </div>
    </nav>
</div>

<div class="card">
    <?php
    $error =array();
    if (isset($_GET['page'])) {
        if ($_GET['page'] == "add") {
            include("exam_edit.php");
        }
        if ($_GET['page'] == "edit") {
            include("exam_edit.php");
        }

    } else if (isset($_POST['ed_exm'])) {
        $exam_id = $_POST['exam_id'];
        $status = $_POST['status'];
        $close_date = $_POST['close_date'];
        $update_exm = "UPDATE `exam_reg` SET `status` = '$status', `closing_date` = '$close_date' WHERE exam_id = '$exam_id'";
        $run_sql = mysqli_query($con, $update_exm);
        if (!$run_sql) {
            echo "<h1>error </h1>" . $con->error;
            include("exam_edit.php");
        } else
            include "exam_mgmt.php";


    } else if (isset($_POST['add_exm'])) {
        $acYear = intval($_POST['academic_year']);
        $semester = intval($_POST['semester']);
        $status = $_POST['status'];
        $close_date = $_POST['close_date'];
        $cur_date =date("Y-m-d");
        $add_exam = "INSERT INTO `exam_reg` (`academic_year`, `semester`, `status`, `closing_date`, `date_created`) 
                VALUES ('$acYear', '$semester', 'draft', '$close_date','$cur_date')";

        try {
            $run_sql = mysqli_query($con, $add_exam);
            include "exam_mgmt.php";
        } catch (Exception $e) {
            $error['add error']  ="Exam cannot be added!";
            include("exam_mgmt.php");
        }


    } else {
        include "exam_mgmt.php";
    }
    ?>
</div>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
        subMenu.classList.toggle("open-menu");
    }
</script>


</body>
</html>


