<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != "Admin_Master") {
    header("location:../login.php");
    exit();
}
include("../config/connect.php");
require_once("../config/adminName.php");
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

    <link rel="stylesheet" type="text/css" href="../assets/css/style_index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
</head>
<body>

<div class="hero">
    <?php
    $rpath = "";
    require_once("navbar.php")
    ?>
</div>

<div class="card">
    <?php
    print_r($_POST);
    echo "<br>";
    print_r($_GET);
    if (isset($_GET['page'])) {
        if ($_GET['page'] === "listAdmins") {
            if(isset($_POST['adminId']))
                include("viewAdmin.php");
            else if(isset($_POST['editAdminId']))
                include("editAdmin.php");
            else
                include("list_admins.php");
        } else if ($_GET['page'] === "pwdChg") {
            include("../login/pwd_change_admin.php");
        }else if ($_GET['page'] === "addAdmin") {
                include("add_admin.php");
        } else
            include("admin_dashboard.php");
    } else
        include("admin_dashboard.php");

    ?>
</div>

<script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
        subMenu.classList.toggle("open-menu");
    }
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>
</html>