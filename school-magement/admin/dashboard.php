<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
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

<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen flex flex-col items-center justify-center">
    <aside>
        <ul>
            <li><a href="dashboard.php"></a></li>
        </ul>
    </aside>
    <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-lg border border-gray-200">
        <!-- Header -->
        <div class="bg-violet-500 text-white text-center py-4 rounded-t-lg">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        </div>

        <!-- Navigation -->
        <div class="space-y-4 mt-6">
            <a href="manage_students.php" class="block bg-gray-200 hover:bg-violet-500 hover:text-white text-gray-700 font-medium py-3 px-6 rounded-md shadow-md transition text-center">
                Manage Students
            </a>
            <a href="manage_teachers.php" class="block bg-gray-200 hover:bg-violet-500 hover:text-white text-gray-700 font-medium py-3 px-6 rounded-md shadow-md transition text-center">
                Manage Teachers
            </a>
            <a href="manage_modules.php" class="block bg-gray-200 hover:bg-violet-500 hover:text-white text-gray-700 font-medium py-3 px-6 rounded-md shadow-md transition text-center">
                Manage Modules
            </a>
        </div>

        <!-- Logout Button -->
        <div class="mt-6 text-center">
            <a href="../backend/login.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-md shadow-md transition">
                Logout
            </a>
        </div>
    </div>

</body>

</html>