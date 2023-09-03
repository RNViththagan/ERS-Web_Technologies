<?php

$current_page = isset($_GET['no']) ? intval($_GET['no']) : 1;
$records_per_page = 10;
$offset = ($current_page - 1) * $records_per_page;


$sql = "SELECT * FROM student INNER JOIN student_check ON student.regNo = student_check.regNo";
$limit = " LIMIT $offset, $records_per_page";


$year = "";
$dept = "";
$status = "";
$student_regNo = "";
$filterOp = "";

if (isset($_POST['filter'])) {
    $year = $_POST['year'];
    $dept = (isset($_POST['dept']))?$_POST['dept']:"none";
    $status = (isset($_POST['status']))?$_POST['status']:"none";
    if ($year != "none")
        $filterOp .= " student.regNo LIKE '$year%'";
    if ($dept != "none") {
        if ($filterOp != "")
            $filterOp .= " And ";
        $filterOp .= " student.regNo LIKE '%$dept%'";

    }
    if ($status != "none") {
        if ($filterOp != "")
            $filterOp .= " And ";
        $filterOp .= " student_check.status = '$status'";
    }
}

if ($filterOp != "") {
    $sql .= " Where " . $filterOp;
}

$searchOp = "";
if (isset($_POST['search'])) {
    $searchkey = $_POST['searchkey'];
    $searchOp = " student.regNo LIKE '%$searchkey%' or student.nameWithInitial LIKE '%$searchkey%'";
    if ($searchOp != "") {
        $sql .= " Where " . $searchOp;
    }
}

$forcount = $sql;
$sql .= $limit;
$stdlist = mysqli_query($con, $sql);

?>
<link rel="stylesheet" type="text/css" href="../../assets/css/style_admin_student.css">
<h1>Student Management</h1>

<form  id="searchform"  action="index.php?page=stud" method="post">
    <input type="text" name="searchkey" value="<?php echo (isset($searchkey)) ? $searchkey : "" ?>" required>
    <button type="submit" name="search">Search</button>
</form>

<a href="index.php?page=addStud">
    <button id="add"> Add</button>
</a>

<div class="filter">
    <form id="filterform" method="post" action="index.php?page=stud">

        <label for="year">Year</label>
        <select name="year" id="year">
            <option value="none"></option>
            <?php
                $distinctYear = "SELECT DISTINCT SUBSTRING(regNo, 1, 4) AS starting_year FROM student";
                $result = $con->query($distinctYear);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["starting_year"] . "' ";
                        echo ($year == $row["starting_year"]) ? "selected" : "";
                        echo ">" . $row["starting_year"] . "</option>";
                    }
                }
            ?>
        </select>
        <?php

            $distinctDept = "SELECT DISTINCT SUBSTRING(SUBSTRING_INDEX(regNo, '/', 2), 6) AS code FROM student";
            $result = $con->query($distinctDept);
            if ($result->num_rows > 1) { ?>
                <label for="dept">Dept</label>
                <select for="dept" name="dept">
                    <option value="none"></option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["code"] . "' ";
                        echo ($dept == $row["code"]) ? "selected" : "";
                        echo ">" . $row["code"] . "</option>";
                    }
                    ?>
                </select>
            <?php
            }
        ?>
        <?php

            $distinctStatus = "SELECT DISTINCT status FROM student_check";
            $result = $con->query($distinctStatus);

            if ($result->num_rows > 1) { ?>
                <label for="status">Status</label>
                <select for="status" name="status">
                    <option value="none"></option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["status"] . "' ";
                        echo ($status == $row["status"]) ? "selected" : "";
                        echo ">" . $row["status"] . "</option>";
                    }
                    ?>
                </select>
                <?php
            }
        ?>
        <button type="submit" name="filter" value="Filter">Filter</button>

    </form>
    <a href="index.php?page=stud">
        <button id="add"> Reset</button>
    </a>

</div>
<table>
    <tr>
        <th>Reg No</th>
        <th>Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php
    if (mysqli_num_rows($stdlist) > 0) {
    while ($row = mysqli_fetch_assoc($stdlist)) {
        ?>
        <tr>
            <td><?php echo $row['regNo']; ?></td>
            <td><?php echo ($row['title'] != "") ? $row['title'] . ". " : "";
                echo $row['nameWithInitial']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <button onclick="view('<?php echo $row['regNo']; ?>')">View</button>
            </td>
        </tr>
        <?php
    }
    } else {
        echo "<tr>
                 <td colspan='4'>No record found</td>
              </tr>
                                    ";
    }
    ?>
</table>
<?php
$prev_page = $current_page - 1;
$next_page = $current_page + 1;

echo "<br>";
if ($prev_page > 0) {
    echo "<button  onclick='pagechange($prev_page)'>Previous</button>";
}


$count_result = mysqli_query($con, $forcount);
$total_records = $count_result->num_rows;

$total_pages = ceil($total_records / $records_per_page);

if ($next_page <= $total_pages) {
    echo "<button onclick='pagechange($next_page)'>Next</button>";
}
?>


<script>
    function view(regNo) {
        var myform = document.createElement("form");
        myform.action = "index.php?page=viewStud";
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
    formid ="";
    var subName = document.createElement('input');

    <?php
    if (isset($_POST['filter'])) {
        echo "formid = 'filterform';\n";
        echo "subName.name = 'filter';";
    }
    else if (isset($_POST['search']))
        echo "formid = 'searchform' \nsubName.name = 'search';";
    ?>
    

    const parentElement = document.getElementById(formid);
    function pagechange(no) {
        var myform = document.createElement("form");
        myform.action = "index.php?page=stud&no="+no;
        myform.method = "post";
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
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>