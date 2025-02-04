<?php
// student/dashboard.php
session_start();
include_once('../backend/config.php'); 

// Ensure the user is a student
if ($_SESSION['user_type'] !== 'student') {
    header('Location: ../backend/login.php');  
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="max-w-md w-full bg-white p-6 shadow-md rounded-lg text-center">
        <h1 class="text-2xl font-bold text-violet-600">Welcome, Student!</h1>
        
        <ul class="mt-6 space-y-4">
            <li>
                <a href="view_marks.php" class="block bg-violet-500 text-white py-2 px-4 rounded-lg hover:bg-violet-600 transition">
                    View Marks
                </a>
            </li>
        </ul>

        <!-- Logout Button -->
        <a href="../backend/login.php" class="mt-6 inline-block text-violet-600 hover:text-violet-700 font-semibold">
            Logout
        </a>
    </div>
</body>
</html>
