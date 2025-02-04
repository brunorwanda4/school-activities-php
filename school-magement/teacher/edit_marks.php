<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($happy_conn, "SELECT * FROM marks WHERE id = '$id'");
    $marks = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_marks'])) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    $sql = "UPDATE marks SET student_id=?, subject=?, marks=? WHERE id=?";
    $stmt = mysqli_prepare($happy_conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $student_id, $subject, $marks, $id);
    mysqli_stmt_execute($stmt);

    header("Location: all_marks.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Marks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Edit Marks</h2>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo $marks['id']; ?>">
            <input type="text" name="student_id" value="<?php echo $marks['student_id']; ?>" required class="w-full border p-2 rounded">
            <input type="text" name="subject" value="<?php echo $marks['subject']; ?>" required class="w-full border p-2 rounded">
            <input type="number" name="marks" value="<?php echo $marks['marks']; ?>" required class="w-full border p-2 rounded">
            <button type="submit" name="edit_marks" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Update Marks</button>
        </form>
        <div class="mt-4 text-center">
            <a href="all_marks.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Marks</a>
        </div>
    </div>
</body>
</html>
