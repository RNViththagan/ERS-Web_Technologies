<?php

require($_SERVER['DOCUMENT_ROOT'] . '/ERS-Web_Technologies/vendor/autoload.php'); // Include PHPMailer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$examID = $exam['exam_id'];

if (isset($_POST['regNo'])) {
    $regNo = $_POST['regNo'];
    $action = (isset($_POST['accept'])) ? "accepted" : "rejected";

    $sql = "UPDATE `repeat_slips` SET `status`='$action' WHERE `exam_id`=$examID AND `reg_id`='$regNo'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        header("Location: index.php?page=slips&error=Something went wrong!");
    } else {
        if ($action === 'rejected') {
            $sql = "SELECT `email` FROM `student_check` WHERE `regNo`='$regNo'";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) == 1) {
                $mail = new PHPMailer(true);
                $student = mysqli_fetch_assoc($result);
                $email = $student['email'];
    
                if ($data_check) {
                    $subject = "ERS - Repeat Exam Payment Slip Rejected";
                    $message = "Your payment slip for the repeate exam/s have been Rejected. Please contact the dean office for further details.";
                    $sender_name = "Exam Registration System | Faculty of Science";
                    $sender_mail = "ers.fos.csc@gmail.com";
                    $htmlBody = '
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset="UTF-8">
                            <title>OTP Email</title>
                        </head>
                        <body style="font-family: Arial, sans-serif; background-color: #f0f0f0; padding: 20px;">
                            <div style="background-color: #ffffff; border-radius: 10px; padding: 20px; max-width: 400px; margin: 0 auto;">
                                <h2 style="color: #333; text-align: center;">Exam Registration System</h2>
                                <p>Your payment slip for the repeate exam/s have been Rejected. Please contact the dean office for further details.</p>
                                <p>Thank you!</p>
                            </div>
                        </body>
                        </html>
                        ';
        
                    try {
                        // SMTP configuration
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'ers.fos.csc@gmail.com';
                        $mail->Password = 'izvixydstkhxvpsf';
                        $mail->SMTPSecure = 'tls'; // Use TLS
                        $mail->Port = 587;
        
                        // Recipients and content
                        $mail->setFrom($sender_mail, $sender_name);
                        $mail->addAddress($email, $regNo);
                        $mail->Subject = $subject;
                        //$mail->Body = $message;
                        $mail->msgHTML($htmlBody);
        
                        // Send email
                        $mail->send();
                    } catch (Exception $e) {
                        header("Location: index.php?page=slips&error=Failed while sending code!");
                    }
                } else {
                    header("Location: index.php?page=slips&error=Failed while inserting data into database!");
                }
            }
        }
        echo "<script>objectElementParentElement.removeChild(objectElement);</script>";
    }    
}

$current_page = isset($_GET['no']) ? intval($_GET['no']) : 1;
$records_per_page = 10;
$offset = ($current_page - 1) * $records_per_page;

$sql = "SELECT rs.*, s.regNo, s.title, s.fullName, s.nameWithInitial, i.indexNo FROM `repeat_slips` rs 
        INNER JOIN `student` s ON rs.reg_id = s.regNo
        INNER JOIN `exam_stud_index` i ON rs.reg_id = i.regNo
        WHERE i.exam_id = $examID AND rs.status = 'pending'";

$limit = " LIMIT $offset, $records_per_page";

$searchOp = "";
if (isset($_POST['search'])) {
    $searchkey = $_POST['searchkey'];
    $searchOp = " rs.reg_id LIKE '%$searchkey%' or s.nameWithInitial LIKE '%$searchkey%' or i.indexNo LIKE '%$searchkey%'";
    if ($searchOp != "") $sql .= " AND " . $searchOp;
}

$forcount = $sql;
$sql .= $limit;
$stdlist = mysqli_query($con, $sql);

?>

<div class="static flex flex-col items-center justify-around gap-5">
    <h1 class="title !mb-5">Repeat Payment Slips</h1>

    <form  id="searchform" action="index.php?page=slips" method="post" class="flex items-center gap-5">
        <div class="search-bar w-96 h-10 border-2 border-gray-500 rounded-full flex items-center gap-5 px-5">
            <i class="bi bi-search"></i>
            <input type="text" name="searchkey" placeholder="Search Here" value="<?php echo (isset($searchkey)) ? $searchkey : "" ?>" class="outline-none h-full w-full" required>
        </div>
        <button class="btn fill-btn" type="submit" name="search">Search</button>
    </form>

    <table class="w-10/12 text-center">
        <tr class="h-12 bg-blue-100 font-semibold">
            <th>Reg No</th>
            <th>Name</th>
            <th>Index No</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        if (mysqli_num_rows($stdlist) > 0) {
        while ($row = mysqli_fetch_assoc($stdlist)) {
            $regID = $row['regNo'];
            $indexNo = $row['indexNo'];
            $name = ($row['title'] != "") ? $row['title'] . ". " . $row['nameWithInitial'] : $row['nameWithInitial'];
            $fullName = $row['fullName'];
            $status = $row['status'];
            ?>
            <tr class="h-12 odd:bg-blue-50">
                <td><?php echo $regID; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $indexNo; ?></td>
                <td><?php echo $status; ?></td>
                <td>
                    <button onclick="view(<?php echo '\''.$regID.'\', \''.$fullName.'\', \''.$indexNo.'\', \''.$row['fileName'].'\'' ?>)" class="btn outline-btn !py-1">View</button>
                </td>
            </tr>
            
            <?php
        }
        } else {
            echo "<tr class='h-12 odd:bg-blue-50'>
                     <td colspan='4'>No record found</td>
                  </tr>
                ";
        }
        ?>
    </table>

    <div id="slips-modal" class="hidden fixed !-left-[12.5%] !-top-[20%] z-40 w-[calc(100vw-300px)] p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen backdrop-blur-md bg-zinc-900/50">
        <div class="w-[87.5%] max-h-full mx-auto py-16">
            <!-- Modal content -->
            <div class="bg-zinc-700 rounded-2xl shadow px-5 py-3">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t text-white">
                    <h3 class="text-xl font-semibold text-white">
                        <span id="regIDSpan" class="mr-1 text-lg"></span>
                        Payment Slip
                    </h3>
                    <form method="post" action="index.php?page=slips" class="flex items-center gap-5">
                        <input type="hidden" name="regNo" id="regIDInput">
                        <input type="submit" value="Accept" name="accept" class="btn fill-btn !bg-green-500">
                        <input type="submit" value="Reject" name="reject" class="btn fill-btn !bg-red-500">
                        <button id="close-btn" type="button" class="text-zinc-100 bg-transparent hover:bg-white hover:text-zinc-800 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </form>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6" id="objectElementParentElement">
                    <div class="w-2/3 grid grid-cols-3 items-center text-white">
                        <p>Index Number</p>
                        <span class="col-span-2" id="indexNoSpan"></span>
                    </div>
                    <div class="w-2/3 grid grid-cols-3 items-center text-white">
                        <p>Registration Number</p>
                        <span class="col-span-2" id="regNoSpan"></span>
                    </div>
                    <div class="w-2/3 grid grid-cols-3 items-center text-white mb-10">
                        <p>Full Name</p>
                        <span class="col-span-2" id="fullName"></span>
                    </div>
                    <!-- <object data="../assets/uploads/slips/sankavi_payment_slips.pdf" type="application/pdf" width="100%" height="600px">
                        <p>Unable to display PDF file. <a href="../assets/uploads/slips/sankavi_payment_slips.pdf">Download</a> instead.</p>
                    </object> -->
                </div>
                <!-- Modal footer -->
                <form method="post" action="index.php?page=slips" class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                    
                </form>
            </div>
        </div>
    </div>


    <div class="w-1/2 flex items-center justify-around mt-10">
        <?php
        $prev_page = $current_page - 1;
        $next_page = $current_page + 1;

        if ($prev_page > 0) {
            echo "<button onclick='pagechange($prev_page)' class='btn outline-btn'>< Previous</button>";
        }


        $count_result = mysqli_query($con, $forcount);
        $total_records = $count_result->num_rows;

        $total_pages = ceil($total_records / $records_per_page);

        if ($next_page <= $total_pages) {
            echo "<button onclick='pagechange($next_page)' class='btn outline-btn'>Next ></button>";
        }
        ?>
    </div>

</div>


<script>
    function view(regNo, fullName, indexNo, $fileName) {
        const modal = document.getElementById('slips-modal');
        const modalCloseBtn = document.getElementById('close-btn');
        const regIDSpan = document.getElementById('regIDSpan');
        const regIDInput = document.getElementById('regIDInput');
        const indexNoSpan = document.getElementById('indexNoSpan');
        const regNoSpan = document.getElementById('regNoSpan');
        const fName = document.getElementById('fullName');
        const fileName = document.getElementById('fileName');
        const objectElementParentElement = document.getElementById('objectElementParentElement');

        const objectElement = document.createElement('object');
        const objectElementFailText = document.createElement('p');
        const objectElementFailLink = document.createElement('a');

        modal.classList.remove('hidden');
        modalCloseBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            objectElementParentElement.removeChild(objectElement);
        })
        regIDSpan.innerHTML = regNo;
        regIDInput.value = regNo;
        indexNoSpan.innerHTML = ": " + indexNo;
        regNoSpan.innerHTML = ": " + regNo;
        fName.innerHTML = ": " + fullName;

        objectElement.data = "../assets/uploads/slips/" + $fileName;
        objectElement.type = "application/pdf";
        objectElement.width = "100%";
        objectElement.height = "600px";

        objectElementFailLink.href = "../assets/uploads/slips/" + $fileName;
        objectElementFailLink.classList.add('text-blue-500', 'underline');
        objectElementFailLink.innerHTML = "Download";
        objectElementFailLink.target = "_blank";

        objectElementFailText.innerHTML = "Unable to display PDF file. ";
        objectElementFailText.appendChild(objectElementFailLink);
        objectElementFailText.innerHTML += " instead.";
        objectElementFailText.classList.add('mt-24', 'text-center');

        objectElement.appendChild(objectElementFailText);
        objectElementParentElement.appendChild(objectElement);
    }


    formid ="";
    var subName = document.createElement('input');

    <?php
    if (isset($_POST['search']))
        echo "formid = 'searchform';\nsubName.name = 'search';";
    ?>
    

    const parentElement = document.getElementById(formid);
    function pagechange(no) {
        var myform = document.createElement("form");
        myform.action = "index.php?page=stud&no="+no;
        myform.method = "post";
        myform.style.display = "none"; // Hide the form
        if(formid!="") {
            const childElements = parentElement.children;
            for (const child of childElements) {
                myform.appendChild(child.cloneNode(true));
            }
            myform.appendChild(subName);
        }
        document.body.appendChild(myform);
        console.log(myform);
        myform.submit()
    }

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>