<?php
$host = "srv1865.hstgr.io";
$username = "u619216262_bsit2";
$password = "U619216262_bsit2";
$database = "u619216262_bsit2";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
