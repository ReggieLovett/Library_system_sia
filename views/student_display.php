<?php
include '../connection/dbconn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        a { text-decoration: none; }
    </style>
</head>
<body>
    <h2>Student List</h2>
    <a href="../index.php">Back to Home</a>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM students";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['program']}</td>
                        <td>{$row['year_section']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No students found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
