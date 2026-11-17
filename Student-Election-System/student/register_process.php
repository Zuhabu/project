<?php

session_start();

include "../includes/db.php";


// ==========================================
// CHECK REQUEST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: register.php");
    exit();

}


// ==========================================
// GET FORM DATA
// ==========================================

$fullname = trim($_POST['fullname'] ?? '');

$student_id = trim($_POST['student_id'] ?? '');

$email = trim($_POST['email'] ?? '');

$department = trim($_POST['department'] ?? '');

$year = trim($_POST['year'] ?? '');

$password = $_POST['password'] ?? '';

$confirm_password = $_POST['confirm_password'] ?? '';


// ==========================================
// CHECK EMPTY
// ==========================================

if (
    empty($fullname) ||
    empty($student_id) ||
    empty($email) ||
    empty($department) ||
    empty($year) ||
    empty($password) ||
    empty($confirm_password)
) {

    echo "<script>

        alert('All fields are required.');

        window.location='register.php';

    </script>";

    exit();

}


// ==========================================
// CHECK PASSWORD
// ==========================================

if ($password !== $confirm_password) {

    echo "<script>

        alert('Passwords do not match.');

        window.location='register.php';

    </script>";

    exit();

}


// ==========================================
// CHECK STUDENT ELIGIBILITY
// ==========================================

$sql = "
    SELECT id
    FROM eligible_students
    WHERE student_id = ?
    AND status = 'Eligible'
";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("Database Error: " . $conn->error);

}

$stmt->bind_param("s", $student_id);

$stmt->execute();

$result = $stmt->get_result();


// Student is NOT eligible

if ($result->num_rows == 0) {

    echo "<script>

        alert('You are not eligible to register for this election.');

        window.location='register.php';

    </script>";

    $stmt->close();

    $conn->close();

    exit();

}

$stmt->close();


// ==========================================
// CHECK STUDENT ID
// ==========================================

$sql = "SELECT id FROM students WHERE student_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("Database Error: " . $conn->error);

}

$stmt->bind_param("s", $student_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo "<script>

        alert('Student ID already exists.');

        window.location='register.php';

    </script>";

    $stmt->close();

    $conn->close();

    exit();

}

$stmt->close();


// ==========================================
// CHECK EMAIL
// ==========================================

$sql = "SELECT id FROM students WHERE email = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("Database Error: " . $conn->error);

}

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo "<script>

        alert('Email already registered.');

        window.location='register.php';

    </script>";

    $stmt->close();

    $conn->close();

    exit();

}

$stmt->close();


// ==========================================
// HASH PASSWORD
// ==========================================

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);


// ==========================================
// GENERATE OTP
// ==========================================

$otp = rand(100000, 999999);


// ==========================================
// INSERT STUDENT
// ==========================================

$sql = "
    INSERT INTO students
    (
        student_id,
        fullname,
        email,
        department,
        academic_year,
        password,
        otp,
        verified,
        has_voted
    )
    VALUES
    (?, ?, ?, ?, ?, ?, ?, 'No', 'No')
";


$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("Database Error: " . $conn->error);

}


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


// ==========================================
// SAVE STUDENT
// ==========================================

if ($stmt->execute()) {

    // Save student information in session

    $_SESSION['student_id'] = $student_id;

    $_SESSION['fullname'] = $fullname;

    $_SESSION['email'] = $email;

    $_SESSION['student_db_id'] = $stmt->insert_id;

    $_SESSION['otp'] = $otp;


    echo "<script>

        alert('Registration Successful! Your OTP is: $otp');

        window.location='otp.php';

    </script>";

} else {

    echo "<script>

        alert('Registration Failed.');

        window.location='register.php';

    </script>";

}


$stmt->close();

$conn->close();

?>