<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

// Count Students
$students = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students"));

// Count Candidates
$candidates = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM candidates"));

// Count Votes
$votes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM votes"));

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background:#f4f6f9;
    font-family:Arial,Helvetica,sans-serif;
}

.sidebar{
    position:fixed;
    width:250px;
    height:100vh;
    background:#0F4C81;
}

.sidebar h3{
    color:white;
    text-align:center;
    padding:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 25px;
}

.sidebar a:hover{
    background:#145b94;
}

.main{
    margin-left:250px;
    padding:30px;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.icon{
    font-size:45px;
}

</style>

</head>

<body>

<div class="sidebar">

<h3>Admin Panel</h3>

<a href="dashboard.php">
<i class="fa-solid fa-house"></i>
Dashboard
</a>

<a href="students.php">
<i class="fa-solid fa-users"></i>
Students
</a>

<a href="candidates.php">
<i class="fa-solid fa-user-check"></i>
Candidates
</a>

<a href="results.php">
<i class="fa-solid fa-chart-column"></i>
Results
</a>

<a href="reports.php">
<i class="fa-solid fa-file-pdf"></i>
Reports
</a>

<a href="settings.php">
<i class="fa-solid fa-gear"></i>
Settings
</a>




<a href="logout.php">
<i class="fa-solid fa-right-from-bracket"></i>
Logout
</a>

</div>

<div class="main">

<h2>

Welcome,

<?php echo $_SESSION['admin_name']; ?>

</h2>

<hr>

<div class="row">

<div class="col-md-4">

<div class="card p-4 text-center">

<i class="fa-solid fa-user-graduate icon text-primary"></i>

<h2 class="mt-3">

<?php echo $students; ?>

</h2>

<h5>Total Students</h5>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<i class="fa-solid fa-users icon text-success"></i>

<h2 class="mt-3">

<?php echo $candidates; ?>

</h2>

<h5>Total Candidates</h5>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<i class="fa-solid fa-check icon text-danger"></i>

<h2 class="mt-3">

<?php echo $votes; ?>

</h2>

<h5>Total Votes</h5>

</div>

</div>

</div>

<br>

<div class="row">

<div class="col-md-8">

<div class="card p-4">

<h3>Election Status</h3>

<hr>

<div class="alert alert-success">

Election Status :
<b>ACTIVE</b>

</div>

<p>

Students can vote during the election period.

</p>

</div>

</div>

<div class="col-md-4">

<div class="card p-4">

<h4>Quick Actions</h4>

<hr>

<a href="students.php" class="btn btn-primary w-100 mb-2">

Manage Students

</a>

<a href="candidates.php" class="btn btn-success w-100 mb-2">

Manage Candidates

</a>

<a href="results.php" class="btn btn-warning w-100 mb-2">

View Results

</a>

<a href="reports.php" class="btn btn-info w-100">

Generate Reports

</a>

</div>

</div>

</div>

<br>

<div class="card p-4">

<h3>Recent Activity</h3>

<hr>

<table class="table table-bordered">

<tr>

<th>Activity</th>

<th>Status</th>

</tr>

<tr>

<td>Student Registration</td>

<td>Completed</td>

</tr>

<tr>

<td>Candidate Registration</td>

<td>Completed</td>

</tr>

<tr>

<td>Voting Started</td>

<td>Active</td>

</tr>

</table>

</div>

</div>

</body>

</html>