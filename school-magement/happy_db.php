<?php

$DB_Server = "localhost";
$DB_Username = "root";
$DB_Password = "";
$DB="school_management";
$happy_conn = mysqli_connect($DB_Server, $DB_Username, $DB_Password , $DB);

if (!$happy_conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// // Create database 😔

// $sql = "CREATE DATABASE IF NOT EXISTS school_management";
// if (mysqli_query($happy_conn, $sql)) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . mysqli_error($happy_conn);
// }

 // create table 😔😔

// $sql = mysqli_query($happy_conn , "CREATE TABLE IF NOT EXISTS students (
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   full_name VARCHAR(255) NOT NULL,
//   email VARCHAR(255) NOT NULL,
//   age INT,
//   course VARCHAR(255)
// )");

// Create table with required columns
$sql = "CREATE TABLE IF NOT EXISTS sensor_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_point VARCHAR(255),
    temperature DECIMAL(5,2),
    humidity DECIMAL(5,2),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (mysqli_query($happy_conn, $sql)) {
    echo "Table 'sensor_data' created successfully 💚";
} else {
    echo "Error creating table: " . mysqli_error($happy_conn);
}

// // to see if is ok 😔😔😔😔😔

// if(!$sql) {
//     echo " some thing wet ❤️";
// } else {
//     echo " connect to db 💚";
// };



mysqli_close($happy_conn);
?>
