<?php
session_start();
if(isset($_SESSION['userid'])){
    if(isset($_SESSION['role']))
        header("location:admin_select.php");
    else
        header("location:index.php");
}

include("connect.php");
if (isset($_POST['submit'])) {
    if (str_contains($_POST['username'], '@')) {
        login("admin", "email");
    } else {
        login("student", "reg_no");
    }
}

function login($table, $field)
{
    $con = $GLOBALS['con'];
    $sql = "select * from $table where $field = '" . $_POST['username'] . "' and status='active'";

    if ($result = mysqli_query($con, $sql)) {
        if ($result->num_rows) {
            if ($field != "email") {
                $sql = "select password from student_details where $field = '" . $_POST['username'] . "'";
                $result = mysqli_query($con, $sql);
                $obj = mysqli_fetch_assoc($result);
                if (password_verify($_POST['password'], $obj['password'])) {
                    $_SESSION['userid'] = $_POST['username'];
                    header("location:index.php");
                    exit();
                } else {
                    $GLOBALS['msg'][0] = "Password is wrong!";
                    $GLOBALS['msg'][1] = "warning";
                }

            } else {
                $obj = mysqli_fetch_assoc($result);
                if (password_verify($_POST['password'], $obj['password'])) {
                    session_start();
                    $_SESSION['userid'] = $_POST['username'];
                    header("location:admin_select.php");
                    exit();
                } else {
                    $GLOBALS['msg'][0] = "Password is wrong!";
                    $GLOBALS['msg'][1] = "warning";
                }
            }

        } else {
            $GLOBALS['msg'][0] = "User Not found!";
            $GLOBALS['msg'][1] = "warning";
        }
    } else
        echo "connection error" . mysqli_error($con);
}


?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
<h1 class="titlehead">Login</h1>

<div class="container">
    <form action="" method="post">
        <?php
        if (isset($msg)) {
            echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
        }
        ?>
        <div class="formcomp">
            <label for="username">User Name</label>
            <input type="text" name="username" required>
        </div>
        <div class="formcomp">
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="formcomp formbutton">
            <input type="submit" name="submit" value="Login">
        </div>
    </form>
    <a href="master/add_admin.php">
        <button>Sign Up</button>
    </a>
</div>

</body>

</html>