<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($happy_conn, "DELETE FROM marks WHERE id = '$id'");
    header("Location: all_marks.php");
    exit();
}
?>
