<!-- backend/db_connection.php -->
<?php
$ineza_con = mysqli_connect("localhost", "root", "", "ineza_nit");

if (!$ineza_con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
