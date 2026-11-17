<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

if(isset($_POST['save'])){

    $name = $_POST['name'];

    $department = $_POST['department'];

    $position = $_POST['position'];

    $manifesto = $_POST['manifesto'];

    $sql = "INSERT INTO candidates
    (name, department, position, manifesto)

    VALUES(?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssss",
        $name,
        $department,
        $position,
        $manifesto
    );

    $stmt->execute();

    header("Location: candidates.php");

    exit();

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Add Candidate</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white">

<h3>Add Candidate</h3>

</div>

<div class="card-body">

<form method="POST">

<input
type="text"
name="name"
class="form-control mb-3"
placeholder="Candidate Name"
required>

<input
type="text"
name="department"
class="form-control mb-3"
placeholder="Department"
required>

<input
type="text"
name="position"
class="form-control mb-3"
placeholder="Position"
required>

<textarea
name="manifesto"
class="form-control mb-3"
placeholder="Manifesto"
required></textarea>

<button
name="save"
class="btn btn-success">

Save Candidate

</button>

<a
href="candidates.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</body>

</html>