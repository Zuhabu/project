<?php

session_start();


// ==========================================
// CHECK IF STUDENT IS ALREADY LOGGED IN
// ==========================================

if (isset($_SESSION['student_db_id'])) {

    header("Location: dashboard.php");

    exit();

}


// ==========================================
// NOT LOGGED IN
// GO TO STUDENT LOGIN
// ==========================================

header("Location: login.php");

exit();

?>