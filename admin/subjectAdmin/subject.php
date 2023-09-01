<?php

include("../../config/connect.php");

    $sql = "SELECT * FROM subject";
    $sublist = mysqli_query($con, $sql);

?>

<?php

    if (isset($_POST['submit'])) {
        $subject = strtoupper($_POST['subject']);

        // Check the name validation
        // $subjectPattern = '/^\d{4}\/[A-Z]+\/\d{3}$/';
        // if (!preg_match($subjectPattern, $subject)) {
        //     $msg[0] = "Invalid Subject (XXXX/XXX/XXX)";
        //     $msg[1] = "warning";
        // } else {
            $query = "SELECT * from subject where subject ='$subject' ";

            if (mysqli_num_rows(mysqli_query($con, $query))) {

                $msg[0] = "Subject already added!";
                $msg[1] = "warning";
            } else {
                $query = "INSERT INTO subject (subject) values('$subject')";
                if (!mysqli_query($con, $query)) {

                    $msg[0] = "error!";
                    $msg[1] = "warning";
                } else {
                    $query = "INSERT INTO subject (subject) values('$subject')";
                    mysqli_query($con, $query);
                    $msg[0] = "Successfully added!";
                    $msg[1] = "done";
                }
            }
        }


    //}

?>



<!DOCTYPE html>
    <head>
        <title></title>
    </head>

    <body>
        <div>
            <table>
                <tr>
                    <th>Subject</th>
                </tr>
                <?php
                    if (mysqli_num_rows($sublist) > 0) {
                    while ($row = mysqli_fetch_assoc($sublist)) {
                        ?>
                        <tr>
                            <td><?php echo $row['subject']; ?></td>
                        </tr>
                        <?php
                    }
                    } else {
                        echo "<tr>
                                <td>No record found</td>
                            </tr>
                                                    ";
                    }
                ?>
            </table>
        </div>

        <h1 class="titlehead">Add Subject</h1>
        <div class="container">
            <form action="" method="post">
                <?php
                if (isset($msg)) {
                    echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
                }
                ?>
                <div class="formcomp">
                    <label for="subject">Enter New Subject: </label>
                    <input type="subject" name="subject" required>
                </div>
                <div class="formcomp formbutton">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
            <!-- <a href="index.php?page=stud">
                <button>Back</button>
            </a> -->
        </div>
    </body>
</html>