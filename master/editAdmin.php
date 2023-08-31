<?php

if (isset($_POST['editAdminId'])) {
    $adminId = $_POST['editAdminId'];
    $query = "SELECT *
FROM `admin` 
    LEFT JOIN `admin_details` ON `admin_details`.`email` = `admin`.`email` WHERE `admin`.`email` = '" . $adminId . "'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}





if (isset($_POST['save'])) {
    //$indexNo = $_POST["indexNo"];
    $regNo = $_POST["regNo"];
    $email = $_POST["email"];
    $fullName = $_POST["fullName"];
    $nameWithInitial = $_POST["nameWithInitial"];
    $district = $_POST["district"];
    $mobileNo = $_POST["mobileNo"];
    $landlineNo = $_POST["landlineNo"];
    $homeAddress = $_POST["homeAddress"];
    $addressInJaffna = $_POST["addressInJaffna"];
    // $subjectCombination = $_POST["subjectCombination"];

    $query = "UPDATE student INNER JOIN student_check ON student.regNo = student_check.regNo SET student_check.email = '$email', student.fullName = '$fullName', student.nameWithInitial = '$nameWithInitial', student.district = '$district', student.mobileNo = '$mobileNo', student.landlineNo = '$landlineNo', student.homeAddress = '$homeAddress', student.addressInJaffna = '$addressInJaffna' WHERE student.regNo = '".$regNo."'";
    $result = mysqli_query($con, $query);

    if ($result) {
        mysqli_close($con);
        echo '<body></body><script>
        function view(regNo) {
            var myform = document.createElement("form");
            myform.action = "admin_detail_student.php";
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
    view("'.$regNo.'");</script>';
        
    } else {
        echo "Connection Failed : " . mysqli_connect_error();
    }
}

?>









        
     
        <h1>Student Profile Setting</h1>

        <form method="post" action="">
            <table>
                <tr>
                    <td>Registration No:</td>
                    <td>
                        <input type="text" value="<?php echo $row['regNo']; ?>" disabled/>
                        <input type="hidden" name="regNo" value="<?php echo $row['regNo']; ?>"/>
                    </td>
                </tr>
                <!-- <tr>
                    <td>Index No:</td>
                    <td>
                        <input type="text" name="indexNo" value="<?php //echo $row['indexNo']; ?>" />
                    </td>
                </tr> -->
                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="text" name="email" value="<?php echo $row['email']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="fullName" value="<?php echo $row['fullName']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Name with Initials:</td>
                    <td>
                        <input type="text" name="nameWithInitial" value="<?php echo $row['nameWithInitial']; ?>" />
                    </td>
                </tr>
                <!-- <tr>
                    <td>Subject Combination:</td>
                    <td>
                        <input type="text" name="subjectCombination" value="<?php //echo $row['subjectCombination']; ?>" />
                    </td>
                </tr> -->
                <tr>
                    <td>District:</td>
                    <td>
                        <input type="text" name="district" value="<?php echo $row['district']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Mobile No:</td>
                    <td>
                        <input type="text" name="mobileNo" value="<?php echo $row['mobileNo']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Home Tp No:</td>
                    <td>
                        <input type="text" name="landlineNo" value="<?php echo $row['landlineNo']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Home Address:</td>
                    <td>
                        <input type="text" name="homeAddress" value="<?php echo $row['homeAddress']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Address in Jaffna:</td>
                    <td>
                        <input type="text" name="addressInJaffna" value="<?php echo $row['addressInJaffna']; ?>" />
                    </td>
                </tr>

            </table>

            <button type="submit" name="save" value="Save">Save</button>
            <button type="reset" name ="reset" value="Reset">Reset</button>
        </form>
<button onclick="view('<?php echo $row['email']; ?>')">Discard</button>



<script>
    function view(adminId) {
        var myform = document.createElement("form");
        myform.action = "";
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




