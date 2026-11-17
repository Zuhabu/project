<?php
session_start();

if(!isset($_SESSION['student_db_id'])){
    header("Location: ../login.php");
    exit();
}

include "../includes/db.php";

$result = $conn->query("SELECT * FROM candidates");
?>

<!DOCTYPE html>
<html>
<head>


<title>Vote</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card">

<div class="card-header bg-primary text-white">

<h3>Cast Your Vote</h3>

</div>

<div class="card-body">

<form action="../vote_process.php" method="POST">

<?php while($row=$result->fetch_assoc()){ ?>

<div class="form-check mb-3">

<input
class="form-check-input"
type="radio"
name="candidate_id"
value="<?php echo $row['id']; ?>"
required>

<label class="form-check-label">

<b><?php echo $row['name']; ?></b>

<br>

Position :
<?php echo $row['position']; ?>

<br>

Department :
<?php echo $row['department']; ?>

</label>

</div>

<hr>

<?php } ?>

<button class="btn btn-success">

Submit Vote

</button>

</form>

</div>

</div>

</div>

</body>

</html>