<?php
// ===============================
// Student Election Management System
// Database Connection
// ===============================

// Database Settings
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "student_election";

// Create Connection
$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set Character Encoding
$conn->set_charset("utf8");

// Uncomment this line if you want to test the connection
// echo "Database Connected Successfully!";
?>