<?php
ob_start();
session_start();
require_once("../config/connect.php");
if (!isset($_SESSION['role']) || $_SESSION['role'] == "Admin_Master") {
    header("location:../login.php");
    exit();
}
require_once("../config/adminName.php");
require_once("subjectAdmin/assignUnits/currentExam.php");
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
    <?php
    $rpath = "";
    require_once("navbar.php")
    ?>

</div>

<div class = "card">
    <?php
//    print_r($_POST);
//    echo "<br>";
//    print_r($_GET);
    if ($_SESSION['role'] == "Admin_Student") {
        if(isset($_GET['page'])){
            if($_GET['page'] === "stud"){
                include("studentAdmin/admin_student.php");
            }
            else if($_GET['page'] === "viewStud"){
                if(isset($_POST['regNo']))
                    include("studentAdmin/admin_detail_student.php");
                else
                    header("Location:index.php?page=stud");
            }
            else if($_GET['page'] === "editStud"){
                if(isset($_POST['regNo']))
                    include("studentAdmin/admin_edit_student.php");
                else
                    header("Location:index.php?page=stud");
            }
            else if($_GET['page'] === "addStud"){
                include("studentAdmin/add_student.php");
            }
            else
                include("studentAdmin/stud_admin_dashboard.php");
        }
        else
            include("studentAdmin/stud_admin_dashboard.php");
    }elseif ($_SESSION['role'] == "Admin_Subject")
        if(isset($_GET['page'])){
            if($_GET['page'] === "subComb"){
                include("subjectAdmin/subject_combination.php");
            }
            else if($_GET['page'] === "units"){
                include("subjectAdmin/unit.php");
            }
            else if($_GET['page'] === "addUnit"){
                include("subjectAdmin/add_unit.php");
            }
            else if($_GET['page'] === "asignUnits" && isset($curExam)){
                include("subjectAdmin/assignUnits/assignUnits.php");
            }

            else
                include("subjectAdmin/subj_admin_dashboard.php");
        }
        else
            include("subjectAdmin/subj_admin_dashboard.php");
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