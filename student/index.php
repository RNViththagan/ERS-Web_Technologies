<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:../index.php");
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
$regNo = $_SESSION['userid'];
$selectSQL = "SELECT * FROM student WHERE regNo = '$regNo';";
$selectQuery = mysqli_query($con, $selectSQL);
$user = mysqli_fetch_assoc($selectQuery);

$title = isset($user["title"]) ? $user["title"] : "";
$fullName = isset($user["fullName"]) ? $user["fullName"] : "";
$nameWithInitial = isset($user["nameWithInitial"]) ? $user["nameWithInitial"] : "";
$email = isset($user["email"]) ? $user["email"] : "";
// $index = isset($user["indexNumber"]) ? $user["indexNumber"] : "";
$userDistrict = isset($user["district"]) ? $user["district"] : "";
$mobileNo = isset($user["mobileNo"]) ? $user["mobileNo"] : "";
$landlineNo = isset($user["landlineNo"]) ? $user["landlineNo"] : "";
$home_address = isset($user["homeAddress"]) ? $user["homeAddress"] : "";
$jaffna_address = isset($user["addressInJaffna"]) ? $user["addressInJaffna"] : "";
$profile_img = isset($user['profile_img']) ? $user['profile_img'] : "blankProfile.png";

if (isset($_POST["submit"]))  {
    $title= $_POST["title"];
    $fname= $_POST["fname"];
    $nameWithInitial= $_POST["nameWithInitial"];
    $userDistrict= $_POST["userDistrict"];
    $mobileNo= $_POST["mobileNo"];
    $landlineNo= $_POST["landlineNo"];
    $home_address= $_POST["home_address"];
    $jaffna_address= $_POST["jaffna_address"];


    $imageName = $profile_img;
    if(isset($_FILES["fileImg"]["name"]) and $_FILES["fileImg"]["name"] != Null){
        if($profile_img!="blankProfile.png"){
            echo unlink("../assets/uploads/".$profile_img);
        }
        $src = $_FILES["fileImg"]["tmp_name"];
        $path = $_FILES['fileImg']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $imageName = str_replace("/","",$regNo).".".$ext;
        $target = "../assets/uploads/" . $imageName;
        move_uploaded_file($src, $target);
    }

    $sql = "UPDATE student SET title = '$title', fullName = '$fname', nameWithInitial = '$nameWithInitial', district = '$userDistrict', mobileNo = '$mobileNo', landlineNo = '$landlineNo', homeAddress = '$home_address',addressInJaffna = '$jaffna_address', profile_img = '$imageName' WHERE regNo = '$regNo'";
    if ($con->query($sql) === FALSE) {
        $errors['update-error'] = "Error updating record: " . $con->error;
    }
    else{
        header("Location: index.php");
        exit;
    }

}


$districts = ['Select', 'Colombo', 'Kandy', 'Galle', 'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar', 'Matale', 'Matara', 'Moneragala', 'Mullativu', 'Nuwara Eliya', 'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link
            rel="shortcut icon"
            href="../assets/img/logo/ERS_logo_icon.ico"
            type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ERS | Student</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
    src="https://kit.fontawesome.com/5ce4b972fd.js"
    crossorigin="anonymous"></script>
</head>
<body class=" bg-gray-50" id="student">
    <?php include("navBar.php"); ?>
    
    <div class="body-sec my-[20vh]">
        <div class="container m-auto">
            <div class="card w-11/12 m-auto grid grid-rows-[30%_70%] lg:grid-cols-[30%_1%_69%] ">
                <div class="profile text-center flex flex-col items-center justify-around lg:justify-center lg:h-[430px]">
                <?php if (!isset($_GET['update'])) { ?>
                    <img class="mx-auto mb-5 w-[125px] h-[125px] rounded-full ring-4 ring-offset-4" src="../assets/uploads/<?php echo $profile_img; ?>" alt="user img">
                    <h3 class="font-semibold text-lg"><?php echo "$title. $nameWithInitial"; ?></h3>
                    <p class="text-sm"><?php echo $email; ?></p>
                    <h4 class="text-sm"><?php echo $regNo; ?></h4>
                    
                <?php } else { ?>
                    <form action="index.php" method="POST" enctype="multipart/form-data">
                        <img class="mx-auto mb-5 w-[125px] h-[125px] rounded-full ring-4 ring-offset-4" src="../assets/uploads/<?php echo $profile_img; ?>" alt="user img">
                        <input class="bg-blue-100 w-10/12 text-sm mt-5" type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">
                <?php } ?>
                </div>
                <div class="line hidden lg:block lg:w-px lg:h-[430px]"></div>
                <div class ="student-details mt-5 lg:w-10/12 lg:mt-0 lg:h-fit text-sm lg:text-base">
                    <?php if (isset($_GET['update'])) { ?>
                        <div class="mt-4 w-full h-full flex flex-col items-center justify-around lg:mt-0 lg:h-[750px]">
                            <div class="detail-row">
                                <label class="hidden lg:block" for="title">Title: <span class="text-red-500">*</span></label>
                                <input class="inputs w-full lg:w-1/2" type="text" id="title" name="title" value="<?php echo $title; ?>" required >
                            </div>

                            <div class="detail-row">
                                <label class="hidden lg:block" for="fname">Full Name: <span class="text-red-500">*</span></label>
                                <input class="inputs w-full lg:w-1/2" type="text" id="fname" name="fname" value="<?php echo $fullName; ?>" required >
                            </div>

                            <div class="detail-row">
                                <label class="hidden lg:block" for="nameWithInitial">Name With Initials: <span class="text-red-500">*</span></label>
                                <input class="inputs w-full lg:w-1/2" type="text" id="nameWithInitial" name="nameWithInitial" value="<?php echo $nameWithInitial; ?>" required>
                            </div>

                            <div class="detail-row">
                                <label class="hidden lg:block" for="regNo">Registration Number:</label>
                                <input class="inputs w-full lg:w-1/2" type="text" id="regNo" name="regNo" value="<?php echo $regNo; ?>" required disabled>
                            </div>

                            <div class="detail-row">
                                <label class="hidden lg:block" for="district">District: <span class="text-red-500">*</span></label>
                                <select class="inputs" name="userDistrict" id="district"  required>
                                    <?php foreach ($districts as $district) {?>
                                        <option value="<?php echo $district;?>" <?php if ($district == $userDistrict) { echo "selected"; }?>><?php echo $district;?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="detail-row">
                                <label class="hidden lg:block" for="mobileNo">Mobile: <span class="text-red-500">*</span></label>
                                <input class="inputs w-full lg:w-1/2" type="tel" id="mobileNo" name="mobileNo" value="<?php echo $mobileNo; ?>" required>
                            </div>

                            <div class="detail-row">
                                <label class="hidden lg:block" for="landlineNo">Landline: <span class="text-red-500">*</span></label>
                                <input class="inputs w-full lg:w-1/2" type="text" id="landlineNo" name="landlineNo" value="<?php echo $landlineNo; ?>" required>
                            </div>

                            <div class="detail-row">
                                <label class="hidden lg:block" for="home_address">Home Address: <span class="text-red-500">*</span></label>
                                <textarea class="inputs" id="home_address" name="home_address" rows="3" required><?php echo $home_address; ?></textarea>
                            </div>
                                            
                            <div class="detail-row">
                                <label class="hidden lg:block" for="home_address">Current Address: <span class="text-red-500">*</span></label>
                                <textarea class="inputs" id="jaffna_address" name="jaffna_address" rows="3" required><?php echo $jaffna_address; ?></textarea>
                            </div>
                                    
                            <input class="inputs w-full lg:w-1/2 btn fill-btn" type="submit"  name ="submit" value="Update" class="btn fill-btn">
                                
                        </div>    
                    </form>
                    <?php } else { 
                        if (isset($errors['update-error'])) { ?>
                            <p class="error-text"><?php echo $error['update-error'] ?></p>
                        <?php } ?>
                        <div class="mt-4 w-full h-full flex flex-col items-center justify-around lg:mt-0 lg:h-[430px]">
                            <div class="detail-row">
                                <h5>Full Name:</h5>
                                <p><?php echo "$title. $fullName"; ?></p>
                            </div>
                            <div class="detail-row">
                                <h5>District:</h5>
                                <p><?php echo $userDistrict; ?></p>
                            </div>
                            <div class="detail-row">
                                <h5>Mobile:</h5>
                                <p><?php echo $mobileNo; ?></p>
                            </div>
                            <div class="detail-row">
                                <h5>Landline:</h5>
                                <p><?php echo $landlineNo; ?></p>
                            </div>
                            <div class="detail-row">
                                <h5>Home Address:</h5>
                                <p><?php echo $home_address; ?></p>
                            </div>
                            <div class="detail-row">
                                <h5>Address in Jaffna:</h5>
                                <p><?php echo $jaffna_address; ?></p>
                            </div>
                            <a href="index.php?update=true" class="btn fill-btn mx-auto mt-5">Update</a>
                            
                        </div>
                    <?php } ?>
                </div>

            </div>

            <?php if (!isset($_GET['update'])) {
                $examSQL = "SELECT * FROM `stud_exam_reg` WHERE stud_regNo = '$regNo';";
                $examQuery = mysqli_query($con, $examSQL);
                
                ?>
                <div class="card mt-32 w-11/12 mx-auto flex flex-col items-center">
                    <h2 class="font-extrabold text-center underline text-xl">Exam History</h2>
                    <table class="w-11/12 mx-auto mt-8 rounded-lg text-xs lg:text-base">
                        <thead class="bg-blue-100 h-6 lg:h-12">
                            <th class="font-semibold">Date</th>
                            <th class="font-semibold border-gray-100 border-x-2">Type</th>
                            <th class="font-semibold border-gray-100 border-x-2">Level</th>
                            <th class="font-semibold border-gray-100 border-x-2">Semester</th>
                            <th class="font-semibold ">Subject<br>Combination</th>
                        </thead>
                        <tbody class="text-center ">
                            <?php
                                if (mysqli_num_rows($examQuery) > 0) {
                                    while ($exam = $examQuery->fetch_assoc()) {
                                        $examID = $exam['exam_id'];
                                        $date = $exam['reg_date'];
                                        $type = $exam['type'];
                                        $level = $exam['level'];
                                        $combID = $exam['combId'];
                                        $sem = mysqli_fetch_assoc(mysqli_query($con, "SELECT semester FROM `exam_reg` WHERE exam_id = $examID"));
                                        $semester = $sem['semester'];
                                        $comb = mysqli_fetch_assoc(mysqli_query($con, "SELECT combinationName FROM `combination` WHERE combinationID = $combID"));
                                        $combination = $comb['combinationName'];
                                        echo "
                                        <tr class='h-10 even:bg-blue-50'>
                                            <td>$date</td>
                                            <td>$type</td>
                                            <td>$level</td>
                                            <td>$semester</td>
                                            <td>$combination</td>
                                        </tr>
                                        ";
                                        } 
                                } else { 
                                    echo "
                                        <tr class='h-10 even:bg-blue-50'>
                                            <td colspan='5'>No record found</td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>
                    <a href="exam_reg.php" class="btn outline-btn w-1/2 mt-7 text-xs lg:text-base">Register for a new Exam</a>
                </div>
            <?php } ?> 
        </div>
    </div>

</body>
</html>
