<?php
ob_start();
if(!isset($_SESSION)){session_start();}
require_once ($_SERVER['DOCUMENT_ROOT'] . '/config/connect.php');
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


    <style>


        h1 {
            text-align: center;
            margin-top: 20px;
        }

        h2 {
            margin-top: 20px;
        }

        form {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="number"],
        select,
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>


<form action="index.php" method="POST" onsubmit="return validateForm()">
    <?php if($edit) echo "<input type='hidden' name='exam_id' value='$exam_id'>";?>

    Academic Year: <input type="number" name="academic_year" id="academic_year" min="<?php echo $maxPreviousYear?>" max="2099" step="1" value="<?php echo $year?>" <?php if($edit) echo "disabled"?> required><br>
    <input type="hidden" id="max_previous_year" value="<?php echo $maxPreviousYear; ?>">
    Semester:
    <select name="semester" required <?php if($edit) echo "disabled"?>>
        <option value="1">1</option>
        <option value="2" <?php if(($edit and $ed_sem ==2) or ($counyear == 1)) echo "selected"?>>2</option>
    </select><br>
    Status:
    <select name="status" required>
        <option value="draft">Draft</option>
        <option value="registration" <?php if($edit and $status =="registration") echo "selected"?>>Registration</option>
        <option value="closed" <?php if($edit and $status =="closed") echo "selected"?>>Closed</option>
        <option value="hidden" <?php if($edit and $status =="hidden") echo "selected"?>>Hidden</option>
    </select><br>
    closing date:
    <input name="close_date" type="date" min="<?php echo ($edit)?"$closing_date":date('Y-m-d'); ?>" <?php if($edit) echo "value='$closing_date'"?> required><br>

    <input type="submit" name="<?php echo ($edit)? 'ed_exm':'add_exm';?>" value="<?php echo ($edit)? 'Save':'add_exm';?>" required>
</form>
<a href="index.php"><button>Exams</button></a>


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
