<?php
ob_start();
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
    <title>ERS | Master Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/master.css" />
    <script
    src="https://kit.fontawesome.com/5ce4b972fd.js"
    crossorigin="anonymous"></script>
</head>
  
<body class="bg-gray-200">

<?php
    $rpath = "";
    require_once("navbar.php")
?>
  
<?php if (isset($_GET['error'])) { ?>
    <div class="exam-false fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
        <form class="card h-40 w-1/2 flex flex-col items-center justify-around gap-7" action="index.php" method="POST">
            <p class="text-center"><?php echo $_GET['error'] ?></p>
            <input class="btn fill-btn" type="submit" value="OK" name="ok">
        </form>
    </div>
<?php } elseif (isset($_GET['success'])) { ?>
    <div class="exam-false fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
        <form class="card h-40 w-1/2 flex flex-col items-center justify-around gap-7" action="index.php" method="POST">
            <p class="text-center text-green-700"><?php echo $_GET['success'] ?></p>
            <input class="btn fill-btn !bg-green-700" type="submit" value="OK" name="ok">
        </form>
    </div>
<?php } ?>


<div id="nextSibling" class="transition-all ml-[300px] h-screen flex items-center justify-center">
    <div class="card">
        <?php
          if (isset($_GET['page'])) {
              if ($_GET['page'] === "listAdmins") {
                  include("list_admins.php");
              }
              else if ($_GET['page'] === "viewAdmin") {
                 if(isset($_POST['adminId']))
                      include("viewAdmin.php");
                 else
                     header("Location:index.php?page=listAdmins");
              }
              else if ($_GET['page'] === "editAdmin") {
                  if (isset($_POST['editAdminId']))
                      include("editAdmin.php");
                  else
                      header("Location:index.php?page=listAdmins");
              }else if ($_GET['page'] === "pwdChg") {
                  include("../login/pwd_change_admin.php");
              }else if ($_GET['page'] === "addAdmin") {
                  include("add_admin.php");
              } else if ($_GET['page'] === "profile") {
                  include("profile.php");
              } else if ($_GET['page'] === "updateProfile") {
                  include("updateProfile.php");
              }  else
              include("admin_dashboard.php");

          } ?>
    </div>
</div>


</body>
</html>