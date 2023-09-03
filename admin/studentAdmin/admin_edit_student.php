<script>
    function view(regNo) {
        var myform = document.createElement("form");
        myform.action = "index.php?page=viewStud";
        myform.method = "post";
        var inp = document.createElement("input");
        inp.name = "regNo";
        inp.value = regNo;
        inp.type = "hidden";
        myform.appendChild(inp);
        document.body.appendChild(myform);
        console.log(myform);
        myform.submit()
    }
</script>
<?php
$msg=array();

if (isset($_POST['regNo'])) {
    $regNo = $_POST['regNo'];
    $query = "SELECT * FROM student INNER JOIN student_check ON student.regNo = student_check.regNo WHERE student.regNo = '" . $regNo . "'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}


if (isset($_POST['save'])) {
    $newRegNo = $_POST["newRegNo"];
    $regNo = $_POST["regNo"];
    if($newRegNo != $regNo) {
        $test_new_regNo = $query = "SELECT * FROM student_check WHERE regNo = '" . $newRegNo . "'";
        $check_res = mysqli_query($con, $test_new_regNo);
        if ($check_res->num_rows !=0) {
            $msg['error'] = "Registration No already exists!";
        }
    }
    if(count($msg) == 0) {
        $status = $_POST['status'];
        $email = $_POST["email"];
        $fullName = $_POST["fullName"];
        $nameWithInitial = $_POST["nameWithInitial"];
        $district = $_POST["district"];
        $mobileNo = $_POST["mobileNo"];
        $landlineNo = $_POST["landlineNo"];
        $homeAddress = $_POST["homeAddress"];
        $addressInJaffna = $_POST["addressInJaffna"];

        $query = "UPDATE student INNER JOIN student_check ON student.regNo = student_check.regNo SET student_check.regNo = '$newRegNo', student_check.email = '$email', student_check.status = '$status', student.fullName = '$fullName', student.nameWithInitial = '$nameWithInitial', student.district = '$district', student.mobileNo = '$mobileNo', student.landlineNo = '$landlineNo', student.homeAddress = '$homeAddress', student.addressInJaffna = '$addressInJaffna' WHERE student.regNo = '" . $regNo . "'";
        $result = mysqli_query($con, $query);

        if ($result) {
            mysqli_close($con);
            echo '<script>        
    view("' . $newRegNo . '");</script>';

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


<div class="w-full mx-auto flex flex-col items-center gap-4">
    <h1 class="title">Edit student Profile</h1>
    <?php if (isset($msg['error'])) : ?>
        <div class="msg error-msg"><?php echo $msg['error']; ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <table>
            <tr>
                <td>Registration No:</td>
                <td>
                    <input type="text" name="newRegNo" value="<?php echo $row['regNo']; ?>"/>
                    <input type="hidden" name="regNo" value="<?php echo $row['regNo']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <select for="status" name="status">
                        <option value="unregistered" <?php echo ("unregistered" == $row['status']) ? "selected" : ""; ?>>unregistered</option>
                        <option value="active" <?php echo ("active" == $row['status']) ? "selected" : ""; ?>>active</option>
                        <option value="inactive" <?php echo ("inactive" == $row['status']) ? "selected" : ""; ?>>inactive</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>
                    <input type="text" name="email" value="<?php echo $row['email']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="fullName" value="<?php echo $row['fullName']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Name with Initials:</td>
                <td>
                    <input type="text" name="nameWithInitial" value="<?php echo $row['nameWithInitial']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>District:</td>
                <td>
                    <input type="text" name="district" value="<?php echo $row['district']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Mobile No:</td>
                <td>
                    <input type="text" name="mobileNo" value="<?php echo $row['mobileNo']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Home Tp No:</td>
                <td>
                    <input type="text" name="landlineNo" value="<?php echo $row['landlineNo']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Home Address:</td>
                <td>
                    <input type="text" name="homeAddress" value="<?php echo $row['homeAddress']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Address in Jaffna:</td>
                <td>
                    <input type="text" name="addressInJaffna" value="<?php echo $row['addressInJaffna']; ?>"/>
                </td>
            </tr>
    
        </table>
    
        <div class="w-full grid grid-cols-3 items-center h-10 gap-5 mt-5 mb-10">
            <button type="submit" name="save" value="Save">Save</button>
            <button type="reset" name="reset" value="Reset">Reset</button>
            <button onclick="view('<?php echo $row['regNo']; ?>')">Discard</button>
        </div>
    </form>
</div>




<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>