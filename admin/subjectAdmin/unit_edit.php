<?php

include("../../config/connect.php");
    if (isset($_POST['unitId'])) {
        $unitId = $_POST['unitId'];
        $query = "SELECT * FROM unit WHERE unitId = '" . $unitId . "'";
        $result = mysqli_query($con, $query);
         $row = mysqli_fetch_assoc($result);
    }
    

    if (isset($_POST['save'])) {
        $unitId = $_POST['unitId'];
        $unitCode = $_POST["unitCode"];
        $unitName = $_POST["unitName"];
        $subject = $_POST["subject"];
        $level = $_POST["level"];
        $acYear = $_POST["acYear"];
        

    $query = "UPDATE unit SET unitCode = '$unitCode', name = '$unitName', subject = '$subject', level = '$level', acYearAdded = '$acYear' WHERE unitId = '$unitId'";
    $result = mysqli_query($con, $query);


    if ($result) {
        mysqli_close($con);
        echo '<body></body><script>
        function view(unitId) {
            var myform = document.createElement("form");
            myform.action = "../index.php?page=units";
            myform.method = "post";
            var inp = document.createElement("input");
            inp.name = "unitId";
            inp.value = unitId;
            inp.type = "hidden";
            myform.appendChild(inp);
            document.body.appendChild(myform);
            console.log(myform);
            myform.submit()
        }
    view("'.$unitId.'");</script>';
        
    } else {
        echo "Connection Failed : " . mysqli_connect_error();
    }

            // $query = "SELECT unitCode from unit where unitCode ='$unitCode' and acYearAdded = '$acYear'";

            // if (mysqli_num_rows(mysqli_query($con, $query))) {

            //     $msg[0] = "Unit already added!";
            //     $msg[1] = "warning";
            // } else {
            //     $query = "UPDATE unit SET unitCode = '$unitCode', unitName = '$unitName', subject = '$subject', level = '$level', acYearAdded = '$acYear' WHERE unitID =' $unitID'";
            //     if (!mysqli_query($con, $query)) {

            //         $msg[0] = "error!";
            //         $msg[1] = "warning";
            //     } else {
            //         $msg[0] = "Successfully Edited!";
            //         $msg[1] = "done";
            //     }
            // }
        }
        
    


?>


<link rel="stylesheet" href="../../assets/css/main.css">


        <h1 class="titlehead">Add Unit</h1>
        <div class="container">
            <form action="" method="post">
                <?php
                if (isset($msg)) {
                    echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
                }
                ?>

                <div class="formcomp">
                    <label for="unitId">Unit Code: </label>
                    <input type="hidden" name="unitId" value="<?php echo $row['unitId'];?>" required>
                </div>

                <div class="formcomp">
                    <label for="unitCode">Unit Code: </label>
                    <input type="text" name="unitCode" value="<?php echo $row['unitCode'];?>" required>
                </div>

                <div class="formcomp">
                    <label for="unitName">Unit Name: </label>
                    <input type="text" name="unitName" value="<?php echo $row['name'];?>" required>
                </div>

                <div class="formcomp">
                    <label for="subject">Subject: </label>
                    <select name = "subject" required>
                    <?php
                        $SubjectValue = "SELECT subject FROM subject";
                        $result = $con->query($SubjectValue);

                        if ($result->num_rows > 0) {
                            while ($row1 = $result->fetch_assoc()) { 
                                echo "<option value='" . $row1["subject"] . "' ";
                                echo ($row1["subject"] == $row["subject"]) ? "selected" : "";
                                echo   ">" . $row1["subject"] . "</option>";  
                            }
                        }
                    ?>
                    </select>
                </div>

                <div class="formcomp">
                    <label for="level">Level: </label>
                    <select name = "level" required>
                        <option value = "1" <?php echo ("1" == $row['level']) ? "selected" : ""; ?>>1</option>
                        <option value = "2" <?php echo ("2" == $row['level']) ? "selected" : ""; ?>>2</option>
                        <option value = "3" <?php echo ("3" == $row['level']) ? "selected" : ""; ?>>3</option>
                        <option value = "4" <?php echo ("4" == $row['level']) ? "selected" : ""; ?>>4</option>
                    </select>
                </div>

                <div class="formcomp">
                    <label for="acYear">Academic Year: </label>
                    <input type="text" name="acYear" value="<?php echo $row['acYearAdded'];?>" required>
                </div>
                
                <div class="formcomp formbutton">
                    <input type="submit" name="save" value="Save">
                </div>
            </form>
            <a href="index.php?page=units">
                <button>Back</button>
            </a>
        </div>
