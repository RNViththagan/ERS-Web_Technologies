<?php
ob_start();
session_start();
if (isset($_SESSION['userid'])) {
    if (isset($_SESSION['role']))
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
    if($field == "admin")
        $username =strtolower($_POST['username']);
    else
        $username =strtoupper($_POST['username']);

    $sql = "select * from $table where $field = '" . $username . "' and status='active'";

    if ($result = mysqli_query($con, $sql)) {
        if ($result->num_rows) {
            if ($field != "email") {
                $sql = "select password from student_details where $field = '" . $username . "'";
                $result = mysqli_query($con, $sql);
                $obj = mysqli_fetch_assoc($result);
                if (password_verify($_POST['password'], $obj['password'])) {
                    $_SESSION['userid'] = $username;
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
                    $_SESSION['userid'] = $username;
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link
            rel="shortcut icon"
            href="img/logo/ERS_logo_icon.ico"
            type="image/x-icon"/>
    <title>ERS | Login</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/main.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
            src="https://kit.fontawesome.com/5ce4b972fd.js"
            crossorigin="anonymous"></script>
</head>

<body class="w-full h-full">
<div class="login-bg flex items-center justify-center"></div>
<div class="card h-[475px] w-10/12 absolute-center">
    <!-- Mobile n tab view design -->
    <div class="lg:hidden flex flex-col items-center">
        <img
                src="img/logo/ERS_logo.gif"
                alt="ERS_logo"
                class="w-28 align-middle"/>
        <h2 class="my-5 text-lg">Exam Registration System</h2>
        <h3 class="text-lg underline font-semibold text-gray-900 mb-3">
            Sign-In
        </h3>
        <form
                action=""
                method="post"
                class="flex flex-col items-center justify-around">
            <?php
            if (isset($msg)) {
                echo "<p class='text-sm w-[90%] text-justify mb-5 " . $msg[1] . "'>" . $msg[0] . "</p>";
            }
            ?>
            <div class="text-input">
                <i class="fa-solid fa-user"></i>
                <div></div>
                <input type="text" name="username" placeholder="UserName"/>
            </div>
            <div class="text-input">
                <i class="fa-solid fa-lock"></i>
                <div></div>
                <input type="password" name="password" placeholder="Password"/>
            </div>
            <input
                    type="submit"
                    name="submit"
                    value="Sign-In"
                    class="btn text-white bg-[var(--primary)] mt-5 formbutton"/>
        </form>
        <div class="text-center mt-7">
            <p>Don't have an account?</p>
            <a href="register.php" class="text-[var(--primary)] underline formbutton"
            >Sign-Up</a
            >
        </div>
    </div>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>
