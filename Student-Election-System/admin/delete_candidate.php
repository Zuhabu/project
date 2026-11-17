<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "../includes/db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM candidates WHERE id=?");

$stmt->bind_param("i",$id);

$stmt->execute();

header("Location: candidates.php");

?>