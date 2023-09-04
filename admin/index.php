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
require_once("../config/postSender.php");
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

    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/admin.css" />
    <script
    src="https://kit.fontawesome.com/5ce4b972fd.js"
    crossorigin="anonymous"></script>
</head>


<body class="bg-gray-200">

<!-- Header nav-bar -->
<?php
    $rpath = "";
    require_once("navbar.php");
?>

<!-- error or info msgs display -->
<?php if (isset($_GET['error'])) { ?>
    <div class="exam-false fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
        <form class="card h-40 w-1/2 flex flex-col items-center justify-around gap-7" action="index.php<?php echo (isset($_GET['page']))?"?page=".$_GET['page']:""?>" method="POST">
            <p class="text-center"><?php echo $_GET['error'] ?></p>
            <input class="btn fill-btn" type="submit" value="OK" name="ok">
        </form>
    </div>
<?php } elseif (isset($_GET['success'])) { ?>
    <div class="exam-false fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
        <form class="card h-40 w-1/2 flex flex-col items-center justify-around gap-7" action="index.php<?php echo (isset($_GET['page']))?"?page=".$_GET['page']:""?>" method="POST">
            <p class="text-center text-green-700"><?php echo $_GET['success'] ?></p>
            <input class="btn fill-btn !bg-green-700" type="submit" value="OK" name="ok">
        </form>
    </div>
<?php } ?>


<!-- Content body -->
<div id="nextSibling" class="transition-all ml-[300px] h-screen flex items-center justify-center">
    <div class = "card">
        <?php
//        print_r($_POST);
//        echo "<br>";
//        print_r($_GET);
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
                } else if ($_GET['page'] === "profile") {
                    include("../config/profile.php");
                } else if ($_GET['page'] === "pwdChg") {
                    include("../login/pwd_change_admin.php");
                } else if ($_GET['page'] === "updateProfile") {
                    include("../config/updateProfile.php");
                } else if($_GET['page'] === "editStud"){
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
                } else if($_GET['page'] === "editUnit"){
                    if(isset($_POST['unitId']))
                        include("subjectAdmin/unit_edit.php");
                    else
                        header("Location:index.php?page=units");
                } else if ($_GET['page'] === "profile") {
                    include("../config/profile.php");
                } else if ($_GET['page'] === "pwdChg") {
                    include("../login/pwd_change_admin.php");
                } else if ($_GET['page'] === "updateProfile") {
                    include("../config/updateProfile.php");
                }else if($_GET['page'] === "asignUnits" && isset($curExam)){
                    include("subjectAdmin/assignUnits/assignUnits.php");
                }

                else
                    include("subjectAdmin/subj_admin_dashboard.php");
            }
            else
                include("subjectAdmin/subj_admin_dashboard.php");
        ?>
    </div>
</div>



</body>
</html>