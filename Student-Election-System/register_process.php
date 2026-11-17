<?php

session_start();

include "includes/db.php";

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: register.php");
    exit();
}

// Get form values
$fullname   = trim($_POST['fullname']);
$student_id = trim($_POST['student_id']);
$email      = trim($_POST['email']);
$department = trim($_POST['department']);
$year       = trim($_POST['year']);
$password   = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if($password != $confirm_password){
    die("Passwords do not match.");
}

// Basic Validation
if (
    empty($fullname) ||
    empty($student_id) ||
    empty($email) ||
    empty($department) ||
    empty($year) ||
    empty($password)
) {
    die("All fields are required.");
}

// Check Student ID
$sql = "SELECT id FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Student ID already exists.");
}

$stmt->close();

// Check Email
$sql = "SELECT id FROM students WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Email already registered.");
}

$stmt->close();

// Encrypt Password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Generate OTP
$otp = rand(100000,999999);

// Insert Student
$sql = "INSERT INTO students
(student_id,fullname,email,department,academic_year,password,otp,verified,has_voted)

VALUES(?,?,?,?,?,?,?,'No','No')";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
"sssssss",
$student_id,
$fullname,
$email,
$department,
$year,
$hashedPassword,
$otp
);

if($stmt->execute()){

    $_SESSION['email']=$email;
    $_SESSION['otp']=$otp;

    echo "<script>

    alert('Registration Successful! Your OTP is: $otp');

    window.location='login.php';

    </script>";

}else{

    echo "Registration Failed.";

}

$stmt->close();

$conn->close();

?>