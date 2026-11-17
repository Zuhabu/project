<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

// Dashboard Statistics
$totalStudents=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students"));
$totalCandidates=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM candidates"));
$totalVotes=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM votes"));

?>

<!DOCTYPE html>
<html>

<head>

<title>Election Reports</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
font-family:Arial;
}

.sidebar{
width:250px;
height:100vh;
background:#0F4C81;
position:fixed;
}

.sidebar h3{
color:white;
text-align:center;
padding:20px;
}

.sidebar a{
display:block;
padding:15px 25px;
color:white;
text-decoration:none;
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
box-shadow:0 5px 15px rgba(0,0,0,.15);
}

</style>

</head>

<body>

<div class="sidebar">

<h3>Admin Panel</h3>

<a href="dashboard.php">Dashboard</a>

<a href="students.php">Students</a>

<a href="candidates.php">Candidates</a>

<a href="results.php">Results</a>

<a href="reports.php">Reports</a>

<a href="settings.php">Settings</a>

<a href="logout.php">Logout</a>

</div>

<div class="main">

<h2>Election Reports</h2>

<hr>

<div class="row">

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?php echo $totalStudents; ?></h3>

<h5>Total Students</h5>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?php echo $totalCandidates; ?></h3>

<h5>Total Candidates</h5>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?php echo $totalVotes; ?></h3>

<h5>Total Votes</h5>

</div>

</div>

</div>

<br>

<div class="card p-4">

<h3>Generate Reports</h3>

<hr>

<div class="d-grid gap-3">

<a href="student_report.php" class="btn btn-primary">

Student Report

</a>

<a href="candidate_report.php" class="btn btn-success">

Candidate Report

</a>

<a href="vote_report.php" class="btn btn-warning">

Voting Report

</a>

<button onclick="window.print()"
class="btn btn-dark">

Print Report

</button>

</div>

</div>

</div>

</body>

</html>