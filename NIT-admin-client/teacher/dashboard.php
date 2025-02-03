<?php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php'); // Redirect to login if not authorized
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md border-t-4 border-red-500">
        <h1 class="text-2xl font-bold text-center text-red-600 mb-6">Welcome, Teacher!</h1>

        <ul class="space-y-4 text-center">
            <li>
                <a href="marks_entry.php"class="text-red-500 hover:underline font-medium">Enter Marks</a>
            </li>
            <li>
                <a href="view_students.php"class="text-red-500 hover:underline font-medium">View Students</a>
            </li>
        </ul>

        <div class="mt-6 text-center">
            <a href="../backend/logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition">Logout</a>
        </div>
    </div>
</body>
</html>
