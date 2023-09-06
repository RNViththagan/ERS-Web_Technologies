<?php

ob_start();
session_start();
if (!isset($_SESSION['userid']) || !isset($_SESSION['role'])) {
    header("location: login");
    exit();
}

include("config/connect.php");
$regID = $_SESSION['userid'];
$courseColumns = array();

if (isset($_GET['id'])) {
    $examID = $_GET['id'];

    $sql = "SELECT * FROM `exam_reg` WHERE exam_id = '$examID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    displayForm($row);
}

if (isset($_POST['DisplayList'])) {
    $level = $_POST['level'];
    $type = $_POST['type'];

    $userDataSQL = "SELECT ser.indexNo, s.title, s.nameWithInitial, c.combinationName, ru.exam_unit_id
            FROM `stud_exam_reg` ser
            INNER JOIN `reg_units` ru ser ON ser.regId = ru.regId
            INNER JOIN `student` s ON ser.stud_regNo = s.regNo
            INNER JOIN `combination` c ON ser.combId = c.combinationID
            WHERE ser.level = '$level' AND ser.type = '$type' AND exam_id = $examID
            GROUP BY c.combinationName
            ORDER BY c.combinationName ASC;";
    $userDataResult = mysqli_query($conn, $userDataSQL);
    $userData = mysqli_fetch_assoc($userDataResult);

    $coursesSQL = "SELECT use.unitId, u.unitCode
                FROM `unit_sub_exam` use
                INNER JOIN unit u ON u.unitId = use.unitId
                WHERE use.exam_id = $examID AND use.type = '$type' AND u.level = $level";
    $coursesListResult = mysqli_query($con, $coursesSQL);
    $coursesList = mysqli_fetch_assoc($coursesListResult);

    foreach ($coursesList as $unit) {
        $courseColumns[] = $unit['unitCode'];
    }

    displayList($userData, $courseColumns);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
        rel="shortcut icon"
        href="../assets/img/logo/ERS_logo_icon.ico"
        type="image/x-icon" />
    <title>ERS | Registered List</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
    src="https://kit.fontawesome.com/5ce4b972fd.js"
    crossorigin="anonymous"></script>
</head>
<body>
    <nav class="w-full h-[15vh] min-h-fit drop-shadow-md bg-white fixed top-0 left-0">
        <div class="w-10/12 h-full m-auto flex items-center justify-between">
            <a href="index.php">
                <img src="../assets/img/logo/ERS_logo.gif" alt="logo" class="w-28 align-middle">
            </a>    
            <ul class="flex items-center justify-around gap-10">

                <?php if (!isset($profile_img)) { ?>
                    <li onclick="openMenu()" class="py-2 px-3 bg-[var(--primary)] rounded-full drop-shadow-md cursor-pointer lh:relative"><i class="fa-solid fa-user text-2xl text-[#dfeaff]"></i></li>
                <?php } else { ?>
                    <img onclick="openMenu()" class="w-10 h-10 lg:w-12 lg:h-12 rounded-full drop-shadow-md cursor-pointer ring-4" src="../assets/uploads/<?php echo $profile_img; ?>" alt="user img">
                <?php } ?>
                
            </ul>
                       
        </div>
        <div class="hidden top-[14.8vh] right-0 h-56 w-full bg-white -translate-y-full z-20 transition-transform lg:top-[16vh] lg:drop-shadow-2xl lg:right-24 lg:w-56 lg:translate-x-full lg:h-72 lg:rounded-tl-3xl lg:rounded-br-3xl lg:text-gray-800" id="user-menu">
            <ul class="w-11/12 h-full m-auto flex flex-col items-center justify-around text-center">
                <li class="mt-3 "><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="exam_reg.php">Exam Registration</a></li>
                <div class="h-px w-3/4 bg-gray-300"></div>
                <li class=""><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="index.php">Dashboard</a></li>
                <div class="h-px w-3/4 bg-gray-300"></div>
                <li class=""><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="#">Contact</a></li>
                <div class="h-px w-3/4 bg-gray-300"></div>
                <li class="mb-3 "><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="../logout.php">Logout</a></li>
            </ul>   
        </div>   
    </nav>


    <div class="body-sec my-[20vh]">
        <div class="container m-auto">
            <div class="card w-11/12 m-auto">
                <?php function displayForm($row) { ?>
                    <form action="reg_list.php" method="post">
                        <div class="detail-row !w-full">
                            <label class="hidden lg:block" for="type">Type: <span class="text-red-500">*</span></label>
                            <select class="inputs" id="type" name="type"  required>
                                <option value="select" <?php setSelected('type', 'select') ?> disabled selected>Select Type</option>
                                <option value="proper" <?php setSelected('type', 'proper') ?>>Proper</option>
                                <option value="repeat" <?php setSelected('type', 'repeat') ?>>Repeat</option>
                            </select>
                        </div>
                        <div class="detail-row !w-full">
                            <label class="hidden lg:block" for="level">Level: <span class="text-red-500">*</span></label>
                            <select class="inputs" id="level" name="level" required>
                                <option value="select" <?php setSelected('level', 'select') ?> disabled selected>Select Level</option>
                                <option value="1" <?php setSelected('level', 1) ?>>Level 1</option>
                                <option value="2" <?php setSelected('level', 2) ?>>Level 2</option>
                                <option value="3" <?php setSelected('level', 3) ?>>Level 3</option>
                                <option value="4" <?php setSelected('level', 4) ?>>Level 4</option>
                            </select>
                        </div>

                        <input class="btn fill-btn mt-5 " type="submit" name="DisplayList" value="Display" />
                    </form>

                <?php } ?>

                <?php function displayList($userData, $courseColumns) { ?>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Reg No.</th>
                            <th>Index No.</th>
                            <th>title</th>
                            <th>Name with initials</th>
                            <th>Combination</th>
                            <?php
                                foreach ($courseColumns as $course) {
                                    echo "<th>$course</th>";
                                }
                            ?>
                            
                        </tr>
                        <?php
                            while ($user = $userData) {
                                echo "<tr>";
                                echo "<td>$user[indexNo]</td>";
                                echo "<td>$user[regNo]</td>";
                                echo "<td>$user[indexNo]</td>";
                                echo "<td>$user[title]</td>";
                                echo "<td>$user[nameWithInitial]</td>";
                                echo "<td>$user[combinationName]</td>";
                                foreach ($courseColumns as $course) {
                                    ($user['exam_unit_id'] === $course) ? 'P' : '-';
                                }
                            }
                        ?>
                    </table>

                    <?php if (isset($_SESSION['role'])) { ?>
                        <a href="#" class="btn fill-btn !bg-green-500">Download as a Excel sheet</a>
                    <?php } elseif (isset($_SESSION['role'])) { ?>
                        <a href="#" class="btn fill-btn!bg-green-500">Download as a PDF</a>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</body>
</html>


<script>
    const userMenu = document.getElementById('user-menu');

    function openMenu() {
        userMenu.classList.toggle('hidden');
        userMenu.classList.toggle('absolute');
        userMenu.classList.toggle('-translate-y-full');
        userMenu.classList.toggle('lg:translate-x-full');
    }

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
