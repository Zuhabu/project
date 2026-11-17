<?php

session_start();


// ==========================================
// DATABASE CONNECTION
// ==========================================

include "../includes/db.php";


// ==========================================
// CHECK REQUEST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: otp.php");
    exit();

}


// ==========================================
// CHECK STUDENT SESSION
// ==========================================

if (!isset($_SESSION['student_id'])) {

    header("Location: register.php");
    exit();

}


// ==========================================
// GET OTP
// ==========================================

$otp = trim($_POST['otp'] ?? '');

$student_id = $_SESSION['student_id'];


// ==========================================
// CHECK OTP EMPTY
// ==========================================

if (empty($otp)) {

    echo "<script>

        alert('Please enter the OTP.');

        window.location='otp.php';

    </script>";

    exit();

}


// ==========================================
// CHECK OTP FROM DATABASE
// ==========================================

$sql = "SELECT * FROM students
        WHERE student_id = ? AND otp = ?";

$stmt = $conn->prepare($sql);


if (!$stmt) {

    die("Database Error: " . $conn->error);

}


$stmt->bind_param("ss", $student_id, $otp);

$stmt->execute();

$result = $stmt->get_result();


// ==========================================
// OTP CORRECT
// ==========================================

if ($result->num_rows === 1) {


    // ======================================
    // UPDATE STUDENT VERIFICATION
    // ======================================

    $update = "UPDATE students
               SET verified = 'Yes',
                   otp = NULL
               WHERE student_id = ?";


    $stmt2 = $conn->prepare($update);


    if (!$stmt2) {

        die("Database Error: " . $conn->error);

    }


    $stmt2->bind_param("s", $student_id);

    $stmt2->execute();

    $stmt2->close();


    // ======================================
    // OTP VERIFIED
    // ======================================

    unset($_SESSION['otp']);

    unset($_SESSION['student_db_id']);

    unset($_SESSION['email']);

    unset($_SESSION['fullname']);

    unset($_SESSION['student_id']);


    echo "<script>

        alert('OTP Verified Successfully! You can now login.');

        window.location='login.php';

    </script>";


} else {


    // ======================================
    // OTP INCORRECT
    // ======================================

    echo "<script>

        alert('Invalid OTP. Please try again.');

        window.location='otp.php';

    </script>";

}


// ==========================================
// CLOSE CONNECTION
// ==========================================

$stmt->close();

$conn->close();

?>