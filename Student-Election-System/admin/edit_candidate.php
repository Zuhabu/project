<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

// Get Candidate ID
$id = $_GET['id'];

// Fetch Candidate Details
$stmt = $conn->prepare("SELECT * FROM candidates WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$candidate = $result->fetch_assoc();


// Update Candidate
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $manifesto = $_POST['manifesto'];

    $sql="UPDATE candidates
    SET
    name=?,
    department=?,
    position=?,
    manifesto=?
    WHERE id=?";

    $stmt=$conn->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $name,
        $department,
        $position,
        $manifesto,
        $id
    );

    if($stmt->execute()){

        echo "<script>

        alert('Candidate Updated Successfully');

        window.location='candidates.php';

        </script>";

    }else{

        echo "Update Failed.";

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Candidate</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>Edit Candidate</h3>

</div>

<div class="card-body">

<form method="POST">

<label>Name</label>

<input
type="text"
name="name"
class="form-control mb-3"
value="<?php echo htmlspecialchars($candidate['name']); ?>"
required>


<label>Department</label>

<input
type="text"
name="department"
class="form-control mb-3"
value="<?php echo htmlspecialchars($candidate['department']); ?>"
required>


<label>Position</label>

<input
type="text"
name="position"
class="form-control mb-3"
value="<?php echo htmlspecialchars($candidate['position']); ?>"
required>


<label>Manifesto</label>

<textarea
name="manifesto"
class="form-control mb-3"
required><?php echo htmlspecialchars($candidate['manifesto']); ?></textarea>


<button
name="update"
class="btn btn-primary">

Update Candidate

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