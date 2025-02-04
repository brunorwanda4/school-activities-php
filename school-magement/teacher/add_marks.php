<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_marks'])) {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $teacher_id = $_SESSION['user_id'];

    $sql = "INSERT INTO marks (student_id, subject, marks, teacher_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($happy_conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $student_id, $subject, $marks, $teacher_id);
    mysqli_stmt_execute($stmt);

    header("Location: all_marks.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Marks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Enter Marks</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="student_id" placeholder="Student ID" required class="w-full border p-2 rounded">
            <input type="text" name="subject" placeholder="Subject" required class="w-full border p-2 rounded">
            <input type="number" name="marks" placeholder="Marks" required class="w-full border p-2 rounded">
            <button type="submit" name="add_marks" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Save Marks</button>
        </form>
        <div class="mt-4 text-center">
            <a href="all_marks.php" class="text-gray-600 hover:text-violet-500 font-semibold">View Marks</a>
        </div>
    </div>
</body>
</html>
