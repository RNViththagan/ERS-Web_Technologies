<?php
$msg = array();
require_once("../config/connect.php");
$pwdUser = $_SESSION['userid'];
if (isset($_POST['chg-pwd'])) {
// Get user input from the form
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

// Validate new password and confirm password
    if ($newPassword !== $confirmNewPassword) {
        $msg['error'] = "Error: New password and confirm new password do not match.";
    }
    if (strlen($newPassword) <= '8') {
        $msg['error'] = "Your Password Must Contain At Least 8 Characters!";
    } elseif (!preg_match("#[0-9]+#", $newPassword)) {
        $msg['error'] = "Your Password Must Contain At Least 1 Number!";
    } elseif (!preg_match("#[A-Z]+#", $newPassword)) {
        $msg['error'] = "Your Password Must Contain At Least 1 Capital Letter!";
    } elseif (!preg_match("#[a-z]+#", $newPassword)) {
        $msg['error'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
    } elseif (!preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $newPassword)) {
        $msg['error'] = "Your Password Must Contain At Least 1 Special Character !";
    }
    if(count($msg) == 0) {
// Check if the current password is correct for the user
        $sql = "SELECT password FROM admin WHERE email = '" . $pwdUser . "';";
        $result = $con->query($sql);


        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['password'];

            // Simulated password validation (replace with your actual password validation logic)
            if (password_verify($currentPassword, $storedPassword)) {
                // Hash the new password before storing it
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $updateSql = "UPDATE admin SET password = '$hashedPassword' WHERE email = '$pwdUser'";

                if ($con->query($updateSql) === TRUE) {
                    $msg['info'] = "Password changed successfully!";
                } else {
                    $msg['error'] = "Error updating password: " . $con->error;
                }
            } else {
                $msg['error'] = "Incorrect current password.";
            }
        }
    }
} ?>


<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f0f0f0;
    }

    .password-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        width: 300px;
    }

    .password-form h2 {
        margin-top: 0;
    }

    .password-form label {
        display: block;
        margin-bottom: 8px;
    }

    .password-form input {
        width: 100%;
        padding: 8px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .password-form button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 16px;
        border-radius: 3px;
        cursor: pointer;
    }

    .password-form button:hover {
        background-color: #0056b3;
    }

    .msg {
        margin-top: 10px;
        padding: 10px;
        border-radius: 3px;
    }

    .error-msg {
        background-color: #ffdddd;
        color: #ff0000;
    }

    .info-msg {
        background-color: #ddffdd;
        color: #00aa00;
    }
</style>


<div class="password-form">
    <h2>Change Password</h2>
    <?php if (isset($msg['error'])) : ?>
        <div class="msg error-msg"><?php echo $msg['error']; ?></div>
    <?php endif; ?>

    <?php if (isset($msg['info'])) : ?>
        <div class="msg info-msg"><?php echo $msg['info']; ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <label for="currentPassword">Current Password:</label>
        <input type="password" id="currentPassword" name="currentPassword" required>

        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>

        <label for="confirmNewPassword">Confirm New Password:</label>
        <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>

        <button type="submit" name="chg-pwd">Change Password</button>
    </form>
</div>

