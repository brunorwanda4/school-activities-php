<?php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php'); // Redirect to login if not admin
    exit();
}

// Handle Add Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $other_details = $_POST['other_details'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO students (name, student_id, class, other_details, password) 
            VALUES ('$name', '$student_id', '$class', '$other_details', '$password')";
    mysqli_query($karine_conn, $sql);
}

// Handle Edit Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $other_details = $_POST['other_details'];

    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE students SET name='$name', student_id='$student_id', class='$class', 
                other_details='$other_details', password='$hashed_password' WHERE id='$id'";
    } else {
        $sql = "UPDATE students SET name='$name', student_id='$student_id', class='$class', 
                other_details='$other_details' WHERE id='$id'";
    }
    mysqli_query($karine_conn, $sql);
}

// Handle Delete Student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($karine_conn, "DELETE FROM students WHERE id='$id'");
    header("Location: manage_students.php");
    exit();
}

// Fetch all students
$result = mysqli_query($karine_conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center text-red-600 mb-6">Manage Students</h1>

        <!-- Add Student Form -->
        <form method="POST" class="space-y-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-700">Add New Student</h2>
            <input type="text" name="name" placeholder="Student Name" required class="w-full p-2 border rounded-md">
            <input type="text" name="student_id" placeholder="Student ID" required class="w-full p-2 border rounded-md">
            <input type="text" name="class" placeholder="Class" required class="w-full p-2 border rounded-md">
            <textarea name="other_details" placeholder="Other Details" class="w-full p-2 border rounded-md"></textarea>
            <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded-md">
            <button type="submit" name="add_student" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-md">Add Student</button>
        </form>

        <!-- Display Students -->
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Student List</h2>
        <table class="w-full border-collapse bg-white shadow-md rounded-md">
            <thead>
                <tr class="bg-red-500 text-white">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Student ID</th>
                    <th class="p-3 text-left">Class</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo $row['id']; ?></td>
                        <td class="p-3"><?php echo $row['name']; ?></td>
                        <td class="p-3"><?php echo $row['student_id']; ?></td>
                        <td class="p-3"><?php echo $row['class']; ?></td>
                        <td class="p-3">
                            <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> | 
                            <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Edit Student Form -->
        <?php if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $student = mysqli_fetch_assoc(mysqli_query($karine_conn, "SELECT * FROM students WHERE id='$id'"));
        ?>
            <form method="POST" class="space-y-4 mt-6">
                <h2 class="text-lg font-semibold text-gray-700">Edit Student</h2>
                <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                <input type="text" name="name" value="<?php echo $student['name']; ?>" required class="w-full p-2 border rounded-md">
                <input type="text" name="student_id" value="<?php echo $student['student_id']; ?>" required class="w-full p-2 border rounded-md">
                <input type="text" name="class" value="<?php echo $student['class']; ?>" required class="w-full p-2 border rounded-md">
                <textarea name="other_details" class="w-full p-2 border rounded-md"><?php echo $student['other_details']; ?></textarea>
                <input type="password" name="password" placeholder="New Password (Leave blank to keep current password)" class="w-full p-2 border rounded-md">
                <button type="submit" name="edit_student" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-md">Update Student</button>
            </form>
        <?php } ?>
        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-red-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
