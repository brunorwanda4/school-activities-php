<?php
// backend/login.php

session_start();
include_once('../backend/config.php');  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];  // Get the selected role
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password match the selected role
    if ($role == 'admin') {
        $query = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($happy_conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Admin login
                $_SESSION['user_type'] = 'admin';
                $_SESSION['username'] = $username;
                header("Location: ../admin/dashboard.php");
                exit();
            }
        }
    } elseif ($role == 'teacher') {
        $query = "SELECT * FROM teachers WHERE username = '$username'";
        $result = mysqli_query($happy_conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $teacher = mysqli_fetch_assoc($result);
            if (password_verify($password, $teacher['password'])) {
                // Teacher login
                $_SESSION['user_type'] = 'teacher';
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $teacher['id'];
                header("Location: ../teacher/dashboard.php");
                exit();
            }
        }
    } elseif ($role == 'student') {
        $query = "SELECT * FROM students WHERE student_id = '$username'";
        $result = mysqli_query($happy_conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Student login
                $_SESSION['user_type'] = 'student';
                $_SESSION['student_id'] = $username;
                header("Location: ../student/dashboard.php");
                exit();
            }
        }
    }

    // Invalid credentials
    $error_message = "Invalid login credentials!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex  min-h-screen bg-gray-100 w-full">
    <div class="mb-6">
        <img src="../images/13.jpg" alt="School Logo" class="mx-auto h-screen w-1/2 object-cover">
    </div>
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md border-t-4 border-red-500">
        <h2 class="text-2xl font-bold text-center text-red-600 mb-6">Login</h2>
        
        <?php if (isset($error_message)) { ?>
            <p class="text-red-500 text-center mb-4"> <?php echo $error_message; ?> </p>
        <?php } ?>
        
        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label for="role" class="block text-gray-600 font-medium">Select Role:</label>
                <select name="role" required class="w-full p-2 border rounded-md focus:ring focus:ring-red-300">
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div>
                <input type="text" name="username" placeholder="Username" required 
                    class="w-full p-2 border rounded-md focus:ring focus:ring-red-300" />
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" required 
                    class="w-full p-2 border rounded-md focus:ring focus:ring-red-300" />
            </div>
            <button type="submit" 
                class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition">Login</button>
        </form>
        
        <p class="text-center text-gray-600 mt-4">
            Don't have an account? 
            <a href="./register.php" class="text-red-500 hover:underline">Register</a>
        </p>
    </div>
</body>
</html>
