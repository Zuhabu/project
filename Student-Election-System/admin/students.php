<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

// Search Function
$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$sql = "SELECT * FROM students
WHERE fullname LIKE '%$search%'
OR student_id LIKE '%$search%'
OR email LIKE '%$search%'
ORDER BY id DESC";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Students</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
color:white;
padding:15px 25px;
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
box-shadow:0 5px 15px rgba(0,0,0,.1);
}

table{
font-size:14px;
}

</style>

</head>

<body>

<div class="sidebar">

<h3>Admin Panel</h3>

<a href="dashboard.php">
<i class="fa fa-home"></i> Dashboard
</a>

<a href="students.php">
<i class="fa fa-users"></i> Students
</a>

<a href="candidates.php">
<i class="fa fa-user-check"></i> Candidates
</a>

<a href="results.php">
<i class="fa fa-chart-column"></i> Results
</a>

<a href="reports.php">
<i class="fa fa-file"></i> Reports
</a>

<a href="logout.php">
<i class="fa fa-right-from-bracket"></i> Logout
</a>

</div>

<div class="main">

<div class="card p-4">

<div class="d-flex justify-content-between">

<h2>Registered Students</h2>

<form method="GET">

<input
type="text"
name="search"
placeholder="Search Student"
class="form-control">

</form>

</div>

<hr>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Student ID</th>

<th>Name</th>

<th>Email</th>

<th>Department</th>

<th>Year</th>

<th>Verified</th>

<th>Voted</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['student_id']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['department']; ?></td>

<td><?php echo $row['academic_year']; ?></td>

<td>

<?php

if($row['verified']=="Yes"){

echo "<span class='badge bg-success'>Verified</span>";

}else{

echo "<span class='badge bg-danger'>Pending</span>";

}

?>

</td>

<td>

<?php

if($row['has_voted']=="Yes"){

echo "<span class='badge bg-primary'>Voted</span>";

}else{

echo "<span class='badge bg-warning text-dark'>Not Yet</span>";

}

?>

</td>

<td>

<a
href="delete_student.php?id=<?php echo $row['id'];?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this student?')">

Delete

</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</body>

</html>