<?php
session_start();
include_once('../backend/config.php'); 

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO teachers (name, subject, username, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($happy_conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $subject, $username, $password);
    mysqli_stmt_execute($stmt);

    header("Location: manage_teachers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Teacher</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Add New Teacher</h2>
        
        <form method="POST" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-700 font-medium">Name</label>
                <input id="name" type="text" name="name" placeholder="Enter Name" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="subject" class="block text-gray-700 font-medium">Subject</label>
                <input id="subject" type="text" name="subject" placeholder="Enter Subject" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="username" class="block text-gray-700 font-medium">Username</label>
                <input id="username" type="text" name="username" placeholder="Enter Username" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter Password" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <button type="submit" name="add_teacher" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Add Teacher</button>
        </form>

        <div class="mt-4 text-center">
            <a href="manage_teachers.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Teachers List</a>
        </div>
    </div>
</body>
</html>
