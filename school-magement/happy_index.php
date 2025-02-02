<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body>
<main>
    <h1>Registration form</h1>
  <form method="post">
    <div>
      <label  for="fName">Full Name</label>
      <input type="text" name="fName" id="fName" required>
    </div>
    <div>
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div>
      <label for="age">Age</label>
      <input type="number" name="age">
    </div>
    <div>
      <label for="course">Course</label>
      <select name="course">
        <option value="NET">NET</option>
        <option value="SOD">SOD</option>
        <option value="ELS">ELS</option>
      </select>
    </div>
    <div>
      <button type="submit" name="submit">Submit</button>
    </div>
  </form>

  <!-- correct PHP code 😔 -->

  <?php
  $DB_Server = "localhost";
  $DB_Username = "root";
  $DB_Password = "";
  $DB="school_management";
  $happy_conn = mysqli_connect($DB_Server, $DB_Username, $DB_Password , $DB);
  
  if (!$happy_conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  if(isset($_POST['submit'])) {
      $fName = $_POST['fName'];
      $email = $_POST['email'];
      $age = $_POST['age'];
      $course = $_POST['course'];

      // Insert data into database
      $sql = "INSERT INTO students (full_name, email, age, course) VALUES ('$fName', '$email', $age, '$course')";

      if (mysqli_query($happy_conn, $sql)) {
        echo "<script>alert('Record added successfully'); window.location.href='happy_read.php';</script>";
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($happy_conn);
      }
  }

  mysqli_close($happy_conn);
  ?>
</main>
</body>
</html>
