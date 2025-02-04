<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_module'])) {
    $module_name = $_POST['module_name'];
    $description = $_POST['description'];
    $parent_module_id = $_POST['parent_module_id'] ?: NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $sql = "INSERT INTO modules (module_name, description, parent_module_id, is_active) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($happy_conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $module_name, $description, $parent_module_id, $is_active);
    mysqli_stmt_execute($stmt);

    header("Location: manage_modules.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Module</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Add New Module</h2>
        
        <form method="POST" class="space-y-4">
            <div>
                <label for="module_name" class="block text-gray-700 font-medium">Module Name</label>
                <input type="text" id="module_name" name="module_name" placeholder="Enter module name" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="description" class="block text-gray-700 font-medium">Description</label>
                <textarea id="description" name="description" placeholder="Enter description" class="w-full border p-2 rounded focus:ring focus:ring-violet-200"></textarea>
            </div>

            <div>
                <label for="parent_module_id" class="block text-gray-700 font-medium">Parent Module ID (optional)</label>
                <input type="text" id="parent_module_id" name="parent_module_id" placeholder="Enter parent module ID" class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" checked class="mr-2">
                <label for="is_active" class="text-gray-700">Active</label>
            </div>

            <button type="submit" name="add_module" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Add Module</button>
        </form>

        <div class="mt-4 text-center">
            <a href="manage_modules.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Modules List</a>
        </div>
    </div>
</body>
</html>
