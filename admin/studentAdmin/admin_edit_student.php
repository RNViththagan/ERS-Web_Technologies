<?php
include("connect.php");

if (isset($_POST['regNo'])) {
    $regNo = $_POST['regNo'];
    $query = "SELECT * FROM student INNER JOIN student_check ON student.regNo = student_check.regNo WHERE student.regNo = '".$regNo."'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}





if (isset($_POST['save'])) {
    $newRegNo = $_POST["newRegNo"];
    $regNo = $_POST["regNo"];
    $status = $_POST['status'];
    $email = $_POST["email"];
    $fullName = $_POST["fullName"];
    $nameWithInitial = $_POST["nameWithInitial"];
    $district = $_POST["district"];
    $mobileNo = $_POST["mobileNo"];
    $landlineNo = $_POST["landlineNo"];
    $homeAddress = $_POST["homeAddress"];
    $addressInJaffna = $_POST["addressInJaffna"];

    $query = "UPDATE student INNER JOIN student_check ON student.regNo = student_check.regNo SET student_check.regNo = '$newRegNo', student_check.email = '$email', student_check.status = '$status', student.fullName = '$fullName', student.nameWithInitial = '$nameWithInitial', student.district = '$district', student.mobileNo = '$mobileNo', student.landlineNo = '$landlineNo', student.homeAddress = '$homeAddress', student.addressInJaffna = '$addressInJaffna' WHERE student.regNo = '".$regNo."'";
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
    view("'.$newRegNo.'");</script>';
        
    } else {
        echo "Connection Failed : " . mysqli_connect_error();
    }
}

?>









<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <link rel="stylesheet" type="text/css" href="../../assets/css/style_admin_student.css">
</head>

<body>

    <div class="hero">
        <nav>
            <img src="../img/panels/logo.png" class="logo">

            <div class="user">
                <p>Saarukesan. P</p>
                <svg class="user-pic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 44" onclick="toggleMenu()">
                    <ellipse cx="22.924" cy="22" rx="22.924" ry="22" fill="white" />
                    <path d="M22.9242 22.1692C24.9552 22.1692 26.9031 21.3758 28.3393 19.9635C29.7755 18.5512 30.5823 16.6357 30.5823 14.6385C30.5823 12.6412 29.7755 10.7257 28.3393 9.31341C26.9031 7.90111 24.9552 7.1077 22.9242 7.1077C20.8931 7.1077 18.9452 7.90111 17.5091 9.31341C16.0729 10.7257 15.2661 12.6412 15.2661 14.6385C15.2661 16.6357 16.0729 18.5512 17.5091 19.9635C18.9452 21.3758 20.8931 22.1692 22.9242 22.1692ZM20.19 24.9933C14.2968 24.9933 9.52246 29.6882 9.52246 35.4834C9.52246 36.4483 10.3182 37.2308 11.2994 37.2308H34.549C35.5302 37.2308 36.3259 36.4483 36.3259 35.4834C36.3259 29.6882 31.5515 24.9933 25.6584 24.9933H20.19Z" fill="black" />
                </svg>
                <img src="../img/panels/down.png" onclick="toggleMenu()">
            </div>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <a href="#" class="sub-menu-link">
                        <img src="../img/panels/dashboard.png">
                        <p>Dashboard</p>
                    </a>
                    <a href="admin_profile.php" class="sub-menu-link">
                        <img src="../img/panels/profile.png">
                        <p>Profile</p>
                    </a>
                    <a href="admin_student.php" class="sub-menu-link">
                        <img src="../img/panels/student.png">
                        <p>Student</p>
                    </a>
                    <hr>
                    <a href="#" class="sub-menu-link">
                        <img src="../img/panels/logout.png">
                        <p>Logout</p>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    

    <div class="card">
        
     
        <h1>Student Profile Setting</h1>

        <form method="post" action="">
            <table>
                <tr>
                    <td>Registration No:</td>
                    <td>
                        <input type="text" name="newRegNo" value="<?php echo $row['regNo']; ?>" />
                        <input type="hidden" name="regNo" value="<?php echo $row['regNo']; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <select for = "status" name="status" >
                            <option value="unregistered" <?php echo ("unregistered" == $row['status']) ? "selected" : "";?>>unregistered</option>
                            <option>active</option>
                            <option>inactive</option>
                        </select>
                    </td>
                </tr> 
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
        <button onclick="discard('<?php echo $row['regNo']; ?>')">Discard</button>


    </div>

    <script>
        function discard(regNo) {
            var myform = document.createElement("form");
            myform.action = "admin_detail_student.php";
            myform.method = "post";
            var inp = document.createElement('input');
            inp.name = "regNo";
            inp.value = regNo;
            inp.type = "hidden";
            myform.appendChild(inp);
            document.body.appendChild(myform);
            console.log(myform);
            myform.submit()
        }
    </script>


    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>



</body>

</html>