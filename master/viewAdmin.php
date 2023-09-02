<?php
if (isset($_POST['adminId'])) {
    $adminId = $_POST['adminId'];
    $query = "SELECT *
FROM `admin` 
    LEFT JOIN `admin_details` ON `admin_details`.`email` = `admin`.`email` WHERE `admin`.`email` = '" . $adminId . "'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}

?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;900&display=swap");


    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    button{
        width: 80px;
        height: 30px;
        border-radius: 15px;
        font-size: 20px;
        margin-right: 5%;
    }

    table{
        width: 90%;
        border-collapse: collapse;
        text-align: left;
        overflow: hidden;
        margin: auto;
        margin-top: 20px;
    }

    th{
        padding: 20px 30px;
        letter-spacing: 2px;
        font-size: 25px;
    }

    td{
        padding: 15px 30px;
        letter-spacing: 2px;
        font-size: 18px;
    }

    tr:nth-child(even){
        background-color: #ececec;
    }



    .profile{
        display: flex;
    }

    .left{
        margin: auto;

    }

    .right{
        margin: auto;
        width : 60%
    }

    #user-pic2{
        width: 300px;
        height: 300px;
        cursor: pointer;
        margin-left: 10px;
        margin-right: 2px;
        border-radius: 50%;
        cursor: pointer;
    }

    input{
        border: 2px solid rgb(163, 163, 163);
        border-radius: 15px;
        width: 300px;
        height: 30px;
    }

</style>

<a href="index.php?page=listAdmins">
    <button>Back</button>
</a>
<h1>Admin Profile</h1>

<table>
    <tr>
        <td>Name:</td>
        <td> <?php echo $row['name']; ?> </td>
    </tr>
    <tr>
        <td>Email:</td>
        <td> <?php echo $row['email']; ?> </td>
    </tr>
    <tr>
        <td>Role:</td>
        <td> <?php echo $row['role']; ?> </td>
    </tr>
    <tr>
        <td>department:</td>
        <td> <?php echo $row['department']; ?> </td>
    </tr>
    <tr>
        <td>status:</td>
        <td> <?php echo $row['status']; ?> </td>
    </tr>
    <tr>
        <td>fullName:</td>
        <td> <?php echo $row['fullName']; ?> </td>
    </tr>
    <tr>
        <td>Mobile No:</td>
        <td> <?php echo $row['mobileNo']; ?> </td>
    </tr>
</table>

<button onclick="edit('<?php echo $row['email']; ?>')">Edit</button>
</div>

<script>
    function edit(editAdminId) {
        var myform = document.createElement("form");
        myform.action = "index.php?page=editAdmin";
        myform.method = "post";
        var inp = document.createElement('input');
        inp.name = "editAdminId";
        inp.value = editAdminId;
        inp.type = "hidden";
        myform.appendChild(inp);
        document.body.appendChild(myform);
        console.log(myform);
        myform.submit()
    }
</script>

