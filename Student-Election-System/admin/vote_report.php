<?php

session_start();

include "../includes/db.php";

$sql="SELECT
students.fullname,
students.student_id,
candidates.name AS candidate,
candidates.position,
votes.vote_time

FROM votes

JOIN students
ON votes.student_id=students.id

JOIN candidates
ON votes.candidate_id=candidates.id

ORDER BY votes.vote_time DESC";

$result=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html>

<head>

<title>Voting Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Voting Report</h2>

<table class="table table-bordered">

<tr>

<th>Student</th>
<th>Student ID</th>
<th>Candidate</th>
<th>Position</th>
<th>Vote Time</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['student_id']; ?></td>
<td><?php echo $row['candidate']; ?></td>
<td><?php echo $row['position']; ?></td>
<td><?php echo $row['vote_time']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>