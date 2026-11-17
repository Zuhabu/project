<?php

session_start();

include "../includes/db.php";


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION['student_db_id'])) {

    header("Location: login.php");
    exit();

}


// ==========================================
// ONLY ALLOW POST REQUEST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: profile.php");
    exit();

}


$student_db_id = $_SESSION['student_db_id'];


// ==========================================
// GET FORM DATA
// ==========================================

$fullname = trim($_POST['fullname'] ?? '');

$email = trim($_POST['email'] ?? '');

$department = trim($_POST['department'] ?? '');

$academic_year = trim($_POST['academic_year'] ?? '');


// ==========================================
// VALIDATION
// ==========================================

if (
    empty($fullname) ||
    empty($email) ||
    empty($department) ||
    empty($academic_year)
) {

    header("Location: edit_profile.php?error=empty");

    exit();

}


// ==========================================
// VALIDATE EMAIL
// ==========================================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header("Location: edit_profile.php?error=email");

    exit();

}


// ==========================================
// UPDATE PROFILE
// ==========================================

$sql = "
    UPDATE students
    SET
        fullname = ?,
        email = ?,
        department = ?,
        academic_year = ?
    WHERE id = ?
";


$stmt = $conn->prepare($sql);


if (!$stmt) {

    header("Location: edit_profile.php?error=failed");

    exit();

}


$stmt->bind_param(
    "ssssi",
    $fullname,
    $email,
    $department,
    $academic_year,
    $student_db_id
);


// ==========================================
// EXECUTE
// ==========================================

if ($stmt->execute()) {

    $stmt->close();

    $conn->close();

    header("Location: profile.php?updated=1");

    exit();

} else {

    $stmt->close();

    $conn->close();

    header("Location: edit_profile.php?error=failed");

    exit();

}

?>