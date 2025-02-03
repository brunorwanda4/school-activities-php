<?php
session_start();
include_once('../backend/config.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

// Get ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid request.'); window.location.href='temperature_list.php';</script>";
    exit();
}

$id = mysqli_real_escape_string($ineza_conn, $_GET['id']);
$query = "SELECT * FROM ineza_tbltemperature WHERE id = '$id'";
$result = mysqli_query($ineza_conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Temperature data not found.'); window.location.href='temperature_list.php';</script>";
    exit();
}

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_point = mysqli_real_escape_string($ineza_conn, $_POST['data_point']);
    $temperature = mysqli_real_escape_string($ineza_conn, $_POST['temperature']);
    $humidity = mysqli_real_escape_string($ineza_conn, $_POST['humidity']);

    $update_query = "UPDATE ineza_tbltemperature 
                     SET data_point = '$data_point', temperature = '$temperature', humidity = '$humidity' 
                     WHERE id = '$id'";

    if (mysqli_query($ineza_conn, $update_query)) {
        echo "<script>alert('Temperature data updated successfully!'); window.location.href='temperature_list.php';</script>";
    } else {
        echo "<script>alert('Error updating data: " . mysqli_error($ineza_conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Temperature Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center py-10">

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg border-t-4 border-blue-500">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Edit Temperature Data</h1>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold">Data Point</label>
                <input type="text" name="data_point" value="<?= htmlspecialchars($data['data_point']) ?>" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Temperature (°C)</label>
                <input type="number" step="0.01" name="temperature" value="<?= htmlspecialchars($data['temperature']) ?>" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Humidity (%)</label>
                <input type="number" step="0.01" name="humidity" value="<?= htmlspecialchars($data['humidity']) ?>" required class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded transition">
                Update Data
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="temperature_list.php" class="text-gray-600 hover:text-blue-500 font-semibold">View Temperature Data</a> | 
            <a href="dashboard.php" class="text-gray-600 hover:text-blue-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
