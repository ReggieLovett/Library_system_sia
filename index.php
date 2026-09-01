<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Transactions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { max-width: 420px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { margin-top: 16px; padding: 10px 16px; cursor: pointer; }
        .top-links { margin-bottom: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Library Transaction Record</h2>

    <div class="top-links">
        <a href="views/transaction_display.php">View Transactions</a>
        <br><br>
        <a href="views/student_display.php">View Students</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <p class="success">Transaction saved successfully.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">Please fill in all required fields.</p>
    <?php endif; ?>

    <form action="functions/transaction_add.php" method="POST">
        <label for="trans_id">Transaction ID</label>
        <input type="number" name="trans_id" id="trans_id" placeholder="Leave blank to auto-generate">

        <label for="book_burrowed">Book Borrowed</label>
        <input type="text" name="book_burrowed" id="book_burrowed" required>

        <label for="date_burrowed">Date Borrowed</label>
        <input type="date" name="date_burrowed" id="date_burrowed" required>

        <label for="status">Status</label>
        <select name="status" id="status" required>
            <option value="">Select Status</option>
            <option value="Borrowed">Borrowed</option>
            <option value="Returned">Returned</option>
            <option value="Overdue">Overdue</option>
        </select>

        <label for="librarian_incharge">Librarian Incharge</label>
        <input type="text" name="librarian_incharge" id="librarian_incharge" required>

        <label for="student_id">Student ID</label>
        <input type="number" name="student_id" id="student_id" required>

        <button type="submit">Save Transaction</button>
    </form>
</body>
</html>