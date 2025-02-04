<?php
// backend/register.php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect form data
    $role = mysqli_real_escape_string($happy_conn, $_POST['role']);
    $email = mysqli_real_escape_string($happy_conn, $_POST['email']);
    $password = mysqli_real_escape_string($happy_conn, $_POST['password']);

    // Check if email already exists in the selected role table
    if ($role == 'admin') {
        $sql = "SELECT  * FROM happy_admins WHERE username = '$email'";
    } elseif ($role == 'teacher') {
        $sql = "SELECT * FROM happy_teachers WHERE username = '$email'";
    } elseif ($role == 'student') {
        $sql = "SELECT * FROM happy_students WHERE student_id = '$email'";
    }

    $result = mysqli_query($happy_conn, $sql);

    // If email exists, redirect to the appropriate dashboard
    if (mysqli_num_rows($result) > 0) {
        // Start session and set role-based redirection
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        if ($role == 'admin') {
            header('Location: ./login.php');
        } elseif ($role == 'teacher') {
            header('Location: ./login.php');
        } else {
            header('Location: ./login.php');
        }
        exit();
    } else {
        // If email does not exist, register the user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // if ($role == 'admin') {
        $sql = "INSERT INTO happy_admins (username, password) VALUES ('$email', '$hashed_password')";
        // } elseif ($role == 'teacher') {
        //     $sql = "INSERT INTO teachers (username, password) VALUES ('$email', '$hashed_password')";
        // } elseif ($role == 'student') {
        //     $sql = "INSERT INTO students (student_id, password) VALUES ('$email', '$hashed_password')";
        // }

        if (mysqli_query($happy_conn, $sql)) {
            // Redirect to the respective dashboard after registration
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email;
            if ($role == 'admin') {
                header('Location: ./login.php');
            } elseif ($role == 'teacher') {
                header('Location: ./login.php');
            } else {
                header('Location: ./login.php');
            }
            exit();
        } else {
            echo "Error: " . mysqli_error($happy_conn);
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

<body class="flex w-full ">
    <div class="w-1/2">
        <img src="../images/15.jpg" alt="School Logo" class=" h-screen w-full object-cover">
    </div>
    <div class=" flex w-1/2 items-center">
        <div class=" rounded-lg p-8 w-full items-center">
            <h2 class="text-2xl font-bold text-center text-violet-600 mb-6">Register</h2>
            <form action="register.php" method="POST" class="space-y-4">
                <div>
                    <label for="role" class="block text-gray-600 font-medium">Select Role:</label>
                    <select name="role" required class="w-full p-2 border rounded-md focus:ring focus:ring-violet-300">
                        <option value="admin">Admin</option>
                        <!-- <option value="teacher">Teacher</option>
                    <option value="student">Student</option> -->
                    </select>
                </div>
                <div>
                    <label for="email" class="block text-gray-600 font-medium">Email:</label>
                    <input type="email" name="email" required placeholder="Enter your email"
                        class="w-full p-2 border rounded-md focus:ring focus:ring-violet-300">
                </div>
                <div>
                    <label for="password" class="block text-gray-600 font-medium">Password:</label>
                    <input type="password" name="password" required placeholder="Enter your password"
                        class="w-full p-2 border rounded-md focus:ring focus:ring-violet-300">
                </div>
                <button type="submit"
                    class="w-full bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded-md transition">Register</button>
            </form>
            <p class="text-center text-gray-600 mt-4">
                Already have an account?
                <a href="./login.php" class="text-violet-500 hover:underline">Login</a>
            </p>
        </div>
    </div>
</body>

</html>