<?php
session_start();
include_once('../backend/config.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
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

        <div class="text-right mb-4">
            <a href="add_temperature.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">+ Add Temperature Data</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Data Point</th>
                        <th class="py-2 px-4">Temperature (°C)</th>
                        <th class="py-2 px-4">Humidity (%)</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    <?php while ($row = mysqli_fetch_assoc($temperature_data)) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 text-center"><?= $row['id'] ?></td>
                            <td class="py-2 px-4"><?= $row['data_point'] ?></td>
                            <td class="py-2 px-4"><?= $row['temperature'] ?></td>
                            <td class="py-2 px-4"><?= $row['humidity'] ?></td>
                            <td class="py-2 px-4 text-center">
                                <a href="edit_temperature.php?id=<?= $row['id'] ?>" class="text-green-500 hover:text-green-700">Edit</a> |
                                <a href="delete_temperature.php?id=<?= $row['id'] ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-blue-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
