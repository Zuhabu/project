<?php

session_start();


// ==========================================
// CHECK IF ADMIN IS ALREADY LOGGED IN
// ==========================================

if (isset($_SESSION['admin_id'])) {

    header("Location: dashboard.php");

    exit();

}


// ==========================================
// NOT LOGGED IN
// GO TO ADMIN LOGIN
// ==========================================

header("Location: login.php");

exit();

?>