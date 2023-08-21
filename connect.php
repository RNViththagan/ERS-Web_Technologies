<?php

//$hostname = "ers-fos.database.windows.net";
//$username = 'CloudSA5c33d5c2';
//$password = 'D38627I60J4BDCZ4$';
//$dbname = 'ers-fos-db';
//
//$con = mysqli_connect($hostname, $username, $password, $dbname);
//
//if (!$con) {
//    die("Connection failed : " . mysqli_connect_error());
//}


// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:ers-fos.database.windows.net,1433; Database = ers-fos-db", "CloudSA5c33d5c2", "D38627I60J4BDCZ4$");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "CloudSA5c33d5c2", "pwd" => "D38627I60J4BDCZ4$", "Database" => "ers-fos-db", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:ers-fos.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

$con =$conn;


?>
