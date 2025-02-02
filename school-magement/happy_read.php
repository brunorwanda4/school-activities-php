<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #ddd;
    }
    .actions {
      display: flex;
      justify-content: space-around;
    }
    a {
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
      list-style: none;
      text-decoration: none;
    }
    a {
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      font-size: 14px;
    }
  </style>
</head>
<body>
<main>
    <h1>Registered Students</h1>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Age</th>
          <th>Course</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $DB_Server = "localhost";
        $DB_Username = "root";
        $DB_Password = "";
        $DB="school_management";
        $happy_conn = mysqli_connect($DB_Server, $DB_Username, $DB_Password , $DB);
        // Fetch data from database
        $sql = "SELECT * FROM students";
        $result = mysqli_query($happy_conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['full_name']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['age']."</td>";
                echo "<td>".$row['course']."</td>";
                echo "<td class='actions'>";
                echo "<a style='background-color: #007bff;' href='happy_update.php?id=".$row['id']."'>Update</a>";
                echo "<a style='background-color:red;' href='happy_delete.php?id=".$row['id']."'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }

        mysqli_close($happy_conn);
        ?>
      </tbody>
    </table>
</main>
</body>
</html>
