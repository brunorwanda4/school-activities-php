<?php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is an admin
if($_SESSION['user_type'] !== 'admin')  {
    header('Location: ../backend/login.php');  // Redirect to login if not admin
    exit();
}

// Handle Add Teacher
if (isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Secure password hashing

    $sql = "INSERT INTO teachers (name, subject, username, password) VALUES ('$name', '$subject', '$username', '$password')";
    mysqli_query($ineza_conn, $sql);
}

// Handle Edit Teacher
if (isset($_POST['edit_teacher'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];

    // Update password only if a new one is provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE teachers SET name = '$name', subject = '$subject', username = '$username', password = '$password' WHERE id = '$id'";
    } else {
        $sql = "UPDATE teachers SET name = '$name', subject = '$subject', username = '$username' WHERE id = '$id'";
    }
    mysqli_query($ineza_conn, $sql);
}

// Handle Delete Teacher
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($ineza_conn, "DELETE FROM teachers WHERE id = '$id'");
}

// Fetch all teachers
$teachers = mysqli_query($ineza_conn, "SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-2xl border-t-4 border-red-500">
        <h1 class="text-2xl font-bold text-center text-red-600 mb-6">Manage Teachers</h1>

        <!-- Add Teacher Form -->
        <form method="POST" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Add New Teacher</h2>
            <input type="text" name="name" placeholder="Name" required class="w-full border p-2 rounded">
            <input type="text" name="subject" placeholder="Subject" required class="w-full border p-2 rounded">
            <input type="text" name="username" placeholder="Username" required class="w-full border p-2 rounded">
            <input type="password" name="password" placeholder="Password" required class="w-full border p-2 rounded">
            <button type="submit" name="add_teacher" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded transition">Add Teacher</button>
        </form>

        <!-- Edit Teacher Form (if edit is triggered) -->
        <?php if (isset($_GET['edit'])): 
            $id = $_GET['edit'];
            $teacher = mysqli_fetch_assoc(mysqli_query($ineza_conn, "SELECT * FROM teachers WHERE id = '$id'"));
        ?>
        <form method="POST" class="mt-6 space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Edit Teacher</h2>
            <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
            <input type="text" name="name" value="<?php echo $teacher['name']; ?>" required class="w-full border p-2 rounded">
            <input type="text" name="subject" value="<?php echo $teacher['subject']; ?>" required class="w-full border p-2 rounded">
            <input type="text" name="username" value="<?php echo $teacher['username']; ?>" required class="w-full border p-2 rounded">
            <input type="password" name="password" placeholder="New Password (optional)" class="w-full border p-2 rounded">
            <button type="submit" name="edit_teacher" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded transition">Update Teacher</button>
        </form>
        <?php endif; ?>

        <!-- Display Teachers -->
        <table class="w-full mt-8 border-collapse">
            <thead>
                <tr class="bg-red-500 text-white">
                    <th class="p-2">ID</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Subject</th>
                    <th class="p-2">Username</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($teachers)): ?>
                <tr class="border-t">
                    <td class="p-2 text-center"><?php echo $row['id']; ?></td>
                    <td class="p-2"><?php echo $row['name']; ?></td>
                    <td class="p-2"><?php echo $row['subject']; ?></td>
                    <td class="p-2"><?php echo $row['username']; ?></td>
                    <td class="p-2 text-center">
                        <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                        <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-red-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
