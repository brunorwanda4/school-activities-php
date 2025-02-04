<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($happy_conn, "SELECT * FROM teachers WHERE id = '$id'");
    $teacher = mysqli_fetch_assoc($result);
}

if (isset($_POST['edit_teacher'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE teachers SET name=?, subject=?, username=?, password=? WHERE id=?";
        $stmt = mysqli_prepare($happy_conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $subject, $username, $password, $id);
    } else {
        $sql = "UPDATE teachers SET name=?, subject=?, username=? WHERE id=?";
        $stmt = mysqli_prepare($happy_conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $subject, $username, $id);
    }

    mysqli_stmt_execute($stmt);
    header("Location: manage_teachers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Teacher</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-violet-600 mb-4">Edit Teacher</h2>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
            <div class=" space-y-2">
                <label for="name" class=" text-gray-600">Name</label>
                <input type="text" name="name" value="<?php echo $teacher['name']; ?>" required class="w-full border p-2 rounded">
            </div>
            <div class=" space-y-2">
                <label for="subject" class=" text-gray-600">Subject</label>
                <input id="subject" type="text" name="subject" value="<?php echo $teacher['subject']; ?>" required class="w-full border p-2 rounded">
            </div>
            <div class=" space-y-2">
                <label id="username" for="subject" class=" text-gray-600">Username</label>
                <input type="text" name="username" value="<?php echo $teacher['username']; ?>" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label id="password" for="subject" class=" text-gray-600">New password</label>
                <input id="password" type="password" name="password" placeholder="New Password (optional)" class="w-full border p-2 rounded"></div>
            <button type="submit" name="edit_teacher" class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 rounded">Update Teacher</button>
        </form>
        <div class="mt-4 text-center">
            <a href="manage_teachers.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Teachers List</a>
        </div>
    </div>
</body>

</html>