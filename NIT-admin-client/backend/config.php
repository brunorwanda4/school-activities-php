
<?php
// backend/config.php

$servername = "localhost"; // Database server
$username = "root";        // Database username (default for local development)
$password = "";            // Database password (leave empty for local or provide actual password)
$dbname = "ineza_db"; // Your database name (should match the one you've created)

// Create connection
$ineza_conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$ineza_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>