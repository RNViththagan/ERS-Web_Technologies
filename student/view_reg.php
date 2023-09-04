<?php
include("../config/connect.php");
print_r($_POST);
echo "<br>";
print_r($_GET);
if(isset($_POST['regId'])) {
    $regId = $_POST['regId'];

    $sql = "SELECT level, type FROM stud_exam_reg WHERE `regId` = $regId";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $level = $row['level'];
        $type = $row['type'];
        echo "Level: $level, Type: $type";
    } else {
        header("Location: index.php?error=No registration found with regId: $regId");
        exit();
    }
}
?>