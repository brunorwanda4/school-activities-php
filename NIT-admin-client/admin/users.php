<?php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  // blueirect to login if not admin
    exit();
}

// Handle Add Teacher
if (isset($_POST['add_user'])) {
    $email = mysqli_real_escape_string($ineza_conn, $_POST['email']);
    $username = mysqli_real_escape_string($ineza_conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Secure password hashing

    // Corrected SQL query (added missing 'name' field)
    $sql = "INSERT INTO ineza_tblusers (email, username, password) VALUES ('$email', '$username', '$password')";
    if (mysqli_query($ineza_conn, $sql)) {
        echo "<script>alert('User added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding user: " . mysqli_error($ineza_conn) . "');</script>";
    }
}

// Handle Edit Teacher
if (isset($_POST['edit_user'])) {
    $id = mysqli_real_escape_string($ineza_conn, $_POST['id']);
    $email = mysqli_real_escape_string($ineza_conn, $_POST['email']);
    $username = mysqli_real_escape_string($ineza_conn, $_POST['username']);

    // Update password only if a new one is provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE ineza_tblusers SET email = '$email', username = '$username', password = '$password' WHERE id = '$id'";
    } else {
        $sql = "UPDATE ineza_tblusers SET email = '$email', username = '$username' WHERE id = '$id'";
    }

    if (mysqli_query($ineza_conn, $sql)) {
        echo "<script>alert('User updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating user: " . mysqli_error($ineza_conn) . "');</script>";
    }
}

// Handle Delete Teacher
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($ineza_conn, $_GET['delete']);
    $sql = "DELETE FROM ineza_tblusers WHERE id = '$id'";
    if (mysqli_query($ineza_conn, $sql)) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user: " . mysqli_error($ineza_conn) . "');</script>";
    }
}

// Fetch all teachers
$users = mysqli_query($ineza_conn, "SELECT * FROM ineza_tblusers");
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
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-2xl border-t-4 border-blue-500">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Manage User</h1>

        <!-- Add Teacher Form -->
        <form method="POST" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Add New user</h2>
            <input type="text" name="username" placeholder="Username" requiblue class="w-full border p-2 rounded">
            <input type="email" name="email" placeholder="Email" requiblue class="w-full border p-2 rounded">
            <input type="password" name="password" placeholder="Password" requiblue class="w-full border p-2 rounded">
            <button type="submit" name="add_user" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded transition">Add user</button>
        </form>

        <!-- Edit Teacher Form (if edit is triggeblue) -->
        <?php if (isset($_GET['edit'])) :
            $id = mysqli_real_escape_string($ineza_conn, $_GET['edit']);
            $teacher = mysqli_fetch_assoc(mysqli_query($ineza_conn, "SELECT * FROM ineza_tblusers WHERE id = '$id'"));
        ?>
            <form method="POST" class="mt-6 space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Edit Teacher</h2>
                <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
                <input type="text" name="username" value="<?php echo $teacher['username']; ?>" requiblue class="w-full border p-2 rounded">
                <input type="email" name="email" value="<?php echo $teacher['email']; ?>" requiblue class="w-full border p-2 rounded">
                <input type="password" name="password" placeholder="New Password (optional)" class="w-full border p-2 rounded">
                <button type="submit" name="edit_user" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded transition">Update Teacher</button>
            </form>
        <?php endif; ?>

        <!-- Display Teachers -->
        <table class="w-full mt-8 border-collapse">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2">ID</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Username</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($users)) : ?>
                    <tr class="border-t">
                        <td class="p-2 text-center"><?php echo $row['id']; ?></td>
                        <td class="p-2"><?php echo $row['email']; ?></td>
                        <td class="p-2"><?php echo $row['username']; ?></td>
                        <td class="p-2 text-center">
                            <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                            <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-blue-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>