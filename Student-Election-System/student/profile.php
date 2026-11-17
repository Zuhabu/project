<?php

session_start();

include "../includes/db.php";


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION['student_db_id'])) {

    header("Location: login.php");
    exit();

}


$student_db_id = $_SESSION['student_db_id'];


// ==========================================
// GET STUDENT INFORMATION
// ==========================================

$sql = "
    SELECT
        id,
        student_id,
        fullname,
        email,
        department,
        academic_year,
        verified,
        has_voted
    FROM students
    WHERE id = ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("Database Error: " . $conn->error);

}

$stmt->bind_param("i", $student_db_id);

$stmt->execute();

$result = $stmt->get_result();


// ==========================================
// CHECK STUDENT
// ==========================================

if ($result->num_rows !== 1) {

    session_destroy();

    header("Location: login.php");
    exit();

}


$student = $result->fetch_assoc();

$stmt->close();


// ==========================================
// STUDENT DATA
// ==========================================

$fullname     = $student['fullname'];
$studentID    = $student['student_id'];
$email        = $student['email'];
$department   = $student['department'];
$academicYear = $student['academic_year'];
$verified     = $student['verified'];
$hasVoted     = $student['has_voted'];


// ==========================================
// SUCCESS MESSAGE
// ==========================================

$successMessage = "";

if (isset($_GET['updated']) && $_GET['updated'] === '1') {

    $successMessage = "Your profile has been updated successfully.";

}


$conn->close();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>My Profile - Student Election</title>


<!-- Bootstrap -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<!-- Font Awesome -->

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>

* {

    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;

}


body {

    background: #f5f7fb;

}


/* ==========================================
   SIDEBAR
========================================== */

.sidebar {

    width: 250px;

    height: 100vh;

    position: fixed;

    left: 0;

    top: 0;

    background: #0F4C81;

    color: white;

    padding-top: 20px;

}


.sidebar h3 {

    text-align: center;

    margin-bottom: 40px;

    font-weight: bold;

}


.sidebar a {

    display: block;

    color: white;

    padding: 15px 25px;

    text-decoration: none;

    transition: 0.3s;

}


.sidebar a:hover {

    background: #145b94;

}


.sidebar a.active {

    background: #145b94;

}


/* ==========================================
   MAIN
========================================== */

.main {

    margin-left: 250px;

    padding: 30px;

}


/* ==========================================
   TOPBAR
========================================== */

.topbar {

    background: white;

    padding: 20px 30px;

    border-radius: 10px;

    box-shadow: 0 5px 15px rgba(0,0,0,.1);

    margin-bottom: 30px;

}


/* ==========================================
   PROFILE CARD
========================================== */

.profile-card {

    background: white;

    border-radius: 15px;

    box-shadow: 0 5px 15px rgba(0,0,0,.1);

    padding: 35px;

}


/* ==========================================
   PROFILE IMAGE
========================================== */

.profile-image {

    width: 150px;

    height: 150px;

    border-radius: 50%;

    object-fit: cover;

    border: 5px solid #0F4C81;

}


/* ==========================================
   PROFILE NAME
========================================== */

.profile-name {

    color: #0F4C81;

    font-size: 28px;

    font-weight: bold;

    margin-top: 15px;

}


/* ==========================================
   INFO BOX
========================================== */

.info-box {

    background: #f8f9fa;

    border-radius: 10px;

    padding: 18px;

    margin-bottom: 15px;

}


.info-label {

    color: #666;

    font-size: 14px;

    margin-bottom: 5px;

}


.info-value {

    font-size: 17px;

    font-weight: 600;

    color: #222;

}


/* ==========================================
   STATUS
========================================== */

.verified {

    color: #198754;

    font-weight: bold;

}


.not-verified {

    color: #dc3545;

    font-weight: bold;

}


.voted {

    color: #198754;

    font-weight: bold;

}


.not-voted {

    color: #fd7e14;

    font-weight: bold;

}


/* ==========================================
   MOBILE
========================================== */

@media (max-width: 768px) {

    .sidebar {

        width: 100%;

        height: auto;

        position: relative;

    }


    .sidebar h3 {

        margin-bottom: 10px;

    }


    .main {

        margin-left: 0;

        padding: 15px;

    }

}

</style>

</head>


<body>


<!-- ==========================================
     SIDEBAR
========================================== -->

<div class="sidebar">

    <h3>

        <i class="fa-solid fa-vote-yea"></i>

        FAC Election

    </h3>


    <a href="dashboard.php">

        <i class="fa-solid fa-house me-2"></i>

        Dashboard

    </a>


    <a href="candidates.php">

        <i class="fa-solid fa-users me-2"></i>

        Candidates

    </a>


    <a href="vote.php">

        <i class="fa-solid fa-check me-2"></i>

        Vote

    </a>


    <a href="results.php">

        <i class="fa-solid fa-chart-column me-2"></i>

        Results

    </a>


    <a href="profile.php" class="active">

        <i class="fa-solid fa-user me-2"></i>

        Profile

    </a>


    <a href="../logout.php"
       onclick="return confirm('Are you sure you want to logout?');">

        <i class="fa-solid fa-right-from-bracket me-2"></i>

        Logout

    </a>

</div>


<!-- ==========================================
     MAIN
========================================== -->

<div class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <h2>

            My Profile 👤

        </h2>

        <p class="mb-0">

            View and manage your personal information.

        </p>

    </div>


    <!-- SUCCESS MESSAGE -->

    <?php if (!empty($successMessage)) { ?>

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fa-solid fa-circle-check me-2"></i>

            <?php echo htmlspecialchars($successMessage); ?>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    <?php } ?>


    <!-- ==========================================
         PROFILE CARD
    ========================================== -->

    <div class="profile-card">


        <div class="row align-items-center">


            <!-- PROFILE PHOTO -->

            <div class="col-md-4 text-center">

                <img
                    src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                    class="profile-image"
                    alt="Student Profile">


                <div class="profile-name">

                    <?php echo htmlspecialchars($fullname); ?>

                </div>


                <p class="text-muted">

                    Student

                </p>


                <!-- EDIT BUTTON -->

                <a href="edit_profile.php"
                   class="btn btn-primary mt-2">

                    <i class="fa-solid fa-pen-to-square me-2"></i>

                    Edit Profile

                </a>

            </div>


            <!-- STUDENT INFORMATION -->

            <div class="col-md-8">


                <h4 class="mb-4">

                    <i class="fa-solid fa-id-card text-primary"></i>

                    Personal Information

                </h4>


                <!-- FULL NAME -->

                <div class="info-box">

                    <div class="info-label">

                        Full Name

                    </div>

                    <div class="info-value">

                        <i class="fa-solid fa-user me-2"></i>

                        <?php echo htmlspecialchars($fullname); ?>

                    </div>

                </div>


                <!-- STUDENT ID -->

                <div class="info-box">

                    <div class="info-label">

                        Student ID

                    </div>

                    <div class="info-value">

                        <i class="fa-solid fa-id-badge me-2"></i>

                        <?php echo htmlspecialchars($studentID); ?>

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="info-box">

                    <div class="info-label">

                        Email Address

                    </div>

                    <div class="info-value">

                        <i class="fa-solid fa-envelope me-2"></i>

                        <?php echo htmlspecialchars($email); ?>

                    </div>

                </div>


                <!-- DEPARTMENT -->

                <div class="info-box">

                    <div class="info-label">

                        Department

                    </div>

                    <div class="info-value">

                        <i class="fa-solid fa-building-columns me-2"></i>

                        <?php echo htmlspecialchars($department); ?>

                    </div>

                </div>


                <!-- ACADEMIC YEAR -->

                <div class="info-box">

                    <div class="info-label">

                        Academic Year

                    </div>

                    <div class="info-value">

                        <i class="fa-solid fa-graduation-cap me-2"></i>

                        <?php echo htmlspecialchars($academicYear); ?>

                    </div>

                </div>


            </div>

        </div>


        <hr class="my-4">


        <!-- ==========================================
             ACCOUNT STATUS
        ========================================== -->

        <h4 class="mb-4">

            <i class="fa-solid fa-shield-halved text-primary"></i>

            Account & Voting Status

        </h4>


        <div class="row g-4">


            <!-- VERIFICATION -->

            <div class="col-md-6">

                <div class="info-box">

                    <div class="info-label">

                        Account Verification

                    </div>


                    <?php if ($verified === 'Yes') { ?>

                        <div class="info-value verified">

                            <i class="fa-solid fa-circle-check me-2"></i>

                            Verified

                        </div>

                    <?php } else { ?>

                        <div class="info-value not-verified">

                            <i class="fa-solid fa-circle-xmark me-2"></i>

                            Not Verified

                        </div>

                    <?php } ?>

                </div>

            </div>


            <!-- VOTING STATUS -->

            <div class="col-md-6">

                <div class="info-box">

                    <div class="info-label">

                        Voting Status

                    </div>


                    <?php if ($hasVoted === 'Yes') { ?>

                        <div class="info-value voted">

                            <i class="fa-solid fa-circle-check me-2"></i>

                            Already Voted

                        </div>

                    <?php } else { ?>

                        <div class="info-value not-voted">

                            <i class="fa-solid fa-circle-exclamation me-2"></i>

                            Not Voted

                        </div>

                    <?php } ?>

                </div>

            </div>


        </div>


        <!-- BACK BUTTON -->

        <div class="mt-4">

            <a href="dashboard.php"
               class="btn btn-secondary">

                <i class="fa-solid fa-arrow-left me-2"></i>

                Back to Dashboard

            </a>

        </div>


    </div>


</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>