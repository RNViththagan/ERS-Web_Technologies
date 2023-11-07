<?php

$hostname = "localhost";
$username = 'root';
$password = '';
$dbname = 'ers_fos_db';

$con = mysqli_connect($hostname, $username, $password, $dbname, "4306");

if (!$con) {
    die("Connection failed : " . mysqli_connect_error());
}

?>
