<!-- backend/db_connection.php -->
<?php
$karine_conn = mysqli_connect("localhost", "root", "", "happy_conn");

if (!$karine_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
