<?php
print_r($_POST);
echo "<br>";
print_r($_GET);
$msg = [];

$getCurrentExam = "SELECT * FROM exam_reg WHERE status = 'draft'";
$result = mysqli_query($con, $getCurrentExam);

if ($result->num_rows > 0) {
    $curExam = mysqli_fetch_assoc($result);
    if ($_GET['page'] === "asignUnits") {
        if (isset($_POST['unit_subjects'])) {
            $exam_id = $_POST['exam_id'];
            $level = $_POST['level'];
            $subject = $_POST['subject'];
            $type = $_POST['type'];
            $unit_subjects = $_POST['unit_subjects'];

            $delete_query = "DELETE FROM `unit_sub_exam`
                            WHERE exam_unit_id IN (
                                            SELECT `unit_sub_exam`.`exam_unit_id`
                                FROM `unit_sub_exam`
                                LEFT JOIN `unit` ON `unit_sub_exam`.`unitId` = `unit`.`unitId`
                                WHERE unit_sub_exam.exam_id = $exam_id
                                        AND subject = '$subject'
                                        AND type = '$type'
                            );";

            if (!mysqli_query($con, $delete_query)) {
                $msg['error'] = "Error deleting units: " . mysqli_error($con);
            }

            $assignQuery = "INSERT INTO `unit_sub_exam` (`exam_id`, `unitId`, `type`) VALUES ";
            $fst = true;
            foreach ($unit_subjects as $unit) {
                $assignQuery .= ($fst) ? $fst = false : ", ";
                $assignQuery .= "($exam_id, $unit, '$type')";
            }

            if (!mysqli_query($con, $assignQuery)) {
                $msg['error'] = "Error assigning units: " . mysqli_error($con);
            } else {
                $msg['success'] = "Units assigned successfully.";
            }
            include("subject_level_form.php");
        } else {
            include("subject_level_form.php");
        }
    }
}

?>
