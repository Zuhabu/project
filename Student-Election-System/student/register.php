

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body{
            background:linear-gradient(135deg,#0F4C81,#1B6CA8);
            font-family:Arial,Helvetica,sans-serif;
        }

        .register-card{
            margin-top:40px;
            margin-bottom:40px;
            background:white;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,.3);
            overflow:hidden;
        }

        .left-panel{
            background:#0F4C81;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;
            padding:40px;
        }

        .left-panel i{
            font-size:80px;
            margin-bottom:20px;
        }

        .right-panel{
            padding:40px;
        }

        .form-control,
        .form-select{
            height:50px;
        }

        .btn-register{
            background:#0F4C81;
            color:white;
            height:50px;
            font-weight:bold;
        }

        .btn-register:hover{
            background:#0b3960;
            color:white;
        }

    </style>

</head>

<body>

<div class="container">

<div class="register-card">

<div class="row">

<div class="col-md-5 left-panel">

<i class="fa-solid fa-user-graduate"></i>

<h2>Student Registration</h2>

<p class="text-center mt-3">

Create your account to participate in the Faculty Student Union Election.

</p>

</div>

<div class="col-md-7 right-panel">

<h3 class="mb-4">Register</h3>

<form action="register_process.php" method="POST">

<div class="mb-3">

<label>Full Name</label>

<input
type="text"
name="fullname"
class="form-control"
placeholder="Enter Full Name"
required>

</div>

<div class="mb-3">

<label>Student ID</label>

<input
type="text"
name="student_id"
class="form-control"
placeholder="SEU/IS/21/AT/192"
required>

</div>

<div class="mb-3">

<label>University Email</label>

<input
type="email"
name="email"
class="form-control"
placeholder="example@seu.ac.lk"
required>

</div>

<div class="mb-3">

<label>Department</label>

<select
name="department"
class="form-select"
required>

<option value="">Select Department</option>

<option>Information Technology</option>

<option>Geography</option>

<option>Tamil</option>

<option>History</option>

<option>sociology </option>



</select>

</div>

<div class="mb-3">

<label>Academic Year</label>

<select
name="year"
class="form-select"
required>

<option value="">Select Year</option>

<option>1st Year</option>

<option>2nd Year</option>

<option>3rd Year</option>

<option>4th Year</option>

</select>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
id="password"
class="form-control"
placeholder="Create Password"
required>

</div>

<div class="mb-3">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
id="confirm_password"
class="form-control"
placeholder="Confirm Password"
required>

</div>

<div class="form-check mb-4">

<input
class="form-check-input"
type="checkbox"
onclick="showPassword()">

<label class="form-check-label">

Show Password

</label>

</div>

<button
class="btn btn-register w-100">

<i class="fa-solid fa-user-plus"></i>

Register

</button>

<div class="text-center mt-4">

Already have an account?

<a href="login.php">

Login Here

</a>

</div>

</form>

</div>

</div>

</div>

</div>

<script>

function showPassword(){

let pass=document.getElementById("password");

let confirm=document.getElementById("confirm_password");

if(pass.type==="password"){

pass.type="text";
confirm.type="text";

}else{

pass.type="password";
confirm.type="password";

}

}

</script>

</body>

</html>