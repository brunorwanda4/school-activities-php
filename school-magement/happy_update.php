<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Student Record</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="./style.css"> 
  
</head>
<body>
<main>
    <h1>Update Student Record</h1>
    <?php
    $DB_Server = "localhost";
    $DB_Username = "root";
    $DB_Password = "";
    $DB="school_management";
    $happy_conn = mysqli_connect($DB_Server, $DB_Username, $DB_Password , $DB);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch student record from database
        $sql = "SELECT * FROM students WHERE id = $id";
        $result = mysqli_query($happy_conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div>
                    <label for="fName">Full Name</label>
                    <input type="text" name="fName" id="fName" value="<?php echo $row['full_name']; ?>" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>" required>
                </div>
                <div>
                    <label for="age">Age</label>
                    <input type="number" name="age" value="<?php echo $row['age']; ?>">
                </div>
                <div>
                    <label for="course">Course</label>
                    <select name="course">
                        <option value="NET" <?php echo ($row['course'] == 'NET') ? 'selected' : ''; ?>>NET</option>
                        <option value="SOD" <?php echo ($row['course'] == 'SOD') ? 'selected' : ''; ?>>SOD</option>
                        <option value="ELS" <?php echo ($row['course'] == 'ELS') ? 'selected' : ''; ?>>ELS</option>
                    </select>
                </div>
                <div>
                    <button type="submit" name="submit">Update</button>
                </div>
            </form>
            <?php
        } else {
            echo "No record found";
        }
    } else {
        echo "No ID specified";
    }

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $fName = $_POST['fName'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $course = $_POST['course'];

        // Update student record in database
        $sql = "UPDATE students SET full_name='$fName', email='$email', age=$age, course='$course' WHERE id=$id";

        if (mysqli_query($happy_conn, $sql)) {
            echo "<script>alert('Record updated successfully'); window.location.href='happy_read.php';</script>";
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($happy_conn);
        }
    }
    mysqli_close($happy_conn);
    ?>
</main>
</body>
</html>
