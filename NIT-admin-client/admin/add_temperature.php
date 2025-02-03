<?php
session_start();
include_once('../backend/config.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_point = mysqli_real_escape_string($ineza_conn, $_POST['data_point']);
    $temperature = mysqli_real_escape_string($ineza_conn, $_POST['temperature']);
    $humidity = mysqli_real_escape_string($ineza_conn, $_POST['humidity']);
    $user_id = $_SESSION['user_id']; // Fetch logged-in user ID

    // Insert data into database
    $sql = "INSERT INTO ineza_tbltemperature (data_point, temperature, humidity, user_id) 
            VALUES ('$data_point', '$temperature', '$humidity', '$user_id')";
    
    if (mysqli_query($ineza_conn, $sql)) {
        $success_message = "Temperature data added successfully!";
    } else {
        $error_message = "Error: " . mysqli_error($ineza_conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Temperature Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center py-10">

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg border-t-4 border-blue-500">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Add Temperature Data</h1>

        <?php if (isset($success_message)) : ?>
            <p class="text-green-600 text-center mb-4"><?= $success_message ?></p>
        <?php endif; ?>

        <?php if (isset($error_message)) : ?>
            <p class="text-red-600 text-center mb-4"><?= $error_message ?></p>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold">Data Point</label>
                <input type="text" name="data_point" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Temperature (°C)</label>
                <input type="number" step="0.01" name="temperature" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Humidity (%)</label>
                <input type="number" step="0.01" name="humidity" required class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded transition">
                Add Data
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="temperature_list.php" class="text-gray-600 hover:text-blue-500 font-semibold">View Temperature Data</a> | 
            <a href="dashboard.php" class="text-gray-600 hover:text-blue-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
