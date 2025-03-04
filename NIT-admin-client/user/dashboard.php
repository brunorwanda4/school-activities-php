<?php
session_start();
include_once('../backend/config.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
    header('Location: ../backend/login.php');
    exit();
}

$temperature_data = mysqli_query($ineza_conn, "SELECT * FROM ineza_tbltemperature");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperature Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl border-t-4 border-blue-500">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Temperature Data</h1>

        <div class="text-right mb-4 flex gap-4">
            <a href="add_temperature.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">+ Add Temperature Data</a>
            <a href="../backend/login.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition">Logout</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Data Point</th>
                        <th class="py-2 px-4">Temperature (°C)</th>
                        <th class="py-2 px-4">Humidity (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    <?php while ($row = mysqli_fetch_assoc($temperature_data)) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 text-center"><?= $row['id'] ?></td>
                            <td class="py-2 px-4"><?= $row['data_point'] ?></td>
                            <td class="py-2 px-4"><?= $row['temperature'] ?></td>
                            <td class="py-2 px-4"><?= $row['humidity'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
