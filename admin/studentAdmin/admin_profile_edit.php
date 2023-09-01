<?php
include("connect.php");

if (isset($_POST['email'])) {
    $regNo = $_POST['email'];
    $query = "SELECT * FROM admin_details WHERE email = 'stud_admin1@nexus.com'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}





if (isset($_POST['save'])) {
    $email = $_POST["email"];
    $fullName = $_POST["fullName"];
    //$nameWithInitials = $_POST["nameWithInitials"];
    $mobileNo = $_POST["mobileNo"];
    $department = $_POST["department"];

    $query = "UPDATE admin_details SET fullName = '$fullName', mobileNo = '$mobileNo', department = '$department' WHERE email = 'stud_admin1@nexus.com'";
    $result = mysqli_query($con, $query);

    if ($result) {
        mysqli_close($con);
        header("location: admin_profile.php?email=$email");
    } else {
        echo "Connection Failed : " . mysqli_connect_error();
    }
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

    <link rel = "stylesheet" type = "text/css" href = "profile.css">
</head>
<body>

    <div class="hero">
        <nav>
            <img src="../img/panels/logo.png" class="logo">
            
            <div class = "user" >
                <p>Saarukesan. P</p>
                <img id = "user-pic" src="user.jpg" onclick="toggleMenu()">
                <img id = "down" src="../img/panels/down.png" onclick="toggleMenu()">
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

    <div class = "card">
        <h1>Admin Profile</h1>

        <div class = "profile">
            <div class = "left">
                <img id = "user-pic2" src="../user.png">
            </div>

            <div class = "right">
                <form method="post" action="">
                    <table>
                        <tr>
                            <td>Full Name:</td>
                            <td>
                                <input type = "text" name = "fullName" value = "<?php echo $row['fullName']; ?>"/> 
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>Name with Initials:</td>
                            <td>
                                <input type = "text" name = "nameWithInitials" value = "<?php //echo $row['nameWithInitials']; ?>"/> 
                            </td>
                        </tr> -->
                        <tr>
                            <td>Email:</td>
                            <td>
                                <input type = "text" value = "<?php echo $row['email']; ?>"/>
                                <input type = "hidden" name = "email" value="<?php echo $row['email']; ?>"/> 
                            </td>
                        </tr>
                        <tr>
                            <td>Mobile No:</td>
                            <td>
                                <input type = "text" name = "mobileNo" value = "<?php echo $row['mobileNo']; ?>"/> 
                            </td>
                        </tr>
                        <tr>
                            <td>Department:</td>
                            <td>
                                <input type = "text" name = "department" value = "<?php echo $row['department']; ?>"/> 
                            </td>
                        </tr>
                        
                    </table>

                    <input type="submit" name="save" value="Save">
                    <input type="reset" value="Reset">

                </form>
        
            </div>

        </div>

        
        
    </div>

   <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script> 
    


</body>
</html>