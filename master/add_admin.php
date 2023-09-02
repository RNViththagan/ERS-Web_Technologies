<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] != "Admin_Master") {
    header("location:../login.php");
    exit();
}


$errors =array();
if (isset($_POST['submit'])) {
    $email = strtolower($_POST['email']);
    $name = $_POST['name'];
    $password = $_POST["password"];
    // Check the Password validation
    if (strlen($_POST["password"]) <= '8') {
        $errors['password'] = "Your Password Must Contain At Least 8 Characters!";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $errors['password'] = "Your Password Must Contain At Least 1 Number!";
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $errors['password'] = "Your Password Must Contain At Least 1 Capital Letter!";
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $errors['password'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
    } elseif (!preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $password)) {
        $errors['password'] = "Your Password Must Contain At Least 1 Special Character !";
    }
    if (count($errors) === 0) {

        $query = "SELECT * from admin where email='$email'";

        if (mysqli_num_rows(mysqli_query($con, $query))) {

            $msg[0] = "Email already exists!";
            $msg[1] = "warning";
        } else {

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];

            $query = "INSERT INTO admin (email,password,role,name) values('$email','$password','$role','$name')";
            if (!mysqli_query($con, $query)) {

                $msg[0] = "error!";
                $msg[1] = "warning";
            } else {
                $query = "INSERT INTO admin_details (email) values('$email')";
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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
<h1 class="titlehead">Add admin</h1>
<div class="container">
    <form action="" method="post">
        <?php
        if (isset($msg)) {
            echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
        }
        ?>
        <?php
        if (isset($errors['password'])) {
            echo "<b>" . $errors['password'] . "</b>";
        }
        ?>

        <div class="formcomp">
            <label for="name">Name: </label>
            <input type="text" name="name" required>
        </div>
        <div class="formcomp">
            <label for="email">Email: </label>
            <input type="email" name="email" required>
        </div>
        <div class="formcomp">
            <label for="password">Password: </label>
            <input type="password" name="password" required>
        </div>
        <div class="formcomp">
            <label for="role">Role: </label>
            <select name="role">
                <option value="Admin_Subject">Admin_Subject</option>
                <option value="Admin_Student">Admin_Student</option>
            </select>
        </div>
        <div class="formcomp formbutton">
            <input type="submit" name="submit" value="Register">
        </div>
    </form>
    <a href="index.php?page=listAdmins">
        <button>Back</button>
    </a>

</div>
</body>

</html>