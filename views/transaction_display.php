<?php
include '../connection/dbconn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        a { text-decoration: none; }
    </style>
</head>
<body>
    <h2>Library Transactions</h2>
    <a href="../index.php">Back to Home</a>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>trans_id</th>
                <th>book_burrowed</th>
                <th>date_burrowed</th>
                <th>status</th>
                <th>librarian_incharge</th>
                <th>student_id</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM library ORDER BY trans_id DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['trans_id']}</td>
                        <td>{$row['book_burrowed']}</td>
                        <td>{$row['date_burrowed']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['librarian_incharge']}</td>
                        <td>{$row['student_id']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No transactions found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
