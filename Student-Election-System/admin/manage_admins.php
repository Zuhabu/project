<?php

session_start();

include "../includes/db.php";

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$current_admin_id = $_SESSION['admin_id'];

$message = "";
$message_type = "";


/* =========================================================
   ADD ADMIN
========================================================= */

if (isset($_POST['add_admin'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        $message = "Username and password are required.";
        $message_type = "danger";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";
        $message_type = "danger";

    } else {

        // Check whether username already exists
        $check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Username already exists.";
            $message_type = "danger";

        } else {

            // Hash password automatically
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO admins (username, password) VALUES (?, ?)"
            );

            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {

                $message = "Admin added successfully.";
                $message_type = "success";

            } else {

                $message = "Failed to add admin.";
                $message_type = "danger";
            }

            $stmt->close();
        }

        $check->close();
    }
}


/* =========================================================
   DELETE ADMIN
========================================================= */

if (isset($_POST['delete_admin'])) {

    $delete_id = intval($_POST['delete_id']);

    // Prevent deleting yourself
    if ($delete_id == $current_admin_id) {

        $message = "You cannot delete your own admin account.";
        $message_type = "danger";

    } else {

        $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {

                $message = "Admin deleted successfully.";
                $message_type = "success";

            } else {

                $message = "Admin not found.";
                $message_type = "danger";
            }

        } else {

            $message = "Failed to delete admin.";
            $message_type = "danger";
        }

        $stmt->close();
    }
}


/* =========================================================
   EDIT ADMIN
========================================================= */

if (isset($_POST['edit_admin'])) {

    $edit_id = intval($_POST['edit_id']);
    $username = trim($_POST['edit_username']);
    $password = $_POST['edit_password'];

    if (empty($username)) {

        $message = "Username cannot be empty.";
        $message_type = "danger";

    } else {

        // Check username used by another admin
        $check = $conn->prepare(
            "SELECT id FROM admins WHERE username = ? AND id != ?"
        );

        $check->bind_param("si", $username, $edit_id);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "That username is already being used.";
            $message_type = "danger";

        } else {

            // If password is entered, update username + password
            if (!empty($password)) {

                if (strlen($password) < 6) {

                    $message = "Password must be at least 6 characters.";
                    $message_type = "danger";

                } else {

                    $hashed_password = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    $stmt = $conn->prepare(
                        "UPDATE admins
                         SET username = ?, password = ?
                         WHERE id = ?"
                    );

                    $stmt->bind_param(
                        "ssi",
                        $username,
                        $hashed_password,
                        $edit_id
                    );

                    if ($stmt->execute()) {

                        $message = "Admin updated successfully.";
                        $message_type = "success";

                    } else {

                        $message = "Failed to update admin.";
                        $message_type = "danger";
                    }

                    $stmt->close();
                }

            } else {

                // Update username only
                $stmt = $conn->prepare(
                    "UPDATE admins
                     SET username = ?
                     WHERE id = ?"
                );

                $stmt->bind_param("si", $username, $edit_id);

                if ($stmt->execute()) {

                    $message = "Admin updated successfully.";
                    $message_type = "success";

                } else {

                    $message = "Failed to update admin.";
                    $message_type = "danger";
                }

                $stmt->close();
            }
        }

        $check->close();
    }
}


/* =========================================================
   GET ALL ADMINS
========================================================= */

$result = $conn->query(
    "SELECT id, username FROM admins ORDER BY id ASC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Manage Administrators</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body {
    background: #f4f7fb;
    font-family: Arial, Helvetica, sans-serif;
}

.header {
    background: linear-gradient(135deg, #0F4C81, #1B6CA8);
    color: white;
    padding: 25px;
    margin-bottom: 30px;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,.08);
}

.card-header {
    background: #0F4C81;
    color: white;
    border-radius: 15px 15px 0 0 !important;
}

.btn-primary {
    background: #0F4C81;
    border-color: #0F4C81;
}

.btn-primary:hover {
    background: #09375c;
    border-color: #09375c;
}

.admin-icon {
    width: 45px;
    height: 45px;
    background: #e8f1f8;
    color: #0F4C81;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

</style>

</head>

<body>


<!-- HEADER -->

<div class="header">

<div class="container">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="mb-1">
<i class="fa-solid fa-user-shield"></i>
Manage Administrators
</h2>

<p class="mb-0">
Student Election Management System
</p>

</div>

<a href="dashboard.php"
   class="btn btn-light">

<i class="fa-solid fa-arrow-left"></i>
Dashboard

</a>

</div>

</div>

</div>


<div class="container">


<!-- MESSAGE -->

<?php if (!empty($message)): ?>

<div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">

<?php echo htmlspecialchars($message); ?>

<button type="button"
        class="btn-close"
        data-bs-dismiss="alert">
</button>

</div>

<?php endif; ?>


<div class="row g-4">


<!-- =====================================================
     ADD ADMIN
====================================================== -->

<div class="col-lg-4">

<div class="card">

<div class="card-header py-3">

<h5 class="mb-0">

<i class="fa-solid fa-user-plus"></i>

Add New Administrator

</h5>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label class="form-label">
Username
</label>

<input
type="text"
name="username"
class="form-control"
placeholder="Enter username"
required>

</div>


<div class="mb-3">

<label class="form-label">
Password
</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter password"
minlength="6"
required>

<div class="form-text">
Minimum 6 characters.
</div>

</div>


<button
type="submit"
name="add_admin"
class="btn btn-primary w-100">

<i class="fa-solid fa-plus"></i>

Add Administrator

</button>

</form>

</div>

</div>

</div>


<!-- =====================================================
     ADMIN LIST
====================================================== -->

<div class="col-lg-8">

<div class="card">

<div class="card-header py-3">

<h5 class="mb-0">

<i class="fa-solid fa-users"></i>

Administrator Accounts

</h5>

</div>

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>

<th>#</th>

<th>Administrator</th>

<th>Username</th>

<th class="text-center">
Actions
</th>

</tr>

</thead>

<tbody>

<?php if ($result->num_rows > 0): ?>

<?php while ($admin = $result->fetch_assoc()): ?>

<tr>

<td>

<?php echo $admin['id']; ?>

</td>


<td>

<div class="d-flex align-items-center gap-3">

<div class="admin-icon">

<i class="fa-solid fa-user-shield"></i>

</div>

<div>

<strong>
<?php
echo htmlspecialchars($admin['username']);
?>
</strong>

<?php if ($admin['id'] == $current_admin_id): ?>

<br>

<small class="text-success">
<i class="fa-solid fa-circle-check"></i>
Current Account
</small>

<?php endif; ?>

</div>

</div>

</td>


<td>

<?php
echo htmlspecialchars($admin['username']);
?>

</td>


<td class="text-center">


<!-- EDIT BUTTON -->

<button
type="button"
class="btn btn-sm btn-warning"
data-bs-toggle="modal"
data-bs-target="#editModal"

data-id="<?php echo $admin['id']; ?>"

data-username="<?php
echo htmlspecialchars($admin['username'], ENT_QUOTES);
?>">

<i class="fa-solid fa-pen"></i>

</button>


<!-- DELETE BUTTON -->

<?php if ($admin['id'] != $current_admin_id): ?>

<button
type="button"
class="btn btn-sm btn-danger"
data-bs-toggle="modal"
data-bs-target="#deleteModal"

data-id="<?php echo $admin['id']; ?>"

data-username="<?php
echo htmlspecialchars($admin['username'], ENT_QUOTES);
?>">

<i class="fa-solid fa-trash"></i>

</button>

<?php endif; ?>


</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>

<td colspan="4"
    class="text-center py-4">

No administrators found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>


<!-- =====================================================
     EDIT MODAL
====================================================== -->

<div class="modal fade"
     id="editModal"
     tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<form method="POST">

<div class="modal-header">

<h5 class="modal-title">

<i class="fa-solid fa-user-pen"></i>

Edit Administrator

</h5>

<button type="button"
        class="btn-close"
        data-bs-dismiss="modal">
</button>

</div>


<div class="modal-body">

<input
type="hidden"
name="edit_id"
id="edit_id">


<div class="mb-3">

<label class="form-label">
Username
</label>

<input
type="text"
name="edit_username"
id="edit_username"
class="form-control"
required>

</div>


<div class="mb-3">

<label class="form-label">

New Password

<small class="text-muted">
(Optional)
</small>

</label>

<input
type="password"
name="edit_password"
id="edit_password"
class="form-control"
minlength="6"
placeholder="Leave empty to keep current password">

</div>

<div class="alert alert-info">

<i class="fa-solid fa-circle-info"></i>

Leave the password empty if you only want to change the username.

</div>

</div>


<div class="modal-footer">

<button type="button"
        class="btn btn-secondary"
        data-bs-dismiss="modal">

Cancel

</button>

<button
type="submit"
name="edit_admin"
class="btn btn-primary">

<i class="fa-solid fa-save"></i>

Save Changes

</button>

</div>

</form>

</div>

</div>

</div>


<!-- =====================================================
     DELETE MODAL
====================================================== -->

<div class="modal fade"
     id="deleteModal"
     tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content">

<form method="POST">

<div class="modal-header bg-danger text-white">

<h5 class="modal-title">

<i class="fa-solid fa-triangle-exclamation"></i>

Delete Administrator

</h5>

<button type="button"
        class="btn-close btn-close-white"
        data-bs-dismiss="modal">
</button>

</div>


<div class="modal-body">

<input
type="hidden"
name="delete_id"
id="delete_id">

<p>
Are you sure you want to delete:
</p>

<h5 id="delete_username"></h5>

<p class="text-danger">

This action cannot be undone.

</p>

</div>


<div class="modal-footer">

<button
type="button"
class="btn btn-secondary"
data-bs-dismiss="modal">

Cancel

</button>

<button
type="submit"
name="delete_admin"
class="btn btn-danger">

<i class="fa-solid fa-trash"></i>

Delete

</button>

</div>

</form>

</div>

</div>

</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<script>

/* EDIT MODAL */

const editModal = document.getElementById('editModal');

editModal.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');

    const username = button.getAttribute('data-username');

    document.getElementById('edit_id').value = id;

    document.getElementById('edit_username').value = username;

    document.getElementById('edit_password').value = '';

});


/* DELETE MODAL */

const deleteModal = document.getElementById('deleteModal');

deleteModal.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');

    const username = button.getAttribute('data-username');

    document.getElementById('delete_id').value = id;

    document.getElementById('delete_username').textContent = username;

});

</script>


</body>

</html>