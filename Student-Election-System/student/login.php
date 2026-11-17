<?php

session_start();

include "../includes/db.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{

background:linear-gradient(135deg,#0F4C81,#1B6CA8);

height:100vh;

display:flex;

justify-content:center;

align-items:center;

font-family:Arial, Helvetica, sans-serif;

}

.login-box{

width:900px;

background:white;

border-radius:20px;

overflow:hidden;

box-shadow:0px 10px 30px rgba(0,0,0,.3);

}

.left{

background:#0F4C81;

color:white;

padding:50px;

height:100%;

}

.left h1{

font-weight:bold;

}

.right{

padding:50px;

}

.form-control{

height:50px;

}

.btn-login{

background:#0F4C81;

color:white;

height:50px;

font-weight:bold;

}

.btn-login:hover{

background:#0c3b63;

color:white;

}

.logo{

font-size:70px;

margin-bottom:20px;

}

</style>

</head>

<body>

<div class="login-box">

<div class="row g-0">

<!-- LEFT SIDE -->

<div class="col-md-6 left d-flex flex-column justify-content-center align-items-center">

<i class="fa-solid fa-vote-yea logo"></i>

<h1>FAC Election</h1>

<p class="text-center">

Student Union Election Management System

</p>

<hr>

<p class="text-center">

Secure Online Voting Platform

</p>

</div>


<!-- RIGHT SIDE -->

<div class="col-md-6 right">

<h2 class="mb-4">

Student Login

</h2>

<form action="login_process.php" method="POST">


<!-- STUDENT ID -->

<div class="mb-3">

<label class="form-label">

Student ID

</label>

<input

type="text"

name="student_id"

class="form-control"

placeholder="SEU/IS/21/AT/192"

required>

</div>


<!-- PASSWORD -->

<div class="mb-3">

<label class="form-label">

Password

</label>

<input

type="password"

name="password"

class="form-control"

placeholder="Enter Password"

required>

</div>


<!-- REMEMBER -->

<div class="d-flex justify-content-between mb-3">

<div>

<input type="checkbox">

Remember Me

</div>

<a href="#">

Forgot Password?

</a>

</div>


<!-- LOGIN BUTTON -->

<button

type="submit"

class="btn btn-login w-100">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>


<!-- REGISTER -->

<div class="text-center mt-4">

Don't have an account?

<a href="register.php">

Register Here

</a>

</div>


</form>

</div>

</div>

</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>