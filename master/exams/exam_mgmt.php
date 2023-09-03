<?php
    $get_exams = "SELECT *
        FROM exam_reg
        ORDER BY academic_year DESC, semester DESC LIMIT 5;";
    $res = mysqli_query($con, $get_exams);
?>
</head>


<?php if (isset($error['add error'])) echo $error['add error']; ?>


<div class="w-10/12 mx-auto">
    <div class="w-full flex items-center justify-between">
        <h1 class="title">Exams</h1>
        <a href="?page=add">
            <button class="btn fill-btn">add</button>
        </a>
    </div>
    <hr class="my-5">
    <table class="w-full text-center">
        <tr class="h-12 bg-blue-100 font-semibold">
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
                <tr class="h-12 odd:bg-blue-50">
                    <td><?php echo $fetch['academic_year'] ?></td>
                    <td><?php echo $fetch['semester'] ?></td>
                    <td><?php echo $fetch['closing_date'] ?></td>
                    <td><?php echo $fetch['status'] ?></td>
                    <td>
                        <button onclick="edit(<?php echo $fetch['exam_id'] ?>)" class="btn outline-btn !py-1">Edit</button>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr class='h-12 odd:bg-blue-50'>
                      <td colspan='5'>No record found</td>
                  </tr>";
        }
    
        ?>
    
    </table>
</div>


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
