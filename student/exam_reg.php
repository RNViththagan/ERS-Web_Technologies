<?php
ob_start();
session_start();
include("../config/connect.php");
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

$edit = false;
$regDetail =array();
if(isset($_GET['edit']) && isset($_POST['regId'])){
    $edit = true;
    $regId =$_POST['regId'];
    $selectSQL = "SELECT * FROM stud_exam_reg WHERE regId = '$regId';";
    $selectQuery = mysqli_query($con, $selectSQL);
    $regObj = mysqli_fetch_assoc($selectQuery);
    $regDetail['type'] = $regObj['type'];
    $regDetail['combination'] = $regObj['combId'];
    $regDetail['indexNo'] = $regObj['indexNo'];
    $regDetail['level'] = $regObj['level'];
    $examUnitId =array();
    $sql = "SELECT exam_unit_id
        FROM reg_units
        WHERE regid = $regId";

    $result = mysqli_query($con,$sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $examUnitId[] = $row["exam_unit_id"];
        }
    }
}

$errors = array();
$units = array();
$regNo = $_SESSION['userid'];

$selectSQL = "SELECT * FROM student WHERE regNo = '$regNo';";
$selectQuery = mysqli_query($con, $selectSQL);
$user = mysqli_fetch_assoc($selectQuery);
$profile_img = isset($user['profile_img']) ? $user['profile_img'] : "blankProfile.png";

$examDetailsSQL = "SELECT * FROM `exam_reg` WHERE status = 'registration' ORDER BY exam_id DESC LIMIT 1;";
$examDetails = mysqli_query($con, $examDetailsSQL);
$exam = mysqli_fetch_assoc($examDetails);
$exam_id = $exam['exam_id'];
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
    if ($GLOBALS['edit']) {
        echo $GLOBALS['regDetail'][$fieldname];
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
    if ($GLOBALS['edit'] && ($GLOBALS['regDetail'][$fieldName] == $fieldValue)) {
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
    <script>
        var selectedUnits = [];
    </script>

</head>
<body class="bg-slate-200" id="exam">
    <?php if (isset($_GET['error'])) { ?>
        <div class="exam-false fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
            <form class="card h-40 w-1/2 flex flex-col items-center justify-around gap-7" action="index.php" method="POST">
                <p class="text-center"><?php echo $_GET['error'] ?></p>
                <input class="btn fill-btn" type="submit" value="OK" name="ok">
            </form>
        </div>
    <?php } elseif (isset($_GET['success'])) { ?>
        <div class="exam-false fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex justify-center items-center">
            <form class="card h-40 w-1/2 flex flex-col items-center justify-around gap-7" action="index.php" method="POST">
                <p class="text-center text-green-700"><?php echo $_GET['success'] ?></p>
                <input class="btn fill-btn !bg-green-700" type="submit" value="OK" name="ok">
            </form>
        </div>
    <?php } ?>


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
                    //$units = mysqli_fetch_assoc($unitsQueryResult);
                    //print_r($unitsQueryResult->num_rows);
                   // exit;
                    if ($unitsQueryResult) {
                        if (mysqli_num_rows($unitsQueryResult) == 0) {
                            header("Location: index.php?error=No units were assign to this combination.");
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
                        if(isset($_POST['units']))
                            echo '<script>selectedUnits = ' . json_encode($_POST['units']) . ';</script>';
                        displayStep1();
                    } else {
                        global $con, $exam, $regNo;
                        $exam_id = $exam['exam_id'];
                        $indexNo = mysqli_escape_string($con, $_POST['indexNo']);
                        $type = $_POST['type'];
                        $level = $_POST['level'];
                        $editRegId = (isset($_POST['regId']))?$_POST['regId']:false;
                        $combination = $_POST['combination'];
                        $regUnits = $_POST['units'];
                        $date =date('Y-m-d');

                        if($editRegId){

                            $updateQuery = "UPDATE stud_exam_reg SET
                                                indexNo = '$indexNo',
                                                type = '$type',
                                                level = $level,
                                                combId = $combination,
                                                reg_date = '$date'
                                                WHERE regId = $editRegId";

                            if (mysqli_query($con, $updateQuery)) {

                                $deleteQuery = "DELETE FROM reg_units WHERE regId = $editRegId";
                                if (mysqli_query($con, $deleteQuery)) {
                                    $inserted = true;
                                    foreach ($regUnits as $unitId) {
                                        $reg_units_sql = "INSERT INTO reg_units(regId, exam_unit_id) VALUES($editRegId, $unitId)";
                                        $reg_units_query = mysqli_query($con, $reg_units_sql);

                                        if (!$reg_units_query) {
                                            $inserted = false;
                                            break;
                                        }
                                    }
                                    if ($inserted) {
                                        header("Location: index.php?success=Exam registration successfully edited.");
                                        exit();
                                    } else {
                                        header("Location: index.php?error=Exam registration editing failed. Please try again.");
                                        exit();
                                    }
                                }else {
                                    header("Location: index.php?error=Exam registration editing failed. Please try again.");
                                    exit();
                                }
                            } else {
                                header("Location: index.php?error=Exam registration editing failed. Please try again.");
                                exit();
                            }
                        }else {
                            $sql = "SELECT * FROM stud_exam_reg WHERE stud_regNo = '$regNo' AND level = '$level' AND type = '$type' AND exam_id = $exam_id";

                            $result = mysqli_query($con, $sql);

                            if (!$result) {
                                die("Query failed: " . mysqli_error($con));
                            }

                            if (mysqli_num_rows($result) == 0) {
                                $stud_exam_reg_sql = "INSERT INTO stud_exam_reg(exam_id, stud_regNo, indexNo, level, combId, type, reg_date) VALUES($exam_id, '$regNo', '$indexNo', $level, $combination, '$type', '$date')";
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
                            } else {
                                header("Location: index.php?error=You are already registered for the same level, type, and exam.<br>You can edit your existing registration through the menu");

                            }



                        }
                    }
                }

                function displayStep1() {
                    global $combinationList, $_POST, $examUnitId, $exam, $regNo;
                    //repeat exam registration validation
                    $stud_year = substr($regNo,0,4);
                    $exam_year = $exam['academic_year'];
                    $can_repeat =(($exam_year - $stud_year) < 7);

                    if(isset($_POST['units']))
                        $selectedUnits = $_POST['units'];
                    else if($GLOBALS['edit']){
                        $selectedUnits = $examUnitId;
                    }else
                        $selectedUnits = array();
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
                        <form action="exam_reg.php" method="POST" class="mt-10 h-[350px] flex flex-col justify-around" id="examForm">
                            <input type="hidden" name="step" value="1" />
                            <?php if(isset($_POST['regId'])) echo "<input type='hidden' name='regId' value='".$_POST['regId']."' />" ?>
                            <?php foreach ($selectedUnits as $unitId) { ?>
                                <input type="hidden" name="units[]" value="<?php echo $unitId; ?>" />
                            <?php } ?>
                            <div class="detail-row !w-full">
                                <label class="hidden lg:block" for="indexNo">Index Number: <span class="text-red-500">*</span></label>
                                <input class="inputs tracking-wider" type="text" name="indexNo" value="<?php setValue("indexNo") ?>" placeholder="Index Number (SXXXXX)" required />
                            </div>
                            <div class="detail-row !w-full">
                                <label class="hidden lg:block" for="type">Type: <span class="text-red-500">*</span></label>
                                <select class="inputs" id="type" name="type"  required>
                                    <option value="select" <?php setSelected('type', 'select') ?> disabled selected>Select Type</option>
                                    <option value="proper" <?php setSelected('type', 'proper') ?>>Proper</option>
                                    <?php if($can_repeat){?>
                                    <option value="repeat" <?php setSelected('type', 'repeat') ?>>Repeat</option>
                                    <?php } ?>
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
                            <div class="detail-row !w-full">
                                <label class="hidden lg:block" for="combination">Subject Combination: <span class="text-red-500">*</span></label>
                                <select class="inputs" id="combination" name="combination" required>
                                    <option value="select" disabled selected>Select Combination</option>
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

                    $selectedUnits = (isset($_POST['units']))?$_POST['units']:array();
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
                            <?php if(isset($_POST['regId'])) echo "<input type='hidden' name='regId' value='".$_POST['regId']."' />" ?>

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
                                $unitId = $unit['unitId'];
                                $isChecked = in_array($unitId, $selectedUnits);
                                ?>
                                <div class="grid grid-cols-3">
                                    <label class="font-[400] col-span-2" for="<?php echo "unit_$count" ?>"><?php echo $unit['name'] ?></label>
                                    <input class="border-blue-500" type="checkbox" name="units[]" value="<?php echo $unitId ?>" id="<?php echo "unit_$count" ?>" <?php if ($isChecked) echo "checked"; ?> />
                                </div>
                                <?php
                            }
                            ?>

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
<?php if(!(isset($_POST['step']) && $_POST['step']==1)){ ?>
<script>
    // Get form and form elements
    var examForm = document.getElementById("examForm");
    var indexNoInput = document.getElementsByName("indexNo")[0];
    var typeSelect = document.getElementsByName("type")[0];
    var levelSelect = document.getElementsByName("level")[0];
    var combinationSelect = document.getElementsByName("combination")[0];

    // Add event listener for form submission
    examForm.addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }else {
            var unitbox = document.createElement('input');
            unitbox.name = 'units[]';
            unitbox.value = selectedUnits;
            examForm.append(unitbox);
        }
    });

    // Validation function
    function validateForm() {
        var indexNo = indexNoInput.value;
        var type = typeSelect.value;
        var level = levelSelect.value;
        var combination = combinationSelect.value;

        // Add your validation logic here
        if (indexNo === "") {
            alert("Index Number is required.");
            return false;
        }
        if (type === "select") {
            alert("Please select a Type.");
            return false;
        }
        if (level === "select") {
            alert("Please select a Level.");
            return false;
        }
        if (combination === "select") {
            alert("Please select a Combination.");
            return false;
        }

        // If all validations pass, return true
        return true;
    }
</script>

<?php } ?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>