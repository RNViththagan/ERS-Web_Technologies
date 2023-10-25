<?php
ob_start();
if (!isset($_SESSION['role'])) {
    header("location:../login.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/config/connect.php');
require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

if (isset($_POST['upload'])) {
    $indexno = $_POST['indexno'];
    $regno = $_POST['regno'];
    $excel_file = $_FILES['excelFile']['name'];
    $extension = pathinfo($excel_file, PATHINFO_EXTENSION);
    if ($extension == 'csv') {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else if ($extension == 'xls') {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }
    $spreadsheet = $reader->load($_FILES['excelFile']['tmp_name']);
    $sheetdata = $spreadsheet->getActiveSheet()->toArray();
    $dataRowCount = count($sheetdata);
    $dataColCount = count($sheetdata[0]);
    $regnoIndex = 0;
    $indexNumberIndex = 0;
    for ($i=0; $i < $dataColCount; $i++) { 
        if ($sheetdata[0][$i] === $regno) {
            $regnoIndex = $i;
        } else if ($sheetdata[0][$i] === $indexno) {
            $indexNumberIndex = $i;
        }
    }
    if ($dataRowCount > 1) {
        $data = array();
        for ($i=1; $i < $dataRowCount; $i++) { 
            $regNo = $sheetdata[$i][$regnoIndex];
            $indexno = $sheetdata[$i][$indexNumberIndex];
            $data[] = array(
                'regNo'=> $regNo,
                'indexNo'=> $indexno,
            );
        }
    }

    foreach ($data as $user) {
        $regNo = $user['regNo'];
        $indexNo = $user['indexNo'];

        // Check the name validation
        $regNoPattern = '/^\d{4}\/[A-Z]+\/\d{3}$/';
        if (!preg_match($regNoPattern, $regNo)) {
            $msg[0] = "Invalid Registration No (XXXX/XXX/XXX)";
            $msg[1] = "text-red-500";
        } else {
            $query = "SELECT * from student_check where regNo = '$regNo'";
    
            if (mysqli_num_rows(mysqli_query($con, $query)) <= 0) {
                $msg[0] = "registration number not found!";
                $msg[1] = "text-red-500";
            } else {
                $getCurrentExam = "SELECT * FROM exam_reg WHERE status = 'draft'";
                $result = mysqli_query($con, $getCurrentExam);

                if ($result->num_rows > 0) {
                    $curExam = mysqli_fetch_assoc($result);
                    $exam_id = $curExam['exam_id'];
                }
                $query = "INSERT INTO exam_stud_index(exam_id,regNo,indexNo) values('$exam_id','$regNo','$indexNo')";
                if (!mysqli_query($con, $query)) {
                    $msg[0] = "error!";
                    $msg[1] = "text-red-500";
                } else {
                    $msg[0] = "Successfully added!";
                    $msg[1] = "text-green-500";
                }
            }
        }        
    }


}


?>

<div class="w-[500px] mx-auto flex flex-col items-center gap-4">
    <h1 class="title text-xl">Add Index Numbers (bulk Upload)</h1>
    <p class="mb-5 text-center tracking-wider font-normal">Please add the relevant column names for the registration numbers and Index numbers.</p>
    <form action="" method="post" class="w-full flex flex-col items-center gap-5" enctype="multipart/form-data">
        <?php
        if (isset($msg)) {
            echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
        }
        ?>

        <div class="w-full grid grid-cols-3 items-center h-10">
            <label for="regno">Excel File: </label>
            <input type="file" class="col-span-2 w-full h-full file:cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-[#5465ff] hover:file:bg-violet-100" name="excelFile" required>
        </div>
        <div class="w-full grid grid-cols-3 items-center h-10">
            <label for="regno">Registration No.: </label>
            <input type="text" placeholder="Excel files' relevant column name" class="col-span-2 w-full h-full border-2 border-gray-400 rounded-full px-5 outline-none focus:border-blue-500" name="regno" required>
        </div>
        <div class="w-full grid grid-cols-3 items-center h-10">
            <label for="email">Index Number: </label>
            <input type="text" placeholder="Excel files' relevant column name" class="col-span-2 w-full h-full border-2 border-gray-400 rounded-full px-5 outline-none focus:border-blue-500" name="indexno" required>
        </div>
        <div class="w-full grid grid-cols-3 items-center h-10 gap-5 mt-5 mb-2">
            <input type="button" value="< Back" onclick="history.back()" class="btn outline-btn">
            <input type="submit" class="col-span-2 w-full btn fill-btn" name="upload" value="Upload">
        </div>
    </form>
</div>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>