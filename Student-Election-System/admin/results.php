<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

// Get Results
$sql = "SELECT
c.id,
c.name,
c.position,
COUNT(v.candidate_id) AS total_votes
FROM candidates c
LEFT JOIN votes v
ON c.id=v.candidate_id
GROUP BY c.id
ORDER BY total_votes DESC";

$result = mysqli_query($conn,$sql);

$labels = [];
$data = [];

while($row=mysqli_fetch_assoc($result)){

    $labels[] = $row['name'];
    $data[] = $row['total_votes'];

}

mysqli_data_seek($result,0);

$totalVotes = array_sum($data);
?>

<!DOCTYPE html>

<html>

<head>

<title>Election Results</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

<a href="logout.php">Logout</a>

</div>

<div class="main">

<h2>Live Election Results</h2>

<hr>

<div class="row">

<div class="col-md-7">

<div class="card p-4">

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>Rank</th>

<th>Candidate</th>

<th>Position</th>

<th>Votes</th>

<th>Percentage</th>

</tr>

</thead>

<tbody>

<?php

$rank=1;

while($row=mysqli_fetch_assoc($result)){

$percentage = ($totalVotes>0)
? round(($row['total_votes']/$totalVotes)*100,2)
:0;

?>

<tr>

<td><?php echo $rank++; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['position']; ?></td>

<td><?php echo $row['total_votes']; ?></td>

<td><?php echo $percentage; ?>%</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<div class="col-md-5">

<div class="card p-4">

<h4>Total Votes</h4>

<h1><?php echo $totalVotes; ?></h1>

<hr>

<canvas id="voteChart"></canvas>

</div>

</div>

</div>

</div>

<script>

const ctx=document.getElementById('voteChart');

new Chart(ctx,{

type:'bar',

data:{

labels:<?php echo json_encode($labels); ?>,

datasets:[{

label:'Votes',

data:<?php echo json_encode($data); ?>

}]

}

});

</script>

</body>

</html>