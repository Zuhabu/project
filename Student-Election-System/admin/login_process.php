<?php

session_start();

include "../includes/db.php";

$username = trim($_POST['username']);
$password = $_POST['password'];

$sql = "SELECT * FROM admins WHERE username=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 1){

    $admin = $result->fetch_assoc();

    if(password_verify($password, $admin['password'])){

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];

        header("Location: dashboard.php");
        exit();

    } else {

        echo "<script>
        alert('Incorrect Password');
        window.location='login.php';
        </script>";

    }

} else {

    echo "<script>
    alert('Username Not Found');
    window.location='login.php';
    </script>";

}
?>