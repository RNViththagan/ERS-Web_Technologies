<link rel="stylesheet" href="../css/main.css">
<h1 class="titlehead">Add admin</h1>
<div class="container">
    <form action="" method="post">
        <?php
        if (isset($msg)) {
            echo "<b class='" . $msg[1] . "'>" . $msg[0] . "</b>";
        }
        ?>
        <div class="formcomp">
            <label for="regno">Registration No.: </label>
            <input type="text" name="regno" required>
        </div>
        <div class="formcomp">
            <label for="email">Email: </label>
            <input type="email" name="email" required>
        </div>
        <div class="formcomp formbutton">
            <input type="submit" name="submit" value="Register">
        </div>
    </form>
    <a href="index.php"><button>Dashboard</button></a>
</div>
