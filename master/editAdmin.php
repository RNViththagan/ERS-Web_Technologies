<script>
    function view(adminId) {
        var myform = document.createElement("form");
        myform.action = "index.php?page=viewAdmin";
        myform.method = "post";
        var inp = document.createElement('input');
        inp.name = "adminId";
        inp.value = adminId;
        inp.type = "hidden";
        myform.appendChild(inp);
        document.body.appendChild(myform);
        console.log(myform);
        myform.submit()
    }
</script>
<?php
$msg = array();
if (isset($_POST['editAdminId'])) {
    $adminId = $_POST['editAdminId'];
    $query = "SELECT *
FROM `admin` 
    LEFT JOIN `admin_details` ON `admin_details`.`email` = `admin`.`email` WHERE `admin`.`email` = '" . $adminId . "'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}


if (isset($_POST['save'])) {
    $newEmail = $_POST["newEmail"];
    $email = $_POST["editAdminId"];
    if ($newEmail != $email) {
        $test_new_regNo = $query = "SELECT * FROM admin WHERE email = '" . $newEmail . "'";
        $check_res = mysqli_query($con, $test_new_regNo);
        if ($check_res->num_rows != 0) {
            $msg['error'] = "Email is already exists!";
        }
    }
    if (count($msg) == 0) {
        $name = $_POST["name"];
        $fullName = $_POST["fullName"];
        $role = $_POST["role"];
        $status = $_POST["status"];
        $mobileNo = ($_POST["mobileNo"] == "") ? 'NULL' : $_POST["mobileNo"];
        $department = $_POST["department"];

        $query = "UPDATE admin_details INNER JOIN admin ON admin_details.email = admin.email  
    SET admin.email = '$newEmail', admin.name = '$name', admin.role = '$role', admin.status = '$status', admin_details.fullName = '$fullName', admin_details.mobileNo = $mobileNo , admin_details.department = '$department' 
    WHERE admin.email = '" . $email . "'";
        $result = mysqli_query($con, $query);
        if ($result) {
            echo '<script>view("' . $newEmail . '");</script>';
            exit;
        } else {
            echo "Connection Failed : " . mysqli_connect_error();
        }
    }
}

?>


<style>
    .msg {
        margin-top: 10px;
        padding: 10px;
        border-radius: 3px;
    }

    .error-msg {
        background-color: #ffdddd;
        color: #ff0000;
    }
</style>

<link rel="stylesheet" type="text/css" href="../../assets/css/style_admin_student.css">


<?php if (isset($msg['error'])) : ?>
    <div class="msg error-msg"><?php echo $msg['error']; ?></div>
<?php endif; ?>


<h1>edit Admin Profile </h1>

<form method="post" action="">
    <input type="hidden" name="editAdminId" value="<?php echo $row['adminId']; ?>"/>

    <table>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="newEmail" value="<?php echo $row['email']; ?>"/>
                <input type="hidden" name="editAdminId" value="<?php echo $row['email']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>Role:</td>
            <td>
                <select for="role" name="role">
                    <option value="Admin_Student" <?php echo ("Admin_Student" == $row['role']) ? "selected" : ""; ?>>
                        Admin Student
                    </option>
                    <option value="Admin_Subject" <?php echo ("Admin_Subject" == $row['role']) ? "selected" : ""; ?>>
                        Admin Subject
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>
                <select for="status" name="status">
                    <option value="active" <?php echo ("active" == $row['status']) ? "selected" : ""; ?>>
                        active
                    </option>
                    <option value="inactive" <?php echo ("inactive" == $row['status']) ? "selected" : ""; ?>>
                        inactive
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Name:</td>
            <td>
                <input type="text" name="name" value="<?php echo $row['name']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>Full Name:</td>
            <td>
                <input type="text" name="fullName" value="<?php echo $row['fullName']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>Department:</td>
            <td>
                <input type="text" name="department" value="<?php echo $row['department']; ?>"/>
            </td>
        </tr>


        <tr>
            <td>Mobile No:</td>
            <td>
                <input type="text" name="mobileNo" value="<?php echo $row['mobileNo']; ?>"/>
            </td>
        </tr>

    </table>

    <button type="submit" name="save" value="Save">Save</button>
    <button type="reset" name="reset" value="Reset">Reset</button>
</form>
<button onclick="view('<?php echo $row['email']; ?>')">Discard</button>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>