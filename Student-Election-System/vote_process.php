<?php

session_start();
include "includes/db.php";


if(!isset($_SESSION['student_db_id'])){

header("Location: login.php");

exit();

}

$student=$_SESSION['student_db_id'];

$candidate=$_POST['candidate_id'];

// Check Student Status

$sql="SELECT has_voted FROM students WHERE id=?";

$stmt=$conn->prepare($sql);

$stmt->bind_param("i",$student);

$stmt->execute();

$result=$stmt->get_result();

$data=$result->fetch_assoc();

if($data['has_voted']=="Yes"){

echo "<script>

alert('You have already voted.');

window.location='student/results.php';

</script>";

exit();

}

// Save Vote

$sql="INSERT INTO votes(student_id,candidate_id)

VALUES(?,?)";

$stmt=$conn->prepare($sql);

$stmt->bind_param("ii",$student,$candidate);

if($stmt->execute()){

$update="UPDATE students

SET has_voted='Yes'

WHERE id=?";

$stmt2=$conn->prepare($update);

$stmt2->bind_param("i",$student);

$stmt2->execute();

echo "<script>

alert('Vote Submitted Successfully.');

window.location='student/results.php';

</script>";

}else{

echo "<script>

alert('Vote Failed');

window.location='student/vote.php';

</script>";

}

?>