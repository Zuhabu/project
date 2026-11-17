<?php
session_start();

if(isset($_SESSION['admin_id'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{

background:linear-gradient(135deg,#0F4C81,#1B6CA8);

font-family:Arial, Helvetica, sans-serif;

height:100vh;

display:flex;

justify-content:center;

align-items:center;

}

.login-card{

width:420px;

background:white;

border-radius:20px;

padding:40px;

box-shadow:0 10px 30px rgba(0,0,0,.3);

}

.logo{

font-size:70px;

color:#0F4C81;

}

.btn-login{

background:#0F4C81;

color:white;

font-weight:bold;

height:50px;

}

.btn-login:hover{

background:#09375c;

color:white;

}

</style>

</head>

<body>

<div class="login-card">

<div class="text-center">

<i class="fa-solid fa-user-shield logo"></i>

<h2 class="mt-3">

Administrator Login

</h2>

<p>

Student Election Management System

</p>

</div>

<form action="login_process.php" method="POST">

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="d-grid">

<button class="btn btn-login">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

</div>

</form>

<div class="text-center mt-3">

<a href="../index.php">

← Back to Home

</a>

</div>

</div>

</body>

</html>