<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>OTP Verification</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#0F4C81,#1B6CA8);
    font-family:Arial;
}

.card{
    margin-top:100px;
    border-radius:20px;
    box-shadow:0px 10px 25px rgba(0,0,0,.3);
}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card">

<div class="card-body">

<h2 class="text-center mb-4">

OTP Verification

</h2>

<p class="text-center">

Enter the 6-digit OTP sent to your email.

</p>

<form action="verify_otp.php" method="POST">

<div class="mb-3">

<input
type="text"
name="otp"
class="form-control form-control-lg text-center"
maxlength="6"
placeholder="Enter OTP"
required>

</div>

<button
class="btn btn-primary w-100">

Verify OTP

</button>

</form>

<br>

<div class="text-center">

<a href="login.php">

Back to Login

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>