<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

$students = mysqli_query($happy_conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Students List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Students List</h2>
        <a href="add_student.php" class="mb-4 inline-block bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded">Add New Student</a>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-violet-500 text-white">
                    <th class="p-2">ID</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Student ID</th>
                    <th class="p-2">Class</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($students)): ?>
                <tr class="border-t">
                    <td class="p-2"><?php echo $row['id']; ?></td>
                    <td class="p-2"><?php echo $row['name']; ?></td>
                    <td class="p-2"><?php echo $row['student_id']; ?></td>
                    <td class="p-2"><?php echo $row['class']; ?></td>
                    <td class="p-2">
                        <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                        <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:underline">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
