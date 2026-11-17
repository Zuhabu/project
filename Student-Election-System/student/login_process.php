<?php

session_start();

include "../includes/db.php";


// ==========================================
// CHECK REQUEST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: login.php");

    exit();

}


// ==========================================
// GET FORM DATA
// ==========================================

$student_id = trim($_POST['student_id'] ?? '');

$password = $_POST['password'] ?? '';


// ==========================================
// CHECK EMPTY
// ==========================================

if (empty($student_id) || empty($password)) {

    echo "<script>

        alert('Please enter Student ID and Password.');

        window.location='login.php';

    </script>";

    exit();

}


// ==========================================
// FIND STUDENT
// ==========================================

$sql = "
    SELECT
        id,
        student_id,
        fullname,
        email,
        department,
        academic_year,
        password,
        otp,
        verified,
        has_voted
    FROM students
    WHERE student_id = ?
";


$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("Database Error: " . $conn->error);

}


$stmt->bind_param("s", $student_id);

$stmt->execute();

$result = $stmt->get_result();


// ==========================================
// STUDENT FOUND
// ==========================================

if ($result->num_rows === 1) {

    $student = $result->fetch_assoc();


    // ======================================
    // CHECK PASSWORD
    // ======================================

    if (!password_verify($password, $student['password'])) {

        echo "<script>

            alert('Incorrect Password.');

            window.location='login.php';

        </script>";

        exit();

    }


    // ======================================
    // CHECK OTP VERIFICATION
    // ======================================

    if ($student['verified'] !== 'Yes') {

        $_SESSION['student_db_id'] = $student['id'];

        $_SESSION['student_id'] = $student['student_id'];

        $_SESSION['fullname'] = $student['fullname'];

        $_SESSION['email'] = $student['email'];


        echo "<script>

            alert('Please verify your email using OTP.');

            window.location='otp.php';

        </script>";

        exit();

    }


    // ======================================
    // LOGIN SUCCESS
    // ======================================

    $_SESSION['student_db_id'] = $student['id'];

    $_SESSION['student_id'] = $student['student_id'];

    $_SESSION['fullname'] = $student['fullname'];

    $_SESSION['email'] = $student['email'];

    $_SESSION['department'] = $student['department'];

    $_SESSION['academic_year'] = $student['academic_year'];

    $_SESSION['verified'] = $student['verified'];

    $_SESSION['has_voted'] = $student['has_voted'];


    // ======================================
    // GO TO DASHBOARD
    // ======================================

    header("Location: dashboard.php");

    exit();

}


// ==========================================
// STUDENT NOT FOUND
// ==========================================

else {

    echo "<script>

        alert('Student ID not found.');

        window.location='login.php';

    </script>";

    exit();

}


$stmt->close();

$conn->close();

?>