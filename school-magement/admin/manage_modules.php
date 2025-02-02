<?php
// admin/manage_modules.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Ensure the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  // Redirect to login if not admin
    exit();
}

// Handle Add Module
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_module'])) {
    $module_name = $_POST['module_name'];
    $description = $_POST['description'];
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $sql = "INSERT INTO modules (module_name, description, parent_module_id, is_active) 
            VALUES ('$module_name', '$description', '$parent_module_id', '$is_active')";
    mysqli_query($karine_conn, $sql);
}

// Handle Edit Module
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_module'])) {
    $id = $_POST['id'];
    $module_name = $_POST['module_name'];
    $description = $_POST['description'];
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $sql = "UPDATE modules SET module_name='$module_name', description='$description', 
            parent_module_id='$parent_module_id', is_active='$is_active' WHERE id='$id'";
    mysqli_query($karine_conn, $sql);
}

// Handle Delete Module
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($karine_conn, "DELETE FROM modules WHERE id='$id'");
    header("Location: manage_modules.php");
    exit();
}

// Fetch all modules
$result = mysqli_query($karine_conn, "SELECT * FROM modules");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Modules</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center text-red-600 mb-6">Manage Modules</h1>

        <!-- Add Module Form -->
        <form method="POST" class="space-y-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-700">Add New Module</h2>
            <input type="text" name="module_name" placeholder="Module Name" required class="w-full p-2 border rounded-md">
            <textarea name="description" placeholder="Description" class="w-full p-2 border rounded-md"></textarea>
            <input type="text" name="parent_module_id" placeholder="Parent Module ID (optional)" class="w-full p-2 border rounded-md">
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" checked class="mr-2">
                <label for="is_active" class="text-gray-700">Active</label>
            </div>
            <button type="submit" name="add_module" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-md">Add Module</button>
        </form>

        <!-- Display Modules -->
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Module List</h2>
        <table class="w-full border-collapse bg-white shadow-md rounded-md">
            <thead>
                <tr class="bg-red-500 text-white">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Module Name</th>
                    <th class="p-3 text-left">Description</th>
                    <th class="p-3 text-left">Active</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo $row['id']; ?></td>
                        <td class="p-3"><?php echo $row['module_name']; ?></td>
                        <td class="p-3"><?php echo $row['description']; ?></td>
                        <td class="p-3"><?php echo $row['is_active'] ? 'Yes' : 'No'; ?></td>
                        <td class="p-3">
                            <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> | 
                            <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Edit Module Form -->
        <?php if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $module = mysqli_fetch_assoc(mysqli_query($karine_conn, "SELECT * FROM modules WHERE id='$id'"));
        ?>
            <form method="POST" class="space-y-4 mt-6">
                <h2 class="text-lg font-semibold text-gray-700">Edit Module</h2>
                <input type="hidden" name="id" value="<?php echo $module['id']; ?>">
                <input type="text" name="module_name" value="<?php echo $module['module_name']; ?>" required class="w-full p-2 border rounded-md">
                <textarea name="description" class="w-full p-2 border rounded-md"><?php echo $module['description']; ?></textarea>
                <input type="text" name="parent_module_id" value="<?php echo $module['parent_module_id']; ?>" placeholder="Parent Module ID (optional)" class="w-full p-2 border rounded-md">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" <?php echo $module['is_active'] ? 'checked' : ''; ?> class="mr-2">
                    <label for="is_active" class="text-gray-700">Active</label>
                </div>
                <button type="submit" name="edit_module" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-md">Update Module</button>
            </form>
        <?php } ?>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-red-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>