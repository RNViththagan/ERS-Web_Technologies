<?php
include("../../config/connect.php");


    $query = "SELECT * FROM admin_details WHERE email = 'stud_admin1@nexus.com'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);


?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <link rel = "stylesheet" type = "text/css" href = "../assets/css/profile.css">
</head>
<body>

    <div class="hero">
        <nav>
            <img src="../img/panels/logo.png" class="logo">
            
            <div class = "user" >
                <p>Saarukesan. P</p>
                <img id = "user-pic" src="../img/panels/user.jpg" onclick="toggleMenu()">
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
                    <a href="studentAdmin/admin_student.php" class="sub-menu-link">
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
                <img id = "user-pic2" src="user.jpg">
            </div>

            <div class = "right">
                <table>
                    <tr>
                        <td>Full Name:</td>
                        <td> <?php echo $row['fullName']; ?> </td>
                    </tr>
                    <!-- <tr>
                        <td>Name with Initials:</td>
                        <td> <?php //echo $row['nameWithInitials']; ?> </td>
                    </tr> -->
                    <tr>
                        <td>Email:</td>
                        <td> <?php echo $row['email']; ?> </td>
                    </tr>
                    <tr>
                        <td>Mobile No:</td>
                        <td> <?php echo $row['mobileNo']; ?> </td>
                    </tr>
                    <tr>
                        <td>Department:</td>
                        <td> <?php echo $row['department']; ?> </td>
                    </tr>
                    
                </table>

                <button onclick="edit('<?php echo $row['email']; ?>')">Edit</button>
        
            </div>

        </div>
    </div>

    <script>
        function edit(email) {
            var myform = document.createElement("form");
            myform.action = "admin_profile_edit.php";
            myform.method = "post";
            var inp = document.createElement('input');
            inp.name = "email";
            inp.value = email;
            inp.type = "hidden";
            myform.appendChild(inp);
            document.body.appendChild(myform);
            console.log(myform);
            myform.submit()
        }
    </script>


   <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script> 
    


</body>
</html>