<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($happy_conn, "SELECT * FROM happy_students WHERE id = '$id'");
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
        $sql = "UPDATE happy_students SET name=?, student_id=?, class=?, other_details=?, password=? WHERE id=?";
        $stmt = mysqli_prepare($happy_conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $student_id, $class, $other_details, $hashed_password, $id);
    } else {
        $sql = "UPDATE happy_students SET name=?, student_id=?, class=?, other_details=? WHERE id=?";
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

            <div>
                <label for="name" class="block text-gray-700 font-medium">Student Name</label>
                <input id="name" type="text" name="name" value="<?php echo $student['name']; ?>" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="student_id" class="block text-gray-700 font-medium">Student ID</label>
                <input id="student_id" type="text" name="student_id" value="<?php echo $student['student_id']; ?>" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="class" class="block text-gray-700 font-medium">Class</label>
                <input id="class" type="text" name="class" value="<?php echo $student['class']; ?>" required class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <div>
                <label for="other_details" class="block text-gray-700 font-medium">Other Details</label>
                <textarea id="other_details" name="other_details" class="w-full border p-2 rounded focus:ring focus:ring-violet-200"><?php echo $student['other_details']; ?></textarea>
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium">New Password (Optional)</label>
                <input id="password" type="password" name="password" placeholder="Enter new password (leave blank to keep existing password)" class="w-full border p-2 rounded focus:ring focus:ring-violet-200">
            </div>

            <button type="submit" name="edit_student" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Update Student</button>
        </form>

        <div class="mt-4 text-center">
            <a href="manage_students.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Students List</a>
        </div>
    </div>
</body>
</html>
