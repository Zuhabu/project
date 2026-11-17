<?php
include "../includes/db.php";




session_start();

if(!isset($_SESSION['student_db_id'])){

    header("Location: ../login.php");

    exit();

}

?>
<!DOCTYPE html>
<html lang="en">



<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Election Candidates</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
    

body{
    background:#f4f6f9;
    font-family:Arial, Helvetica, sans-serif;
}

.sidebar{
    width:250px;
    height:100vh;
    background:#0F4C81;
    position:fixed;
    color:white;
}

.sidebar h3{
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
    overflow:hidden;
    transition:.3s;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    height:250px;
    object-fit:cover;
}

.badge-position{
    background:#0F4C81;
}

</style>

</head>

<body>

<div class="sidebar">

<h3>FAC Election</h3>

<a href="dashboard.php">
<i class="fa-solid fa-house"></i>
Dashboard
</a>

<a href="candidates.php">
<i class="fa-solid fa-users"></i>
Candidates
</a>

<a href="vote.php">
<i class="fa-solid fa-check"></i>
Vote
</a>

<a href="results.php">
<i class="fa-solid fa-chart-column"></i>
Results
</a>

<a href="profile.php">
<i class="fa-solid fa-user"></i>
Profile
</a>

<a href="../logout.php"
onclick="return confirm('Are you sure you want to logout?');">
<i class="fa-solid fa-right-from-bracket"></i>
Logout
</a>
<i class="fa-solid fa-right-from-bracket"></i>
Logout
</a>

</div>

<div class="main">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Election Candidates</h2>

<input
type="text"
class="form-control w-25"
placeholder="Search Candidate">

</div>

<div class="row">

<!-- Candidate 1 -->

<div class="col-lg-4 mb-4">

<div class="card">

<img src="../assets/image/candidate1.png" alt="Ahmed Niyas">

<div class="card-body">

<h4>Ahmed Niyas</h4>

<span class="badge badge-position">
President
</span>

<hr>

<p><b>Department:</b> Information Technology</p>

<p>

To improve student welfare, organize academic and cultural programs, and create a transparent student union.

</p>

<div class="d-grid">

<a href="vote.php" class="btn btn-success">

<i class="fa-solid fa-check"></i>

Vote

</a>

</div>

</div>

</div>

</div>

<!-- Candidate 2 -->

<div class="col-lg-4 mb-4">

<div class="card">

<img src="../assets/image/candidate2.jpg">

<div class="card-body">

<h4>Fathima Mariyam</h4>

<span class="badge bg-warning">

Vice President

</span>

<hr>

<p><b>Department:</b> Information Technology</p>

<p>

Promoting student unity, leadership, innovation and extracurricular activities.

</p>

<div class="d-grid">

<a href="vote.php"

class="btn btn-success">

Vote

</a>

</div>

</div>

</div>

</div>

<!-- Candidate 3 -->

<div class="col-lg-4 mb-4">

<div class="card">

<img src="../assets/image/candidate3.jpeg">

<div class="card-body">

<h4>Mohamed Ameen</h4>

<span class="badge bg-danger">

Secretary

</span>

<hr>

<p><b>Department:</b> Tamil</p>

<p>

Building a digital communication platform between students and the faculty.

</p>

<div class="d-grid">

<a href="vote.php"

class="btn btn-success">

Vote

</a>

</div>

</div>

</div>

</div>

<!-- Candidate 4 -->

<div class="col-lg-4 mb-4">

<div class="card">

<img src="../assets/image/candidate4.png">

<div class="card-body">

<h4>Nazeera</h4>

<span class="badge bg-primary">

Treasurer

</span>

<hr>

<p><b>Department:</b> sociology </p>

<p>

Ensure transparent financial management and support student events.

</p>

<div class="d-grid">

<a href="vote.php"

class="btn btn-success">

Vote

</a>

</div>

</div>

</div>

</div>

<!-- Candidate 5 -->

<div class="col-lg-4 mb-4">

<div class="card">

<img src="../assets/image/candidate5.png">

<div class="card-body">

<h4>Rizwan</h4>

<span class="badge bg-success">

Sports Captain

</span>

<hr>

<p><b>Department:</b> History</p>

<p>

Improve sports facilities and organize annual sports competitions.

</p>

<div class="d-grid">

<a href="vote.php"

class="btn btn-success">

Vote

</a>

</div>

</div>

</div>

</div>

<!-- Candidate 6 -->

<div class="col-lg-4 mb-4">

<div class="card">

<img src="../assets/image/candidate6.png">

<div class="card-body">

<h4>Ayesha</h4>

<span class="badge bg-info">

Cultural Secretary

</span>

<hr>

<p><b>Department:</b>Geography</p>

<p>

Organize cultural festivals and improve student engagement.

</p>

<div class="d-grid">

<a href="vote.php"

class="btn btn-success">

Vote

</a>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>