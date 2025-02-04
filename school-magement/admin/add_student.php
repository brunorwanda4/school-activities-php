<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $other_details = $_POST['other_details'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO students (name, student_id, class, other_details, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($happy_conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $student_id, $class, $other_details, $password);
    mysqli_stmt_execute($stmt);

    header("Location: manage_students.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Add New Student</h2>

        <form method="POST" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-700 font-medium">Student Name</label>
                <input type="text" id="name" name="name" placeholder="Enter student name" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="student_id" class="block text-gray-700 font-medium">Student ID</label>
                <input type="text" id="student_id" name="student_id" placeholder="Enter student ID" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="class" class="block text-gray-700 font-medium">Class</label>
                <input type="text" id="class" name="class" placeholder="Enter class" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="other_details" class="block text-gray-700 font-medium">Other Details</label>
                <textarea id="other_details" name="other_details" placeholder="Enter additional details" class="w-full border p-2 rounded focus:ring focus:ring-violet-200"></textarea>
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <button type="submit" name="add_student" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Add Student</button>
        </form>

        <div class="mt-4 text-center">
            <a href="manage_students.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Students List</a>
        </div>
    </div>
</body>

</html>