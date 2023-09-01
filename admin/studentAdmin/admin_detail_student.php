<?php
if (isset($_POST['regNo'])) {
    $regNo = $_POST['regNo'];
    $query = "SELECT * FROM student INNER JOIN student_check ON student.regNo = student_check.regNo WHERE student.regNo = '".$regNo."'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}

?>


<link rel="stylesheet" type="text/css" href="../../assets/css/style_admin_student.css">

        <a href="index.php?page=stud"><button>Back</button></a>
        <h1>View Student Profile</h1>

        <table>
            <tr>
                <td>Registration No:</td>
                <td> <?php echo $row['regNo']; ?> </td>
            </tr>
            <tr>
                <td>Status:</td>
                <td> <?php echo $row['status']; ?> </td>
            </tr> 
            <tr>
                <td>Email:</td>
                <td> <?php echo $row['email']; ?> </td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td> <?php echo $row['fullName']; ?> </td>
            </tr>
            <tr>
                <td>Name with Initials:</td>
                <td> <?php echo $row['nameWithInitial']; ?> </td>
            </tr>
            <tr>
                <td>District:</td>
                <td> <?php echo $row['district']; ?> </td>
            </tr>
            <tr>
                <td>Mobile No:</td>
                <td> <?php echo $row['mobileNo']; ?> </td>
            </tr>
            <tr>
                <td>Home Tp No:</td>
                <td> <?php echo $row['landlineNo']; ?> </td>
            </tr>
            <tr>
                <td>Home Address:</td>
                <td> <?php echo $row['homeAddress']; ?> </td>
            </tr>
            <tr>
                <td>Address in Jaffna:</td>
                <td> <?php echo $row['addressInJaffna']; ?> </td>
            </tr>

        </table>

        <button onclick="edit('<?php echo $row['regNo']; ?>')">Edit</button>


    <script>
        function edit(regNo) {
            var myform = document.createElement("form");
            myform.action = "index.php?page=editStud";
            myform.method = "post";
            var inp = document.createElement('input');
            inp.name = "regNo";
            inp.value = regNo;
            inp.type = "hidden";
            myform.appendChild(inp);
            document.body.appendChild(myform);
            console.log(myform);
            myform.submit()
        }
    </script>

