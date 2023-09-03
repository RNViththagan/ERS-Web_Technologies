<?php



?>

<?php

    if (isset($_POST['submit'])) {
        $unitCode = $_POST["unitCode"];
        $unitName = $_POST["unitName"];
        $subject = $_POST["subject"];
        $level = $_POST["level"];
        $acYear = $_POST["acYear"];

            $query = "SELECT unitCode from unit where unitCode ='$unitCode' ";

            if (mysqli_num_rows(mysqli_query($con, $query))) {

                $msg[0] = "Unit already added!";
                $msg[1] = "warning";
            } else {
                $query = "INSERT INTO unit (unitCode, name, subject, level, acYearAdded) values('$unitCode', '$unitName', '$subject', '$level', '$acYear')";
                if (!mysqli_query($con, $query)) {

                    $msg[0] = "error!";
                    $msg[1] = "warning";
                } else {
                    $query = "INSERT INTO unit (unitCode, name, subject, level, acYearAdded) values('$unitCode', '$unitName', '$subject', '$level', '$acYear')";
                    mysqli_query($con, $query);
                    $msg[0] = "Successfully added!";
                    $msg[1] = "done";
                }
            }
        }
        
    


?>





        <h1 class="titlehead">Add Unit</h1>
        <div class="container">
            <form action="" method="post">
                <?php
                if (isset($msg)) {
                    echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
                }
                ?>
                <div class="formcomp">
                    <label for="unitCode">Unit Code: </label>
                    <input type="text" name="unitCode" required>
                </div>

                <div class="formcomp">
                    <label for="unitName">Unit Name: </label>
                    <input type="text" name="unitName" required>
                </div>

                <div class="formcomp">
                    <label for="subject">Subject: </label>
                    <select name = "subject" required>
                    <?php
                        // Fetch distinct exam names from the database
                        $Subject = "SELECT subject FROM subject";
                        $result = $con->query($Subject);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["subject"] ."' >" . $row["subject"] . "</option>";    
                            }
                        }
                    ?>
                    </select>
                </div>

                <div class="formcomp">
                    <label for="level">Level: </label>
                    <select name = "level" required>
                        <option value = "1">1</option>
                        <option value = "2">2</option>
                        <option value = "3">3</option>
                        <option value = "4">4</option>
                    </select>
                </div>

                <div class="formcomp">
                    <label for="acYear">Academic Year: </label>
                    <input type="text" name="acYear" required>
                </div>
                
                <div class="formcomp formbutton">
                    <input type="submit" name="submit" value="Add">
                </div>
            </form>
            <!-- <a href="index.php?page=stud">
                <button>Back</button>
            </a> -->
        </div>
