<?php

    include("connect.php");
    
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $records_per_page = 5;
    $offset = ($current_page - 1) * $records_per_page;


    $sql = "SELECT * FROM student INNER JOIN student_check ON student.regNo = student_check.regNo";
    $limit = " LIMIT $offset, $records_per_page";


    $year = "";
    $dept = "";
    $status = "";
    $student_regNo = "";
    $filterOp = "";
    
    if(isset($_POST['filter'])) {
        $year = $_POST['year'];
        $dept = $_POST['dept'];
        $status = $_POST['status'];
        if ($year != "none")
            $filterOp .= " student.regNo LIKE '$year%'";
        if ($dept != "none"){
            if ($filterOp != "")
                $filterOp .=" And "; 
            $filterOp .= " student.regNo LIKE '%$dept%'";
        }
        if ($status != "none"){
            if ($filterOp != "")
                $filterOp .=" And "; 
            $filterOp .= " student_check.status = '$status'";
        }
    }

    if($filterOp != ""){
        $sql .= " Where ".$filterOp.$limit;
    }
    
    $searchOp = "";
    if(isset($_POST['search'])){
       
        $searchkey = $_POST['searchkey'];
        $searchOp = " student.regNo LIKE '%$searchkey%' or student.nameWithInitial LIKE '%$searchkey%'";
        if($searchOp != ""){
            $sql .= " Where ".$searchOp;
        }
    }

    if($filterOp == "" && !isset($_POST['search'])){
        $sql .= $limit;
    }

    
    $stdlist = mysqli_query($con, $sql);    

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
        <h1>Student Management</h1>

        <form action = "" method = "post">
            <input type = "text" name = "searchkey" required>
            <button type = "submit" name = "search">Search</button>
        </form>

        <a href="add_student.php"> <button id="add"> Add </button> </a>

        <div class="filter">
            <form method="post" action="">

                <label for="year">Year</label>
                <select name="year" id="year">
                    <option value="none"></option>
                    <?php
                        // Fetch distinct exam names from the database
                        $distinctYear = "SELECT DISTINCT SUBSTRING(regNo, 1, 4) AS starting_year FROM student";
                        $result = $con->query($distinctYear);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["starting_year"] . "' ";
                                echo ($year == $row["starting_year"]) ? "selected" : "";
                                echo   ">" . $row["starting_year"] . "</option>";
                            }
                        }
                    ?>
                </select>

                <label for="dept">Dept</label>
                <select for="dept" name="dept">
                    <option value="none"></option>
                    <?php
                        // Fetch distinct exam names from the database
                        $distinctDept = "SELECT DISTINCT SUBSTRING(SUBSTRING_INDEX(regNo, '/', 2), 6) AS code FROM student";
                        $result = $con->query($distinctDept);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["code"] . "' ";
                                echo ($dept == $row["code"]) ? "selected" : "";
                                echo   ">" . $row["code"] . "</option>";
                            }
                        }
                    ?>
                </select>

                <label for="status">Status</label>
                <select for="status" name="status">
                    <option value="none"></option>
                    <?php
                        // Fetch distinct exam names from the database
                        $distinctStatus = "SELECT DISTINCT status FROM student_check";
                        $result = $con->query($distinctStatus);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["status"] . "' ";
                                echo ($status == $row["status"]) ? "selected" : "";
                                echo   ">" . $row["status"] . "</option>";
                            }
                        }
                    ?>
                </select>

                <button type="submit" name="filter" value="Filter">Filter</button>

            </form>

            
        </div>
        <table>
            <tr>
                <th>Reg No</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($stdlist)) {
            ?>
                <tr>
                    <td><?php echo $row['regNo']; ?></td>
                    <td><?php echo ($row['title']!="")?$row['title'].". ":"";  echo $row['nameWithInitial']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><button onclick="view('<?php echo $row['regNo']; ?>')">View</button></td>
                </tr>
            <?php
            }
            ?>
        </table>


        <?php
        $prev_page = $current_page - 1;
        $next_page = $current_page + 1;

        echo "<br>";
        if ($prev_page > 0) {
            echo "<a href='?page=$prev_page'><button>Previous</button></a> ";
        }


        $count_sql = "SELECT COUNT(*) AS total FROM student INNER JOIN student_check ON student.regNo = student_check.regNo";
        $count_result = mysqli_query($con, $count_sql);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_records = $count_row['total'];

        $total_pages = ceil($total_records / $records_per_page);

        if ($next_page <= $total_pages) {
            echo "<a href='?page=$next_page'><button>Next</button></a>";
        }
        ?>

    </div>



    <script>
        function view(regNo) {
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

<?php
mysqli_close($con);
?>