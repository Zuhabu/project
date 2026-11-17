<?php

session_start();

include "../includes/db.php";

$result=mysqli_query($conn,"SELECT * FROM candidates");

?>

<!DOCTYPE html>

<html>

<head>

<title>Candidate Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Candidate Report</h2>

<table class="table table-bordered">

<tr>

<th>Name</th>
<th>Department</th>
<th>Position</th>
<th>Manifesto</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['name']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['position']; ?></td>
<td><?php echo $row['manifesto']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>