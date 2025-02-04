<?php
// admin/dashboard.php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  // Redirect to login if not admin
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg border-t-4 border-violet-500">
        <h1 class="text-3xl font-bold text-center text-violet-600 mb-6">Welcome, Admin!</h1>
        <ul class="space-y-4 text-center">
            <li><a href="manage_students.php" class="text-violet-500 hover:underline font-medium">Manage Students</a></li>
            <li><a href="manage_teachers.php" class="text-violet-500 hover:underline font-medium">Manage Teachers</a></li>
            <li><a href="manage_modules.php" class="text-violet-500 hover:underline font-medium">Manage Modules</a></li>
        </ul>
        <div class="mt-6 text-center">
            <a href="../backend/login.php" class="bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded-md transition">Logout</a>
        </div>
    </div>
</body>
</html>
