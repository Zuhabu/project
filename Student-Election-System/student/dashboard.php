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


$student_db_id = $_SESSION['student_db_id'];


// ==========================================
// GET STUDENT INFORMATION
// ==========================================

$sql = "
    SELECT
        id,
        student_id,
        fullname,
        email,
        department,
        academic_year,
        verified,
        has_voted
    FROM students
    WHERE id = ?
";


$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("Database Error: " . $conn->error);

}

$stmt->bind_param("i", $student_db_id);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows !== 1) {

    session_destroy();

    header("Location: login.php");

    exit();

}


$student = $result->fetch_assoc();

$stmt->close();


// ==========================================
// STUDENT DATA
// ==========================================

$fullname = $student['fullname'];

$studentID = $student['student_id'];

$email = $student['email'];

$department = $student['department'];

$academicYear = $student['academic_year'];

$verified = $student['verified'];

$hasVoted = $student['has_voted'];


// ==========================================
// VERIFICATION STATUS
// ==========================================

if ($verified === 'Yes') {

    $verificationStatus = "Verified";

} else {

    $verificationStatus = "Not Verified";

}


// ==========================================
// VOTING STATUS
// ==========================================

if ($hasVoted === 'Yes') {

    $votingStatus = "Already Voted";

} else {

    $votingStatus = "Not Voted";

}


// ==========================================
// TOTAL STUDENTS
// ==========================================

$sql = "SELECT COUNT(*) AS total_students FROM students";

$result = $conn->query($sql);

$totalStudents = 0;

if ($result) {

    $row = $result->fetch_assoc();

    $totalStudents = $row['total_students'];

}


// ==========================================
// TOTAL CANDIDATES
// ==========================================

$sql = "SELECT COUNT(*) AS total_candidates FROM candidates";

$result = $conn->query($sql);

$totalCandidates = 0;

if ($result) {

    $row = $result->fetch_assoc();

    $totalCandidates = $row['total_candidates'];

}


// ==========================================
// ELECTION SETTINGS
// ==========================================

$electionTitle = "Student Union Election 2026";

$electionStatus = "Open";

$startDate = "";

$endDate = "";


// Check settings table

$sql = "
    SELECT
        election_title,
        start_date,
        end_date,
        status
    FROM settings
    LIMIT 1
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    $settings = $result->fetch_assoc();

    $electionTitle = $settings['election_title'];

    $startDate = $settings['start_date'];

    $endDate = $settings['end_date'];

    $electionStatus = $settings['status'];

}


$conn->close();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Student Dashboard</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{

    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;

}

body{

    background:#f5f7fb;

}


/* SIDEBAR */

.sidebar{

    width:250px;

    height:100vh;

    position:fixed;

    background:#0F4C81;

    color:white;

    padding-top:20px;

}

.sidebar h3{

    text-align:center;

    margin-bottom:40px;

    font-weight:bold;

}

.sidebar a{

    display:block;

    color:white;

    padding:15px 25px;

    text-decoration:none;

    transition:.3s;

}

.sidebar a:hover{

    background:#145b94;

}


/* MAIN */

.main{

    margin-left:250px;

    padding:30px;

}


/* TOPBAR */

.topbar{

    background:white;

    padding:20px 30px;

    border-radius:10px;

    box-shadow:0 5px 15px rgba(0,0,0,.1);

    margin-bottom:30px;

}


/* CARDS */

.card-box{

    border:none;

    border-radius:15px;

    box-shadow:0 5px 15px rgba(0,0,0,.1);

    transition:.3s;

}

.card-box:hover{

    transform:translateY(-5px);

}


/* ICON */

.icon{

    font-size:40px;

    color:#0F4C81;

}


/* STATUS */

.status{

    font-size:18px;

    font-weight:bold;

    color:green;

}

.status-not{

    font-size:18px;

    font-weight:bold;

    color:red;

}


/* VOTE BUTTON */

.vote-btn{

    background:#0F4C81;

    color:white;

}

.vote-btn:hover{

    background:#09375c;

    color:white;

}

</style>

</head>

<body>


<!-- ========================================== -->
<!-- SIDEBAR -->
<!-- ========================================== -->

<div class="sidebar">

<h3>

<i class="fa-solid fa-vote-yea"></i>

FAC Election

</h3>


<a href="dashboard.php">

<i class="fa-solid fa-house me-2"></i>

Dashboard

</a>


<a href="candidates.php">

<i class="fa-solid fa-users me-2"></i>

Candidates

</a>


<a href="vote.php">

<i class="fa-solid fa-check me-2"></i>

Vote

</a>


<a href="results.php">

<i class="fa-solid fa-chart-column me-2"></i>

Results

</a>


<a href="profile.php">

<i class="fa-solid fa-user me-2"></i>

Profile

</a>

<a href="../logout.php"
   onclick="return confirm('Are you sure you want to logout?');">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
</a>


</div>


<!-- ========================================== -->
<!-- MAIN -->
<!-- ========================================== -->

<div class="main">


<!-- TOPBAR -->

<div class="topbar">

<h2>

Welcome, <?php echo htmlspecialchars($fullname); ?> 👋

</h2>

<p class="mb-0">

Faculty of Arts and Culture Student Union Election

</p>

</div>


<!-- ========================================== -->
<!-- STATISTICS -->
<!-- ========================================== -->

<div class="row g-4">


<!-- TOTAL STUDENTS -->

<div class="col-md-3">

<div class="card card-box p-4 text-center">

<i class="fa-solid fa-user icon"></i>

<h3 class="mt-3">

<?php echo $totalStudents; ?>

</h3>

<p class="mb-0">

Total Students

</p>

</div>

</div>


<!-- CANDIDATES -->

<div class="col-md-3">

<div class="card card-box p-4 text-center">

<i class="fa-solid fa-users icon"></i>

<h3 class="mt-3">

<?php echo $totalCandidates; ?>

</h3>

<p class="mb-0">

Candidates

</p>

</div>

</div>


<!-- ELECTION STATUS -->

<div class="col-md-3">

<div class="card card-box p-4 text-center">

<i class="fa-solid fa-check icon"></i>

<h3 class="mt-3">

<?php echo htmlspecialchars($electionStatus); ?>

</h3>

<p class="mb-0">

Election Status

</p>

</div>

</div>


<!-- SECURITY -->

<div class="col-md-3">

<div class="card card-box p-4 text-center">

<i class="fa-solid fa-lock icon"></i>

<h3 class="mt-3">

Secure

</h3>

<p class="mb-0">

Voting System

</p>

</div>

</div>


</div>


<br>


<!-- ========================================== -->
<!-- ELECTION INFORMATION + PROFILE -->
<!-- ========================================== -->

<div class="row g-4">


<!-- ELECTION INFORMATION -->

<div class="col-md-8">

<div class="card card-box p-4">

<h3>

Election Information

</h3>

<hr>


<p>

<b>Election Name:</b>

<?php echo htmlspecialchars($electionTitle); ?>

</p>


<p>

<b>Voting Status:</b>

<span class="status">

<?php echo htmlspecialchars($electionStatus); ?>

</span>

</p>


<?php if (!empty($startDate)) { ?>

<p>

<b>Start Date:</b>

<?php echo htmlspecialchars($startDate); ?>

</p>

<?php } ?>


<?php if (!empty($endDate)) { ?>

<p>

<b>End Date:</b>

<?php echo htmlspecialchars($endDate); ?>

</p>

<?php } ?>


<p>

<b>Important Notice:</b>

Each student can vote only once.

</p>


<a href="candidates.php"
class="btn vote-btn">

View Candidates

</a>


<?php if ($hasVoted === 'No') { ?>

<a href="vote.php"
class="btn btn-success">

Vote Now

</a>

<?php } else { ?>

<button class="btn btn-secondary" disabled>

Already Voted

</button>

<?php } ?>


</div>

</div>


<!-- ========================================== -->
<!-- STUDENT PROFILE -->
<!-- ========================================== -->

<div class="col-md-4">

<div class="card card-box p-4">

<h4>

Student Profile

</h4>

<hr>


<div class="text-center">

<img
src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
width="120"
alt="Student Profile">

</div>


<br>


<p>

<b>Name:</b><br>

<?php echo htmlspecialchars($fullname); ?>

</p>


<p>

<b>Student ID:</b><br>

<?php echo htmlspecialchars($studentID); ?>

</p>


<p>

<b>Department:</b><br>

<?php echo htmlspecialchars($department); ?>

</p>


<p>

<b>Academic Year:</b><br>

<?php echo htmlspecialchars($academicYear); ?>

</p>


<p>

<b>Status:</b>

<?php if ($verified === 'Yes') { ?>

<span class="status">

Verified

</span>

<?php } else { ?>

<span class="status-not">

Not Verified

</span>

<?php } ?>

</p>


<p>

<b>Voting:</b>

<?php if ($hasVoted === 'Yes') { ?>

<span class="text-success fw-bold">

Already Voted

</span>

<?php } else { ?>

<span class="text-warning fw-bold">

Not Voted

</span>

<?php } ?>

</p>


</div>

</div>


</div>


<br>


<!-- ========================================== -->
<!-- QUICK ACTIONS -->
<!-- ========================================== -->

<div class="card card-box p-4">

<h3>

Quick Actions

</h3>

<hr>


<div class="row g-3 text-center">


<div class="col-md-3">

<a href="candidates.php"
class="btn btn-primary w-100">

Candidates

</a>

</div>


<div class="col-md-3">

<a href="vote.php"
class="btn btn-success w-100">

Vote

</a>

</div>


<div class="col-md-3">

<a href="results.php"
class="btn btn-warning w-100">

Results

</a>

</div>


<div class="col-md-3">

<a href="profile.php"
class="btn btn-secondary w-100">

Profile

</a>

</div>


</div>

</div>


</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>