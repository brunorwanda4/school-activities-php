<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php');
    exit();
}

$marks = mysqli_query($happy_conn, "SELECT * FROM marks WHERE teacher_id = '{$_SESSION['user_id']}'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Marks List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Marks List</h2>
        <a href="add_marks.php" class="mb-4 inline-block bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded">Add New Marks</a>
        <a href="dashboard.php" class="mb-4 inline-block bg-gray-400 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back in dashboard</a>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-violet-500 text-white">
                    <th class="p-2">Student ID</th>
                    <th class="p-2">Subject</th>
                    <th class="p-2">Marks</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($marks)): ?>
                <tr class="border-t">
                    <td class="p-2"><?php echo $row['student_id']; ?></td>
                    <td class="p-2"><?php echo $row['subject']; ?></td>
                    <td class="p-2"><?php echo $row['marks']; ?></td>
                    <td class="p-2"><?php echo $row['entry_date']; ?></td>
                    <td class="p-2">
                        <a href="edit_marks.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                        <a href="delete_marks.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
