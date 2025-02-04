<?php
// backend/config.php

$servername = "localhost"; 
$username = "root";        
$password = "";           
$dbname = "happy_conn";
// Create connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
// Check connection
if (!$happy_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
