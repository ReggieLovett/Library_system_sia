<?php
include '../connection/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trans_id = isset($_POST['trans_id']) && $_POST['trans_id'] !== '' ? intval($_POST['trans_id']) : null;
    $book_burrowed = trim($_POST['book_burrowed'] ?? '');
    $date_burrowed = trim($_POST['date_burrowed'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $librarian_incharge = trim($_POST['librarian_incharge'] ?? '');
    $student_id = isset($_POST['student_id']) && $_POST['student_id'] !== '' ? intval($_POST['student_id']) : null;

    if ($book_burrowed === '' || $date_burrowed === '' || $status === '' || $librarian_incharge === '' || $student_id === null) {
        header('Location: ../index.php?error=1');
        exit;
    }

    if ($trans_id !== null) {
        $sql = "INSERT INTO library (trans_id, book_burrowed, date_burrowed, status, librarian_incharge, student_id) VALUES ($trans_id, '$book_burrowed', '$date_burrowed', '$status', '$librarian_incharge', $student_id)";
    } else {
        $sql = "INSERT INTO library(book_burrowed, date_burrowed, status, librarian_incharge, student_id) VALUES ('$book_burrowed', '$date_burrowed', '$status', '$librarian_incharge', $student_id)";
    }

    if (mysqli_query($conn, $sql)) {
        header('Location: ../index.php?success=1');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header('Location: ../index.php');
}
