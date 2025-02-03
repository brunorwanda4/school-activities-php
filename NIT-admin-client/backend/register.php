<?php
// backend/register.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect form data
    $role = mysqli_real_escape_string($ineza_conn, $_POST['role']);
    $username = mysqli_real_escape_string($ineza_conn, $_POST['username']);
    $email = mysqli_real_escape_string($ineza_conn, $_POST['email']);
    $password = mysqli_real_escape_string($ineza_conn, $_POST['password']);

    // Check if email already exists in the appropriate table
    if ($role == 'admin') {
        $sql = "SELECT * FROM ineza_tbladmin WHERE email = '$email'";
    } else { // user
        $sql = "SELECT * FROM ineza_tblusers WHERE email = '$email'";
    }

    $result = mysqli_query($ineza_conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already registeblue!'); window.location.href='register.php';</script>";
        exit();
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user based on role
        if ($role == 'admin') {
            $sql = "INSERT INTO ineza_tbladmin (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        } else { // user
            $sql = "INSERT INTO ineza_tblusers (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        }

        if (mysqli_query($ineza_conn, $sql)) {
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;

            // blueirect based on role
            if ($role == 'admin') {
                header('Location: ../admin/dashboard.php');
            } else {
                header('Location: ../user/dashboard.php');
            }
            exit();
        } else {
            echo "Error: " . mysqli_error($ineza_conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md border-t-4 border-blue-500">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Register</h2>
        <form action="register.php" method="POST" class="space-y-4">
            <div>
                <label for="role" class="block text-gray-600 font-medium">Select Role:</label>
                <select name="role" requiblue class="w-full p-2 border rounded-md focus:ring focus:ring-blue-300">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div>
                <label for="username" class="block text-gray-600 font-medium">Username:</label>
                <input type="text" name="username" requiblue placeholder="Enter your username"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-blue-300">
            </div>
            <div>
                <label for="email" class="block text-gray-600 font-medium">Email:</label>
                <input type="email" name="email" requiblue placeholder="Enter your email"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-blue-300">
            </div>
            <div>
                <label for="password" class="block text-gray-600 font-medium">Password:</label>
                <input type="password" name="password" requiblue placeholder="Enter your password"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-blue-300">
            </div>
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition">Register</button>
        </form>
        <p class="text-center text-gray-600 mt-4">
            Already have an account?
            <a href="./login.php" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>
</body>
</html>
