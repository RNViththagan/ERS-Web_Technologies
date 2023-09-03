<?php
include("../config/connect.php");
$errors = array();
$userID = $_SESSION['userid'];

if (isset($_POST["submit"]))  {
    $title= $_POST["title"];
    $name= $_POST["name"];
    $fullName= $_POST["fullName"];
    $department= $_POST["department"];
    $mobileNo= $_POST["mobileNo"];

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

    $sql = "UPDATE `admin_details` 
            SET `fullName`='$fullName',`department`='$department',`mobileNo`='$mobileNo',`title`='$title',`profile_img`='$imageName' 
            WHERE email = '$userID'";

    $insertResult = mysqli_query($con, $sql);
            
    if (!$insertResult) {
        header("location: index.php?error=Something went wrong! $con->error");
    } else {
        header("Location: index.php?success=Successfully data Updated.");
        exit;
    }

}

$selectSQL = "SELECT * FROM admin_details WHERE email = '$userID';";
$selectQuery = mysqli_query($con, $selectSQL);
$admin = mysqli_fetch_assoc($selectQuery);

$title = isset($admin["title"]) ? $admin["title"] : "";
$name = isset($admin["name"]) ? $admin["name"] : "";
$fullName = isset($admin["fullName"]) ? $admin["fullName"] : "";
$email = isset($admin["email"]) ? $admin["email"] : "";
$department = isset($admin["department"]) ? $admin["department"] : "";
$mobileNo = isset($admin["mobileNo"]) ? $admin["mobileNo"] : "";
$profile_img = isset($admin['profile_img']) ? $admin['profile_img'] : "blankProfile.png";

?>


<div class="w-11/12 m-auto ">
    <form action="index.php?page=updateProfile" method="POST" enctype="multipart/form-data" class="grid grid-rows-[30%_70%] lg:grid-cols-[30%_1%_69%] ">
        <div class="profile text-center flex flex-col items-center justify-around lg:justify-center lg:h-[430px]">
            <img class="mx-auto mb-5 w-[125px] h-[125px] rounded-full ring-4 ring-offset-4" src="../assets/uploads/<?php echo $profile_img; ?>" alt="user img">
            <input class="bg-blue-100 w-10/12 text-sm mt-5" type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">
        </div>
        <div class="line hidden lg:block lg:w-px lg:h-[430px]"></div>
        <div class ="student-details mt-5 lg:w-10/12 lg:mt-0 lg:h-fit text-sm lg:text-base">
            <div class="mt-4 w-full h-full flex flex-col items-center justify-around lg:mt-0 lg:h-[430px]">
                <div class="detail-row ">
                    <label class="hidden lg:block" for="title">Title: <span class="text-red-500">*</span></label>
                    <input class="inputs  w-full lg:w-1/2" type="text" id="title" name="title" value="<?php echo $title; ?>" required >
                </div>

                <div class="detail-row">
                    <label class="hidden lg:block" for="name">Name: <span class="text-red-500">*</span></label>
                    <input class="inputs  w-full lg:w-1/2" type="text" id="name" name="name" value="<?php echo $name; ?>" required >
                </div>

                <div class="detail-row">
                    <label class="hidden lg:block" for="fullName">Full Name: <span class="text-red-500">*</span></label>
                    <input class="inputs  w-full lg:w-1/2" type="text" id="fullName" name="fullName" value="<?php echo $fullName; ?>" required>
                </div>

                <div class="detail-row">
                    <label class="hidden lg:block" for="department">Department: <span class="text-red-500">*</span></label>
                    <input class="inputs  w-full lg:w-1/2" type="text" id="department" name="department" value="<?php echo $department; ?>" required>
                </div>

                <div class="detail-row">
                    <label class="hidden lg:block" for="mobileNo">Mobile: <span class="text-red-500">*</span></label>
                    <input class="inputs  w-full lg:w-1/2" type="tel" id="mobileNo" name="mobileNo" value="<?php echo $mobileNo; ?>" required>
                </div>
                
                <div class="detail-row">
                    <input type="button" value="< Back" onclick="history.back()" class="btn outline-btn mr-3">
                    <input class="inputs w-full lg:w-1/2 btn fill-btn" type="submit"  name ="submit" value="Update" class="btn fill-btn">
                </div>
                    
            </div>    
        </div>
    </form>

</div>


