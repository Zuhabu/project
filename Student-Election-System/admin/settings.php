<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

// Save Settings
if(isset($_POST['save'])){

$title=$_POST['title'];

$university=$_POST['university'];

$start=$_POST['start'];

$end=$_POST['end'];

$status=$_POST['status'];

$stmt=$conn->prepare("UPDATE settings SET
election_title=?,
university_name=?,
start_date=?,
end_date=?,
status=?
WHERE id=1");

$stmt->bind_param(
"sssss",
$title,
$university,
$start,
$end,
$status
);

$stmt->execute();

echo "<script>
alert('Settings Updated Successfully');
window.location='settings.php';
</script>";

}

$result=mysqli_query($conn,"SELECT * FROM settings LIMIT 1");
$data=mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

<title>Settings</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>Election Settings</h3>

</div>

<div class="card-body">

<form method="POST">

<label>Election Title</label>

<input
type="text"
name="title"
class="form-control mb-3"
value="<?php echo $data['election_title']; ?>">

<label>University Name</label>

<input
type="text"
name="university"
class="form-control mb-3"
value="<?php echo $data['university_name']; ?>">

<label>Election Start Date</label>

<input
type="date"
name="start"
class="form-control mb-3"
value="<?php echo $data['start_date']; ?>">

<label>Election End Date</label>

<input
type="date"
name="end"
class="form-control mb-3"
value="<?php echo $data['end_date']; ?>">

<label>Status</label>

<select
name="status"
class="form-control mb-3">

<option value="Open"
<?php if($data['status']=="Open") echo "selected"; ?>>

Open

</option>

<option value="Closed"
<?php if($data['status']=="Closed") echo "selected"; ?>>

Closed

</option>

</select>

<button
name="save"
class="btn btn-primary">

Save Settings

</button>

</form>

</div>

</div>

</div>

</body>

</html>