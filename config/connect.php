<?php

$hostname = "db4free.net";
$username = 'ers_fos_admin';
$password = 'd@*a!r0NEfzv7ZwQ';
$dbname = 'ers_fos_db';

$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con) {
    die("Connection failed : " . mysqli_connect_error());
}

?>
