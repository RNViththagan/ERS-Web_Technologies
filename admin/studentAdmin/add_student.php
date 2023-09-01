<?php
ob_start();
if (!isset($_SESSION['role'])) {
    header("location:../login.php");
    exit();
}


include("../config/connect.php");
if (isset($_POST['submit'])) {
    $email = strtolower($_POST['email']);
    $regno = strtoupper($_POST['regno']);

    // Check the name validation
    $regNoPattern = '/^\d{4}\/[A-Z]+\/\d{3}$/';
    if (!preg_match($regNoPattern, $regno)) {
        $msg[0] = "Invalid Registration No (XXXX/XXX/XXX)";
        $msg[1] = "warning";
    } else {
        $query = "SELECT * from student_check where regNo ='$regno' or email ='$email'";

        if (mysqli_num_rows(mysqli_query($con, $query))) {

            $msg[0] = "registration no or email already added!";
            $msg[1] = "warning";
        } else {
            $query = "INSERT INTO student_check (regNo,email) values('$regno','$email')";
            if (!mysqli_query($con, $query)) {

                $msg[0] = "error!";
                $msg[1] = "warning";
            } else {
                $query = "INSERT INTO student (regNo) values('$regno')";
                mysqli_query($con, $query);
                $msg[0] = "Successfully added!";
                $msg[1] = "done";
            }
        }
    }


}


?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<link rel="stylesheet" href="../../assets/css/main.css">
<h1 class="titlehead">Add Student</h1>
<div class="container">
    <form action="" method="post">
        <?php
        if (isset($msg)) {
            echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
        }
        ?>
        <div class="formcomp">
            <label for="regno">Registration No.: </label>
            <input type="text" name="regno" required>
        </div>
        <div class="formcomp">
            <label for="email">Email: </label>
            <input type="email" name="email" required>
        </div>
        <div class="formcomp formbutton">
            <input type="submit" name="submit" value="Register">
        </div>
    </form>
    <a href="../index.php">
        <button>Dashboard</button>
    </a>
</div>
