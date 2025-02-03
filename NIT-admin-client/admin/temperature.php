<?php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is logged in (admin or regular user)
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  // Redirect to login if not logged in
    exit();
}

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('User session not found. Please log in again.'); window.location='../backend/login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id']; // Safe access after check

// Handle Add Temperature Data
if (isset($_POST['add_temperature'])) {
    $data_point = mysqli_real_escape_string($ineza_conn, $_POST['data_point']);
    $temperature = mysqli_real_escape_string($ineza_conn, $_POST['temperature']);
    $humidity = mysqli_real_escape_string($ineza_conn, $_POST['humidity']);

    $sql = "INSERT INTO ineza_tbltemperature (data_point, temperature, humidity, user_id) 
            VALUES ('$data_point', '$temperature', '$humidity', '$user_id')";
    if (mysqli_query($ineza_conn, $sql)) {
        echo "<script>alert('Temperature data added successfully!'); window.location.href='temperature.php';</script>";
    } else {
        echo "<script>alert('Error adding temperature data: " . mysqli_error($ineza_conn) . "');</script>";
    }
}

// Handle Edit Temperature Data
if (isset($_POST['edit_temperature'])) {
    $id = mysqli_real_escape_string($ineza_conn, $_POST['id']);
    $data_point = mysqli_real_escape_string($ineza_conn, $_POST['data_point']);
    $temperature = mysqli_real_escape_string($ineza_conn, $_POST['temperature']);
    $humidity = mysqli_real_escape_string($ineza_conn, $_POST['humidity']);

    $sql = "UPDATE ineza_tbltemperature 
            SET data_point = '$data_point', temperature = '$temperature', humidity = '$humidity' 
            WHERE id = '$id'";
    if (mysqli_query($ineza_conn, $sql)) {
        echo "<script>alert('Temperature data updated successfully!'); window.location.href='temperature.php';</script>";
    } else {
        echo "<script>alert('Error updating temperature data: " . mysqli_error($ineza_conn) . "');</script>";
    }
}

// Handle Delete Temperature Data
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($ineza_conn, $_GET['delete']);
    $sql = "DELETE FROM ineza_tbltemperature WHERE id = '$id'";
    if (mysqli_query($ineza_conn, $sql)) {
        echo "<script>alert('Temperature data deleted successfully!'); window.location.href='temperature.php';</script>";
    } else {
        echo "<script>alert('Error deleting temperature data: " . mysqli_error($ineza_conn) . "');</script>";
    }
}

// Fetch all temperature data
$temperature_data = mysqli_query($ineza_conn, "SELECT * FROM ineza_tbltemperature");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Temperature Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-2xl border-t-4 border-blue-500">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-6">Manage Temperature Data</h1>

        <!-- Add Temperature Data Form -->
        <form method="POST" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Add New Temperature Data</h2>
            <input type="text" name="data_point" placeholder="Data Point" required class="w-full border p-2 rounded">
            <input type="number" step="0.01" name="temperature" placeholder="Temperature (°C)" required class="w-full border p-2 rounded">
            <input type="number" step="0.01" name="humidity" placeholder="Humidity (%)" required class="w-full border p-2 rounded">
            <button type="submit" name="add_temperature" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded transition">Add Data</button>
        </form>

        <!-- Edit Temperature Data Form (if edit is triggered) -->
        <?php if (isset($_GET['edit'])) :
            $id = mysqli_real_escape_string($ineza_conn, $_GET['edit']);
            $data = mysqli_fetch_assoc(mysqli_query($ineza_conn, "SELECT * FROM ineza_tbltemperature WHERE id = '$id'"));
        ?>
            <form method="POST" class="mt-6 space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Edit Temperature Data</h2>
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <input type="text" name="data_point" value="<?php echo $data['data_point']; ?>" required class="w-full border p-2 rounded">
                <input type="number" step="0.01" name="temperature" value="<?php echo $data['temperature']; ?>" required class="w-full border p-2 rounded">
                <input type="number" step="0.01" name="humidity" value="<?php echo $data['humidity']; ?>" required class="w-full border p-2 rounded">
                <button type="submit" name="edit_temperature" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded transition">Update Data</button>
            </form>
        <?php endif; ?>

        <!-- Display Temperature Data -->
        <table class="w-full mt-8 border-collapse">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2">ID</th>
                    <th class="p-2">Data Point</th>
                    <th class="p-2">Temperature (°C)</th>
                    <th class="p-2">Humidity (%)</th>
                    <th class="p-2">Timestamp</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($temperature_data)) : ?>
                    <tr class="border-t">
                        <td class="p-2 text-center"><?php echo $row['id']; ?></td>
                        <td class="p-2"><?php echo $row['data_point']; ?></td>
                        <td class="p-2"><?php echo $row['temperature']; ?></td>
                        <td class="p-2"><?php echo $row['humidity']; ?></td>
                        <td class="p-2"><?php echo $row['timestamp']; ?></td>
                        <td class="p-2 text-center">
                            <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                            <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this data?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-gray-600 hover:text-blue-500 font-semibold">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
