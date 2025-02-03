<!-- backend/db_connection.php -->
<?php
$happy_conn = mysqli_connect("localhost", "root", "", "happy_conn");

if (!$happy_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
