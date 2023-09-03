<?php
ob_start();
if(!isset($_SESSION)){session_start();}
require_once ('../../config/connect.php');
$edit =false;
if(isset($_POST['exedid'])) {
    $edit =true;
    $exam_id= $_POST['exedid'];
    $cur_ex_detail ="SELECT *
        FROM exam_reg
        WHERE exam_id = $exam_id";
    $cur_ex = $con->query($cur_ex_detail)->fetch_assoc();
    $ed_year =$cur_ex ['academic_year'];
    $ed_sem =$cur_ex ['semester'];
    $status =$cur_ex ['status'];
    $closing_date =$cur_ex ['closing_date'];



    $sql_previous_year = "SELECT MAX(academic_year) as max_year, COUNT(*) as year_count
        FROM exam_reg
        WHERE academic_year = (SELECT MAX(academic_year) FROM exam_reg where academic_year < '$ed_year')";

    $fetch = $con->query($sql_previous_year)->fetch_assoc();

    $counyear = $fetch['year_count'];
    $maxPreviousYear = ($counyear == 2) ? $fetch['max_year'] + 1 : $fetch['max_year'];
    $year = $ed_year;

}
else if( isset($_GET['page']) AND ($_GET['page'] == "add")){
        $sql_previous_year = "SELECT MAX(academic_year) as max_year, COUNT(*) as year_count
        FROM exam_reg
        WHERE academic_year = (SELECT MAX(academic_year) FROM exam_reg);";
    $fetch = $con->query($sql_previous_year)->fetch_assoc();
    $counyear = $fetch['year_count'];
    $maxPreviousYear = ($counyear == 2) ? $fetch['max_year'] + 1 : $fetch['max_year'];
    $year = $maxPreviousYear;
}
else{
    header("Location:index.php");
}
?>


<form action="index.php" method="POST" onsubmit="return validateForm()" class="w-[500px] mx-auto flex flex-col items-center gap-4">
    <?php echo ($edit == false) ? "<h1 class='title mb-5'>Add Exam</h1>" : "<h1 class='title mb-5'>Edit Admin</h1>";?>

    <?php if($edit) echo "<input type='hidden' name='exam_id' value='$exam_id'>";?>

    <div class="w-full grid grid-cols-3 items-center h-10">
        <label for="academic_year">Academic Year:</label>
        <input type="number" name="academic_year" id="academic_year" min="<?php echo $maxPreviousYear?>" max="2099" step="1" value="<?php echo $year?>" <?php if($edit) echo "disabled"?>  class="col-span-2 w-full h-full border-2 border-gray-400 rounded-full px-5 outline-none focus:border-blue-500" required>
    </div>

    <input type="hidden" id="max_previous_year" value="<?php echo $maxPreviousYear; ?>">

    <div class="w-full grid grid-cols-3 items-center h-10">
        <label for="semester">Semester:</label>
        <select name="semester" required <?php if($edit) echo "disabled"?> id="semester" class="col-span-2 w-full h-full border-2 border-gray-400 rounded-full px-5 outline-none focus:border-blue-500">
            <option value="1">1</option>
            <option value="2" <?php if(($edit and $ed_sem ==2) or ($counyear == 1)) echo "selected"?>>2</option>
            <option value="hidden" <?php if($edit and $status =="hidden") echo "selected"?>>Hidden</option>
        </select>
    </div>
    <div class="w-full grid grid-cols-3 items-center h-10">
        <label for="status">Status:</label>
        <select name="status" id="status" class="col-span-2 w-full h-full border-2 border-gray-400 rounded-full px-5 outline-none focus:border-blue-500" required>
            <option value="draft">draft</option>
            <option value="registration" <?php if($edit and $status =="registration") echo "selected"?>>registration</option>
            <option value="closed" <?php if($edit and $status =="closed") echo "selected"?>>closed</option>
        </select>
    </div>
    <div class="w-full grid grid-cols-3 items-center h-10">
        <label for="close_date">closing date:</label>
        <input name="close_date" id="close_date" type="date" min="<?php echo ($edit)?"$closing_date":date('Y-m-d'); ?>" <?php if($edit) echo "value='$closing_date'"?> class="col-span-2 w-full h-full border-2 border-gray-400 rounded-full px-5 outline-none focus:border-blue-500" required>
    </div>

    <div class="w-full grid grid-cols-3 items-center h-10 gap-5 mt-5 mb-10">
        <input type="button" value="< Back" onclick="history.back()" class="btn outline-btn">
        <input type="submit" name="<?php echo ($edit)? 'ed_exm':'add_exm';?>" value="<?php echo ($edit)? 'Save':'add_exm';?>" class="col-span-2 w-full btn fill-btn" required>
    </div>
</form>


<script>
    function validateForm() {
        var academicYearInput = document.getElementById("academic_year");
        var academicYear = parseInt(academicYearInput.value);

        var maxPreviousYear = parseInt(document.getElementById("max_previous_year").value);

        var closeDateInput = document.getElementsByName("close_date")[0];
        var closeDate = new Date(closeDateInput.value);

        var today = closeDate.min;
        console.log(today);

        if (isNaN(academicYear) || academicYear < maxPreviousYear) {
            alert("Please enter a valid academic year greater than or equal to the previous year.");
            academicYearInput.focus();
            return false;
        }

        if (closeDate <= today) {
            alert("Closing date must be greater than today's date.");
            closeDateInput.focus();
            return false;
        }
    }
</script>
