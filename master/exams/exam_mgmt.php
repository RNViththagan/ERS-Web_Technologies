<?php
$get_exams = "SELECT *
FROM exam_reg
ORDER BY academic_year DESC, semester DESC LIMIT 5;";
$res = mysqli_query($con, $get_exams);
?>
<style>
    /* Add styles for the "Add" button */
    .add-button-container {
        display: flex;
        justify-content: flex-end;
        padding: 10px;
    }

    /* Add styles for the table */
    table {
        border-collapse: collapse;
        width: 80%;
        max-width: 800px;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Add styles for the "Edit" buttons */
    button {
        padding: 5px 10px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
</head>

<div class="add-button-container">
    <a href="?page=add">
        <button>add</button>
    </a>
</div>
<?php if (isset($error['add error'])) echo $error['add error']; ?>

<h1>Exams</h1>
<hr>
<table border="1">
    <tr>
        <th>academic_year</th>
        <th>semester</th>
        <th>closing_data</th>
        <th>status</th>
        <th>action</th>
    </tr>

    <?php
    if (mysqli_num_rows($res) > 0) {
        while ($fetch = mysqli_fetch_assoc($res)) {
            ?>
            <tr>
                <td><?php echo $fetch['academic_year'] ?></td>
                <td><?php echo $fetch['semester'] ?></td>
                <td><?php echo $fetch['closing_date'] ?></td>
                <td><?php echo $fetch['status'] ?></td>
                <td>
                    <button onclick="edit(<?php echo $fetch['exam_id'] ?>)">Edit</button>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr >
                  <td colspan='5'>No record found</td>
              </tr>";
    }

    ?>

</table>
<script>
    function edit(id) {
        var myform = document.createElement("form");
        myform.action = "index.php?page=edit";
        myform.method = "post";
        var inp = document.createElement('input');
        inp.name = "exedid";
        inp.value = id;
        inp.type = "hidden";
        myform.appendChild(inp);
        document.body.appendChild(myform);
        console.log(myform);
        myform.submit()
    }
</script>
