<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:../login.php");
    exit();
}
elseif (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == "Admin_Master") {
        header("Location:../master");
        exit;
    } else {
        header("Location:../admin");
        exit;
    }
}

include("../config/connect.php");

$errors = array();
$units = array();
$regNo = $_SESSION['userid'];

$selectSQL = "SELECT * FROM student WHERE regNo = '$regNo';";
$selectQuery = mysqli_query($con, $selectSQL);
$user = mysqli_fetch_assoc($selectQuery);
$profile_img = isset($user['profile_img']) ? $user['profile_img'] : "blankProfile.png";

$examDetailsSQL = "SELECT * FROM `exam_reg` WHERE status = 'registration';";
$examDetails = mysqli_query($con, $examDetailsSQL);
$exam = mysqli_fetch_assoc($examDetails);

if (mysqli_num_rows($examDetails) == 0) {
    header("Location: index.php?error=Sorry! There is no exams to register");
    exit();
}

$selectSQL1 = "SELECT * FROM combination";
$combinationList = mysqli_query($con, $selectSQL1);

function setValue($fieldname) {
    if (isset($_POST[$fieldname])) {
        echo $_POST[$fieldname];
    }
}

function setChecked($fieldName, $fieldValue) {
    if (isset($_POST[$fieldName]) && $_POST[$fieldName] == $fieldValue) {
        echo "checked='checked'";
    }
}

function setSelected($fieldName, $fieldValue) {
    if (isset($_POST[$fieldName]) && $_POST[$fieldName] == $fieldValue) {
        echo  "selected='selected'";
    }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="shortcut icon"
        href="../assets/img/logo/ERS_logo_icon.ico"
        type="image/x-icon" />
    <title>ERS | Exam Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
    src="https://kit.fontawesome.com/5ce4b972fd.js"
    crossorigin="anonymous"></script>
</head>
<body class="bg-slate-200" id="exam">
    <nav class="w-full h-[15vh] min-h-fit drop-shadow-md bg-white fixed top-0 left-0">
        <div class="w-10/12 h-full m-auto flex items-center justify-between">
            <a href="index.php">
                <img src="../assets/img/logo/ERS_logo.gif" alt="logo" class="w-28 align-middle">
            </a>    
            <ul>
                <?php if (!isset($profile_img)) { ?>
                    <li onclick="openMenu()" class="py-2 px-[14px] bg-[var(--primary)] rounded-full drop-shadow-md cursor-pointer lh:relative"><i class="fa-solid fa-user text-2xl text-[#dfeaff]"></i></li>
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
                <li class=""><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="../contact.html">Contact</a></li>
                <div class="h-px w-3/4 bg-gray-300"></div>
                <li class="mb-3 "><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="../logout.php">Logout</a></li>
            </ul>   
        </div>   
    </nav>

    <div class="w-1/2 mx-auto mt-[22vh] mb-20">
        <div class="card ">
            <div class="w-11/12 mx-auto h-fit">
                
                <?php

                if (isset($_POST["step"])) {
                    if ($_POST["step"] == '1') {              
                        processStep1();
                    } else if ($_POST["step"] == '2') {
                        processStep2();
                    }
                } else {
                    displayStep1();
                }

                function processStep1() {
                    global $con, $units, $exam;

                    $exam_id = $exam['exam_id'];
                    $type = $_POST['type'];
                    $level = $_POST['level'];
                    $combination = $_POST['combination'];

                    $unitSQL = "
                        SELECT DISTINCT u.unitId, u.unitCode, u.name
                        FROM unit u
                        INNER JOIN combination_subjects cs ON u.subject = cs.subject
                        INNER JOIN unit_sub_exam usexam ON u.unitId = usexam.unitId
                        WHERE cs.combinationID = $combination
                        AND u.level = $level
                        AND usexam.exam_id = $exam_id
                        AND usexam.type = '$type';
                    ";

                    $unitsQueryResult = mysqli_query($con, $unitSQL);
                    $units = mysqli_fetch_assoc($unitsQueryResult);

                    if ($units) {
                        if (mysqli_num_rows($unitsQueryResult) == 0) {
                            header("Location: index.php?error=Something-went-wrong");
                            exit();
                        }
                    } else {
                        header("Location: index.php?error=Something-went-wrong");
                        exit();
                    }

                    displayStep2($unitsQueryResult);
                }

                function processStep2() {
                    if (isset($_POST["submit"]) and $_POST["submit"] == "< Back") {
                        displayStep1();
                    } else {
                        global $con, $exam, $regNo;
                        $exam_id = $exam['exam_id'];
                        $indexNo = mysqli_escape_string($con, $_POST['indexNo']);
                        $type = $_POST['type'];
                        $level = $_POST['level'];
                        $combination = $_POST['combination'];
                        $regUnits = $_POST['units'];

                        $stud_exam_reg_sql = "INSERT INTO stud_exam_reg(exam_id, stud_regNo, indexNo, level, combId, type) VALUES($exam_id, '$regNo', '$indexNo', $level, $combination, '$type')";
                        $stud_exam_reg_query = mysqli_query($con, $stud_exam_reg_sql);

                        if (!$stud_exam_reg_query) {
                            header("Location: index.php?error=Something-went-wrong");
                            exit();
                        }

                        $regId = mysqli_insert_id($con);
                        $inserted = true;

                        foreach ($regUnits as $unitId) {
                            $reg_units_sql = "INSERT INTO reg_units(regId, exam_unit_id) VALUES($regId, $unitId)";
                            $reg_units_query = mysqli_query($con, $reg_units_sql);
                        
                            if (!$reg_units_query) {
                                $inserted = false;
                                break;
                            }
                        }

                        if ($inserted) {
                            header("location: index.php?success=Successfully Registered.");
                        } else {
                            header("Location: index.php?error=Something-went-wrong");
                        }
                    }
                }

                function displayStep1() {
                    global $combinationList, $_POST; 
                    ?>
                    <h1 class="text-lg font-black text-center underline mt-5 text-gray-800 lg:text-2xl">Exam Registration</h1>
                
                    <div class="instructions mt-7 mb-16">
                        <p class="font-semibold">Read the following instructions carefully before filling this form ------ &gt; &gt; &gt;</p>
                        <ol class="ml-7 my-4 list-decimal text-justify">
                            <li>Students are advised to use either an individual smartphone or personal computer to avoid technical errors.</li>
                            <li>Sign out from the Gmail account on your smartphone or PC if you have already signed-in. Then type your own Gmail  ID to login to this the Google form</li>
                            <li>Only one record will be accepted per email ID</li>
                            <li>After submitting this form, a link with your registered course units will be sent to your email. You are advised to check whether your entries are correct. If you have made any wrong entries, you can edit the registered course units by clicking the link until the deadline</li>
                            <li>If you provide any incorrect information, you will be barred from sitting the examination</li>
                        </ol>
                        <p>If you have any questions, feel free to contact us at <EMAIL></p>
                        <p class="text-right mt-5">Assistant Registrar<br>FACULTY OF SCIENCE</p>
                    </div>
                    <div class="w-11/12 mx-auto">
                        <h3 class="font-bold lg:text-xl text-center text-gray-800">Personal Details</h3>
                        <form action="exam_reg.php" method="POST" class="mt-10 h-[350px] flex flex-col justify-around">
                            <input type="hidden" name="step" value="1" />

                            <div class="detail-row !w-full">
                                <label class="hidden lg:block" for="indexNo">Index Number: <span class="text-red-500">*</span></label>
                                <input class="inputs tracking-wider" type="text" name="indexNo" value="<?php setValue("indexNo") ?>" placeholder="Index Number (SXXXXX)" required />
                            </div>
                            <div class="detail-row !w-full">
                                <label class="hidden lg:block" for="type">Type: <span class="text-red-500">*</span></label>
                                <select class="inputs" id="type" name="type" required>
                                    <option value="select" <?php setSelected('type', 'select') ?>>Select Type</option>
                                    <option value="proper" <?php setSelected('type', 'proper') ?>>Proper</option>
                                    <option value="repeat" <?php setSelected('type', 'repeat') ?>>Repeat</option>
                                </select>
                            </div>
                            <div class="detail-row !w-full">
                                <label class="hidden lg:block" for="level">Level: <span class="text-red-500">*</span></label>
                                <select class="inputs" id="level" name="level" required>
                                    <option value="select" <?php setSelected('level', 'select') ?>>Select Level</option>
                                    <option value="1" <?php setSelected('level', 1) ?>>Level 1</option>
                                    <option value="2" <?php setSelected('level', 2) ?>>Level 2</option>
                                    <option value="3" <?php setSelected('level', 3) ?>>Level 3</option>
                                    <option value="4" <?php setSelected('level', 4) ?>>Level 4</option>
                                </select>
                            </div>
                            <div class="detail-row !w-full">
                                <label class="hidden lg:block" for="combination">Subject Combination: <span class="text-red-500">*</span></label>
                                <select class="inputs" id="combination" name="combination" required>
                                    <option value="select">Select Combination</option>
                                    <?php
                                    while ($userCombination = mysqli_fetch_assoc($combinationList)) { ?>
                                        <option value="<?php echo $userCombination['combinationID'] ?>" <?php setSelected('combination', $userCombination['combinationID']) ?>>
                                            <?php echo $userCombination['combinationName']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                                            
                            <!-- <input type="checkbox" name="units[]" id="units" value > -->

                            <input class="btn fill-btn mt-8 " type="submit" name="submit" value="Next &gt;" />
                            
                        </form>
                    </div>
                    
                <?php } 
                
                function displayStep2($unitsQueryResult) {
                    global $combinationList;
                    $count = 0; 
                    ?>
                    <div class="w-11/12 mx-auto">
                        <div>
                            <h3 class="font-bold lg:text-xl text-center text-gray-800">Select Units</h3>
                            <p class="text-center text-gray-500">Select course units you want to apply for the exam.</p>
                        </div>
                        <form action="exam_reg.php" method="POST" class="mt-10 min-h-[350px] w-3/4 mx-auto flex flex-col justify-around">
                            <input type="hidden" name="step" value="2" />

                            <input type="hidden" name="indexNo" value="<?php setValue("indexNo") ?>" />
                            <select id="type" name="type" hidden>
                                <option value="select" <?php setSelected('type', 'select') ?>>Select Type</option>
                                <option value="proper" <?php setSelected('type', 'proper') ?>>Proper</option>
                                <option value="repeat" <?php setSelected('type', 'repeat') ?>>Repeat</option>
                            </select>
                            <select id="level" name="level" hidden>
                                <option value="select" <?php setSelected('level', 'select') ?>>Select Level</option>
                                <option value="1" <?php setSelected('level', 1) ?>>Level 1</option>
                                <option value="2" <?php setSelected('level', 2) ?>>Level 2</option>
                                <option value="3" <?php setSelected('level', 3) ?>>Level 3</option>
                                <option value="4" <?php setSelected('level', 4) ?>>Level 4</option>
                            </select>
                            <select id="combination" name="combination" hidden>
                                <option value="select" <?php setSelected('combination', 'select') ?>>Select Combination</option>
                                <?php
                                while ($userCombination = mysqli_fetch_assoc($combinationList)) { ?>
                                    <option value="<?php echo $userCombination['combinationID'] ?>" <?php setSelected('combination', $userCombination['combinationID']) ?>>
                                        <?php echo $userCombination['combinationName']; ?>
                                    </option>
                                <?php } ?>
                            </select>


                            <?php while ($unit = mysqli_fetch_assoc($unitsQueryResult)) {
                                $count++;
                                ?>
                                <div class="grid grid-cols-3">
                                    <label class="font-[400] col-span-2" for="<?php echo "unit_$count" ?>"><?php echo $unit['name'] ?></label>
                                    <input class="border-blue-500 " type="checkbox" name="units[]" value="<?php echo $unit['unitId'] ?>" id="<?php echo "unit_$count" ?>" <?php setSelected('units[]', $unit['unitId']) ?> />
                                </div>
                            <?php } ?>

                            <div class="w-full flex items-center justify-around mt-5">
                                <input class="btn outline-btn w-5/12" type="submit" name="submit" value="&lt; Back" />
                                <input class="btn fill-btn w-5/12" type="submit" name="submit" value="Next &gt;" />
                            </div>
                        </form>
                    </div>
                <?php } ?>

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
</script>