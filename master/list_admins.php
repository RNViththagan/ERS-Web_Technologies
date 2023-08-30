<?php
$get_admins = "SELECT admin.email,`admin`.name,`admin`.`role`, `admin_details`.department, admin.status 
FROM `admin` 
    LEFT JOIN `admin_details` ON `admin_details`.`email` = `admin`.`email`";


$role = "";
$status = "";
$filterOp = "";
$current_page = isset($_GET['no']) ? intval($_GET['no']) : 1;
$records_per_page = 10;
$offset = ($current_page - 1) * $records_per_page;


$sql = "SELECT * FROM student";
if (isset($_POST['filter'])) {

    $role = $_POST['role'];
    $dept = $_POST['dept'];
    $status = $_POST['status'];
    if ($role != "none")
        $filterOp .= " role LIKE '$role%'";
    if ($dept != "none") {
        if ($filterOp != "") $filterOp .= " And ";
        $filterOp .= " department LIKE '%$dept%'";
    }
    if ($status != "none") {
        if ($filterOp != "") $filterOp .= " And ";
        $filterOp .= " status = '$status'";
    }
}
if ($filterOp != "") $get_admins .= " Where " . $filterOp;

$searchOp = "";
if (isset($_POST['search'])) {
    $search_key = $_POST['search_key'];
    $searchOp = " admin.email like '%$search_key%' or name like '%$search_key%'";
    if ($searchOp != "") {
        $get_admins .= " Where " . $searchOp;
    }
}

$adminlist = mysqli_query($con, $get_admins);

?>
<link rel="stylesheet" type="text/css" href="../assets/css/style_admin_student.css">
        <h1>Admin Management</h1>

        <form action="" method="post">
            <input type="text" name="search_key" required>
            <button type="submit" name="search">Search</button>
        </form>

        <a href="index.php?page=addAdmin">
            <button id="add"> Add</button>
        </a>

        <div class="filter">
            <form method="post" action="">

                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="none"></option>
                    <?php
                    // Fetch distinct exam names from the database
                    $distinctYear = "SELECT DISTINCT role FROM admin";
                    $result = $con->query($distinctYear);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["role"] . "' ";
                            echo ($role == $row["role"]) ? "selected" : "";
                            echo ">" . $row["role"] . "</option>";
                        }
                    }
                    ?>
                </select>

                <label for="dept">Dept</label>
                <select for="dept" name="dept">
                    <option value="none"></option>
                    <?php
                    // Fetch distinct exam names from the database
                    $distinctDept = "SELECT DISTINCT department FROM admin_details";
                    $result = $con->query($distinctDept);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if($row["department"]=="") continue;
                            echo "<option value='" . $row["department"] . "' ";
                            echo ($dept == $row["department"]) ? "selected" : "";
                            echo ">" . $row["department"] . "</option>";
                        }
                    }
                    ?>
                </select>

                <label for="status">Status</label>
                <select for="status" name="status">
                    <option value="none"></option>
                    <?php
                    // Fetch distinct exam names from the database
                    $distinctStatus = "SELECT DISTINCT status FROM admin";
                    $result = $con->query($distinctStatus);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["status"] . "' ";
                            echo ($status == $row["status"]) ? "selected" : "";
                            echo ">" . $row["status"] . "</option>";
                        }
                    }
                    ?>
                </select>

                <button type="submit" name="filter" value="Filter">Filter</button>

            </form>

        </div>
        <table>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Role</th>
                <th>Department</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($adminlist)) {
                ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <button onclick="view('<?php echo $row['email']; ?>')">View</button>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        $prev_page = $current_page - 1;
        $next_page = $current_page + 1;

        echo "<br>";
        if ($prev_page > 0) {
            echo "<a href='?page=$prev_page'><button>Previous</button></a> ";
        }


        $count_sql = "SELECT COUNT(*) AS total FROM admin";
        $count_result = mysqli_query($con, $count_sql);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_records = $count_row['total'];

        $total_pages = ceil($total_records / $records_per_page);

        if ($next_page <= $total_pages) {
            echo "<a href='?page=manageAdmin&no=$next_page'><button>Next</button></a>";
        }
        ?>



    <script>
        function view(adminId) {
            var myform = document.createElement("form");
            myform.action = "";
            myform.method = "post";
            var inp = document.createElement('input');
            inp.name = "adminId";
            inp.value = adminId;
            inp.type = "hidden";
            myform.appendChild(inp);
            document.body.appendChild(myform);
            console.log(myform);
            myform.submit()
        }
    </script>


