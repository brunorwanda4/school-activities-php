<?php
session_start();
include_once('../backend/config.php');  // Include database connection

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php');
    exit();
}

// Get Teacher ID from session
$teacher_id = $_SESSION['user_id'];

// Fetch all students for the teacher to view
$sql = "SELECT * FROM students";
$students_result = mysqli_query($happy_conn, $sql);

// View Marks for a specific student
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch marks for the selected student
    $marks_sql = "SELECT * FROM marks WHERE student_id = '$student_id' AND teacher_id = '$teacher_id'";
    $marks_result = mysqli_query($happy_conn, $marks_sql);
    $student_info = mysqli_fetch_assoc(mysqli_query($happy_conn, "SELECT * FROM students WHERE student_id = '$student_id'"));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-violet-600">View Students</h1>
            <a href="../backend/login.php" class="text-violet-500 hover:underline">Logout</a>
        </div>

        <!-- List of Students -->
        <table class="w-full border-collapse bg-white shadow-md rounded-md">
            <thead>
                <tr class="bg-violet-500 text-white">
                    <th class="p-3 text-left">Student Name</th>
                    <th class="p-2">Student ID</th>
                    <th class="p-3 text-left">Class</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
                    <tr class="border-b">
                        <td class="p-3"> <?php echo $student['name']; ?> </td>
                        <td class="p-2"><?php echo $student['student_id']; ?></td>  <!-- ✅ FIXED HERE -->
                        <td class="p-3"> <?php echo $student['class']; ?> </td>
                        <td class="p-3">
                            <a href="?student_id=<?php echo $student['student_id']; ?>" class="bg-violet-500 hover:bg-violet-600 text-white px-4 py-2 rounded-md">View Marks</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (isset($marks_result)) { ?>
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Marks for <?php echo $student_info['name']; ?></h2>
                <table class="w-full border-collapse bg-white shadow-md rounded-md">
                    <thead>
                        <tr class="bg-violet-500 text-white">
                            <th class="p-3 text-left">Subject</th>
                            <th class="p-3 text-left">Marks</th>
                            <th class="p-3 text-left">Entry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($mark = mysqli_fetch_assoc($marks_result)) { ?>
                            <tr class="border-b">
                                <td class="p-3"> <?php echo $mark['subject']; ?> </td>
                                <td class="p-3"> <?php echo $mark['marks']; ?> </td>
                                <td class="p-3"> <?php echo $mark['entry_date']; ?> </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
