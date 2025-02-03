<?php
session_start();
include_once('../backend/config.php');  


if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../frontend/login.html');  
    exit();
}

if (isset($_POST['add_student'])) {
    $name = htmlspecialchars($_POST['name']);
    $student_id = htmlspecialchars($_POST['student_id']);
    $class = htmlspecialchars($_POST['class']);
    $other_details = htmlspecialchars($_POST['other_details']);
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $karine_conn->prepare("INSERT INTO students (name, student_id, class, other_details, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $student_id, $class, $other_details, $hashed_password);

    if ($stmt->execute()) {
        header("Location: manage_students.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

if (isset($_POST['edit_student'])) {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $student_id = htmlspecialchars($_POST['student_id']);
    $class = htmlspecialchars($_POST['class']);
    $other_details = htmlspecialchars($_POST['other_details']);
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $karine_conn->prepare("UPDATE students SET name=?, student_id=?, class=?, other_details=?, password=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $student_id, $class, $other_details, $hashed_password, $id);
    } else {
        $stmt = $karine_conn->prepare("UPDATE students SET name=?, student_id=?, class=?, other_details=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $student_id, $class, $other_details, $id);
    }

    if ($stmt->execute()) {
        header("Location: manage_students.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $stmt = $karine_conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: manage_students.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
$sql = "SELECT * FROM students";
$result = mysqli_query($karine_conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 2rem;
            background-color: #f8f9fa;
            color: #2c3e50;
        }

        a[href="../backend/logout.php"], 
        button[onclick="window.history.back()"] {
            position: fixed;
            top: 1rem;
            padding: 0.75rem 1.25rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: white;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        a[href="../backend/logout.php"] { right: 1rem; }
        button[onclick="window.history.back()"] { left: 1rem; }

        h1 {
            font-weight: 300;
            margin: 3rem 0 2rem;
            text-align: center;
            font-size: 2.25rem;
        }

        form {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        form h2 {
            margin: 0 0 1.5rem;
            font-weight: 400;
            color: #7f8c8d;
            font-size: 1.25rem;
        }

        label {
            display: block;
            margin: 1rem 0 0.5rem;
            color: #95a5a6;
            font-size: 0.9rem;
        }

        input, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 1rem;
            box-sizing: border-box;
            font-size: 1rem;
        }

        button[type="submit"] {
            background: #3498db;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            margin-top: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        button[type="submit"]:hover {
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin: 2rem 0;
            overflow: hidden;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            background-color: #f8f9fa;
            color: #7f8c8d;
            font-weight: 500;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #fafafa;
        }

        td a {
            color: #3498db;
            padding: 0.25rem 0.5rem;
            margin: 0 0.25rem;
            border-radius: 4px;
            transition: background 0.2s;
        }

        td a:hover {
            background: #f0f0f0;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            form {
                padding: 1.5rem;
                margin: 1rem 0;
            }
            
            h1 {
                font-size: 1.75rem;
                margin: 2rem 0;
            }
        }
    </style>
</head>
<body>

<a href="../backend/logout.php">Logout</a>
<a href="dashboard.php">back to dashboard</a>

<h1>Manage Students</h1>

<form method="POST">
    <h2>Add New Student</h2>
    <label>Name</label>
    <input type="text" name="name" required>
    
    <label>Student ID</label>
    <input type="text" name="student_id" required>
    
    <label>Class</label>
    <input type="text" name="class" required>
    
    <label>Other Details</label>
    <textarea name="other_details"></textarea>
    
    <label>Password</label>
    <input type="password" name="password" required>
    
    <button type="submit" name="add_student">Add Student</button>
</form>

<!-- Edit Student Form -->
<?php if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $karine_conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
?>
    <form method="POST">
        <h2>Edit Student</h2>
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
        
        <label>Student ID</label>
        <input type="text" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>" required>
        
        <label>Class</label>
        <input type="text" name="class" value="<?php echo htmlspecialchars($student['class']); ?>" required>
        
        <label>Other Details</label>
        <textarea name="other_details"><?php echo htmlspecialchars($student['other_details']); ?></textarea>
        
        <label>Password (Leave empty if not changing)</label>
        <input type="password" name="password">
        
        <button type="submit" name="edit_student">Update Student</button>
    </form>
<?php } ?>

<!-- Display all students -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Student ID</th>
            <th>Class</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
            <td><?php echo htmlspecialchars($row['class']); ?></td>
            <td>
                <a href="?edit=<?php echo $row['id']; ?>">Edit</a> |
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
