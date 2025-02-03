<?php
// teacher/marks_entry.php
session_start();
include_once('../backend/config.php');  

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php');  
    exit();
}

// Handle Marks Entry
if (isset($_POST['add_marks'])) {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $teacher_id = $_SESSION['user_id'];

    $sql = "INSERT INTO marks (student_id, subject, marks, teacher_id) VALUES ('$student_id', '$subject', '$marks', '$teacher_id')";
    if (mysqli_query($happy_conn, $sql)) {
        echo "<p class='text-green-500'>Marks added successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Error: " . mysqli_error($happy_conn) . "</p>";
    }
}

// Fetch all students for viewing
$sql = "SELECT * FROM students";
$result = mysqli_query($happy_conn, $sql);

// Fetch marks for the teacher
$sql_marks = "SELECT * FROM marks WHERE teacher_id = '{$_SESSION['user_id']}'";
$result_marks = mysqli_query($happy_conn, $sql_marks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Entry</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Marks Entry</h1>

        <!-- Marks Entry Form -->
        <form method="POST" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Enter Marks</h2>
            
            <div>
                <label for="student_id" class="block text-gray-600">Student ID</label>
                <input type="text" name="student_id" required class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-red-200" />
            </div>

            <div>
                <label for="subject" class="block text-gray-600">Subject</label>
                <input type="text" name="subject" required class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-red-200" />
            </div>

            <div>
                <label for="marks" class="block text-gray-600">Marks</label>
                <input type="number" name="marks" required class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-red-200" />
            </div>

            <button type="submit" name="add_marks" class="w-full bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition">Save Marks</button>
        </form>

        <!-- Display Marks -->
        <h2 class="text-xl font-semibold text-gray-700 mt-6">Marks Entered</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 shadow-md mt-4 rounded-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">Student ID</th>
                        <th class="px-4 py-2 text-left">Subject</th>
                        <th class="px-4 py-2 text-left">Marks</th>
                        <th class="px-4 py-2 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_marks)) { ?>
                        <tr class="border-t">
                            <td class="px-4 py-2"><?php echo $row['student_id']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['subject']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['marks']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['entry_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-red-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
