
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$sql = "SELECT * FROM candidates
WHERE name LIKE '%$search%'
OR position LIKE '%$search%'
OR department LIKE '%$search%'
ORDER BY id DESC";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Candidates</title>

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
<a href="logout.php">Logout</a> 
 
</div> 
 
<div class="main"> 
 
<div class="card p-4"> 
 
<div class="d-flex justify-content-between"> 
 
<h2>Manage Candidates</h2> 
 
<div> 
 
<a href="add_candidate.php" 
class="btn btn-success"> 
 
Add Candidate 
 
</a> 
 
</div> 
 
</div> 
 
<hr> 
 
<form method="GET"> 
 
<input 
type="text" 
name="search" 
class="form-control mb-3" 
placeholder="Search Candidate"
value="<?php echo htmlspecialchars($search); ?>"> 
 
</form> 
 
<table class="table table-bordered table-hover"> 
 
<thead class="table-dark"> 
 
<tr> 
 
<th>Name</th> 
 
<th>Department</th> 
 
<th>Position</th> 
 
<th>Manifesto</th> 
 
<th>Action</th> 
 
</tr> 
 
</thead> 
 
<tbody> 
 
<?php 
 
while($row=mysqli_fetch_assoc($result)){ 
 
?> 
 
<tr> 
 
<td><?php echo $row['name']; ?></td> 
 
<td><?php echo $row['department']; ?></td> 
 
<td><?php echo $row['position']; ?></td> 
 
<td><?php echo $row['manifesto']; ?></td> 
 
<td> 
 
<a 
href="edit_candidate.php?id=<?php echo $row['id']; ?>" 
class="btn btn-primary btn-sm"> 
 
Edit 
 
</a> 
 
<a 
href="delete_candidate.php?id=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm" 
onclick="return confirm('Delete Candidate?')"> 
 
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

