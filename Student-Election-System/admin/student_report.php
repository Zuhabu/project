<?php

session_start();
include "../includes/db.php";

$result=mysqli_query($conn,"SELECT * FROM students");

?>

<!DOCTYPE html>

<html>

<head>

<title>Student Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Student Report</h2>

<table class="table table-bordered">

<tr>

<th>ID</th>
<th>Student ID</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Verified</th>
<th>Voted</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['student_id']; ?></td>
<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['verified']; ?></td>
<td><?php echo $row['has_voted']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>