<?php
session_start();

include "includes/db.php";

// Check Request
if($_SERVER["REQUEST_METHOD"] != "POST"){

    header("Location: login.php");
    exit();

}

// Get Data
$student_id = trim($_POST['student_id']);
$password   = $_POST['password'];

// Check Empty
if(empty($student_id) || empty($password)){

    echo "<script>

    alert('Please enter Student ID and Password');

    window.location='login.php';

    </script>";

    exit();

}

// Find Student
$sql = "SELECT * FROM students WHERE student_id=?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s",$student_id);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==1){

    $student = $result->fetch_assoc();

    // Verify Password
    if(password_verify($password,$student['password'])){

        // Check Verification
        if($student['verified']=="No"){

            echo "<script>

            alert('Please verify your email using OTP.');

            window.location='otp.php';

            </script>";

            $_SESSION['student_id']=$student['student_id'];
            $_SESSION['email']=$student['email'];

            exit();

        }

        // Login Success
        $_SESSION['student_id']=$student['student_id'];
        $_SESSION['fullname']=$student['fullname'];
        $_SESSION['student_db_id']=$student['id'];

        header("Location: student/dashboard.php");
        exit();

    }

    else{

        echo "<script>

        alert('Incorrect Password');

        window.location='login.php';

        </script>";

    }

}

else{

    echo "<script>

    alert('Student ID Not Found');

    window.location='login.php';

    </script>";

}

$stmt->close();

$conn->close();

?>