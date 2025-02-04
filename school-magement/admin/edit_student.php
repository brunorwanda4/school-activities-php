<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($happy_conn, "SELECT * FROM students WHERE id = '$id'");
    $student = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $other_details = $_POST['other_details'];

    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE students SET name=?, student_id=?, class=?, other_details=?, password=? WHERE id=?";
        $stmt = mysqli_prepare($happy_conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $student_id, $class, $other_details, $hashed_password, $id);
    } else {
        $sql = "UPDATE students SET name=?, student_id=?, class=?, other_details=? WHERE id=?";
        $stmt = mysqli_prepare($happy_conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $student_id, $class, $other_details, $id);
    }

    mysqli_stmt_execute($stmt);
    header("Location: manage_students.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Edit Student</h2>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <input type="text" name="name" value="<?php echo $student['name']; ?>" required class="w-full border p-2 rounded">
            <input type="text" name="student_id" value="<?php echo $student['student_id']; ?>" required class="w-full border p-2 rounded">
            <input type="text" name="class" value="<?php echo $student['class']; ?>" required class="w-full border p-2 rounded">
            <textarea name="other_details" class="w-full border p-2 rounded"><?php echo $student['other_details']; ?></textarea>
            <input type="password" name="password" placeholder="New Password (optional)" class="w-full border p-2 rounded">
            <button type="submit" name="edit_student" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Update Student</button>
        </form>
        <div class="mt-4 text-center">
            <a href="manage_students.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Students List</a>
        </div>
    </div>
</body>
</html>
