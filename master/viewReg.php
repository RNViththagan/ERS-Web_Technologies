<?php

$getCurrentExam = "SELECT * FROM exam_reg WHERE status = 'closed';";
$result = mysqli_query($con, $getCurrentExam);
if ($result->num_rows > 0) {
    $curExam = mysqli_fetch_assoc($result);
}
$aExamID= $curExam['exam_id'];
$form ="select";
?>

<?php include("../reg_list.php") ?>


