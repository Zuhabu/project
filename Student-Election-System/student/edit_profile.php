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
// GET CURRENT STUDENT DATA
// ==========================================

$sql = "
    SELECT
        student_id,
        fullname,
        email,
        department,
        academic_year
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


if ($result->num_rows !== 1) {

    session_destroy();

    header("Location: login.php");
    exit();

}


$student = $result->fetch_assoc();

$stmt->close();


$studentID    = $student['student_id'];
$fullname     = $student['fullname'];
$email        = $student['email'];
$department   = $student['department'];
$academicYear = $student['academic_year'];


// ==========================================
// ERROR MESSAGE
// ==========================================

$errorMessage = "";

if (isset($_GET['error'])) {

    if ($_GET['error'] === 'empty') {

        $errorMessage = "Please fill in all required fields.";

    } elseif ($_GET['error'] === 'email') {

        $errorMessage = "Please enter a valid email address.";

    } elseif ($_GET['error'] === 'failed') {

        $errorMessage = "Unable to update your profile. Please try again.";

    }

}


$conn->close();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Profile - Student Election</title>


<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


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


/* SIDEBAR */

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

    transition: .3s;

}


.sidebar a:hover {

    background: #145b94;

}


.sidebar a.active {

    background: #145b94;

}


/* MAIN */

.main {

    margin-left: 250px;

    padding: 30px;

}


/* TOPBAR */

.topbar {

    background: white;

    padding: 20px 30px;

    border-radius: 10px;

    box-shadow: 0 5px 15px rgba(0,0,0,.1);

    margin-bottom: 30px;

}


/* FORM CARD */

.form-card {

    background: white;

    border-radius: 15px;

    box-shadow: 0 5px 15px rgba(0,0,0,.1);

    padding: 35px;

    max-width: 900px;

}


/* FORM */

.form-label {

    font-weight: 600;

}


.form-control,
.form-select {

    padding: 12px;

    border-radius: 8px;

}


.form-control:focus,
.form-select:focus {

    border-color: #0F4C81;

    box-shadow: 0 0 0 .2rem rgba(15,76,129,.15);

}


/* LOCKED FIELD */

.locked {

    background: #e9ecef;

}


/* BUTTON */

.save-btn {

    background: #0F4C81;

    color: white;

}


.save-btn:hover {

    background: #09375c;

    color: white;

}


/* MOBILE */

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

            Edit Profile ✏️

        </h2>

        <p class="mb-0">

            Update your personal information.

        </p>

    </div>


    <!-- ==========================================
         FORM CARD
    ========================================== -->

    <div class="form-card">


        <div class="d-flex align-items-center mb-4">

            <i class="fa-solid fa-user-pen fa-2x text-primary me-3"></i>

            <div>

                <h3 class="mb-1">

                    Personal Information

                </h3>

                <p class="text-muted mb-0">

                    Update your details below.

                </p>

            </div>

        </div>


        <hr>


        <!-- ERROR MESSAGE -->

        <?php if (!empty($errorMessage)) { ?>

            <div class="alert alert-danger">

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                <?php echo htmlspecialchars($errorMessage); ?>

            </div>

        <?php } ?>


        <!-- FORM -->

        <form action="update_profile.php"
              method="POST">


            <!-- STUDENT ID -->

            <div class="mb-4">

                <label class="form-label">

                    Student ID

                </label>

                <input
                    type="text"
                    class="form-control locked"
                    value="<?php echo htmlspecialchars($studentID); ?>"
                    readonly>

                <small class="text-muted">

                    Student ID cannot be changed.

                </small>

            </div>


            <!-- FULL NAME -->

            <div class="mb-4">

                <label for="fullname"
                       class="form-label">

                    Full Name
                    <span class="text-danger">*</span>

                </label>

                <input
                    type="text"
                    id="fullname"
                    name="fullname"
                    class="form-control"
                    value="<?php echo htmlspecialchars($fullname); ?>"
                    required
                    maxlength="100">

            </div>


            <!-- EMAIL -->

            <div class="mb-4">

                <label for="email"
                       class="form-label">

                    Email Address
                    <span class="text-danger">*</span>

                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="<?php echo htmlspecialchars($email); ?>"
                    required
                    maxlength="150">

            </div>


            <!-- DEPARTMENT -->

            <div class="mb-4">

                <label for="department"
                       class="form-label">

                    Department
                    <span class="text-danger">*</span>

                </label>

                <input
                    type="text"
                    id="department"
                    name="department"
                    class="form-control"
                    value="<?php echo htmlspecialchars($department); ?>"
                    required
                    maxlength="100">

            </div>


            <!-- ACADEMIC YEAR -->

            <div class="mb-4">

                <label for="academic_year"
                       class="form-label">

                    Academic Year
                    <span class="text-danger">*</span>

                </label>

                <select
                    id="academic_year"
                    name="academic_year"
                    class="form-select"
                    required>

                    <option value="1st Year"
                        <?php if ($academicYear === "1st Year") echo "selected"; ?>>

                        1st Year

                    </option>

                    <option value="2nd Year"
                        <?php if ($academicYear === "2nd Year") echo "selected"; ?>>

                        2nd Year

                    </option>

                    <option value="3rd Year"
                        <?php if ($academicYear === "3rd Year") echo "selected"; ?>>

                        3rd Year

                    </option>

                    <option value="4th Year"
                        <?php if ($academicYear === "4th Year") echo "selected"; ?>>

                        4th Year

                    </option>

                </select>

            </div>


            <!-- BUTTONS -->

            <div class="d-flex gap-2">

                <button
                    type="submit"
                    class="btn save-btn">

                    <i class="fa-solid fa-floppy-disk me-2"></i>

                    Save Changes

                </button>


                <a
                    href="profile.php"
                    class="btn btn-secondary">

                    <i class="fa-solid fa-xmark me-2"></i>

                    Cancel

                </a>

            </div>


        </form>


    </div>


</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>