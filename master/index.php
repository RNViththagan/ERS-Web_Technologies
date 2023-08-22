<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "Admin_Master") {
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
    <title>Dashboard</title>
</head>
<body>
Welcome master  <br><?php echo $_SESSION['userid'] ?><br>
<a href="../logout.php">logout</a> <br>
<a href="add_admin.php">add Admin</a><br>
</body>
</html>