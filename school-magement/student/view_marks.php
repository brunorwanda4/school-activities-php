<?php
// student/view_marks.php
session_start();
include_once('../backend/config.php');

// Ensure the user is a student
if ($_SESSION['user_type'] !== 'student') {
    header('Location: ../backend/login.php');
    exit();
}

// Fetch marks for the student
$sql = "SELECT * FROM marks WHERE student_id = '{$_SESSION['student_id']}'";
$result = mysqli_query($happy_conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Marks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-violet-600 mb-4">Your Marks</h1>

        <!-- Display Marks -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-md">
                <thead class="bg-violet-500 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Subject</th>
                        <th class="px-4 py-2 text-left">Marks</th>
                        <th class="px-4 py-2 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="border-t">
                            <td class="px-4 py-2"><?php echo $row['subject']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['marks']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['entry_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-violet-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>