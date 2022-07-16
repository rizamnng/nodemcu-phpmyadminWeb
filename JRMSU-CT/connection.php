<?php
$user = 'root';
$password = '';
$db = 'contacttracingdb';
$host = 'localhost';
$port = 3308;

$con = mysqli_init();
$success = mysqli_real_connect(
   $con,
   $host,
   $user,
   $password,
   $db,
   $port
);

?>



