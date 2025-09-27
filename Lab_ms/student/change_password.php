<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "lab");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the current user's password from the database
$current_password = "";
$query = "SELECT password FROM Student WHERE email = '$_SESSION[email]'";
$query_run = mysqli_query($connection, $query);
if ($row = mysqli_fetch_assoc($query_run)) {
    $current_password = $row['password'];
}

// Check if the form is submitted
if (isset($_POST['update'])) {
    // Retrieve form data
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Validate the old password
    if ($current_password !== $old_password) {
        $_SESSION['error_message'] = "Incorrect old password.";
        header("Location: change_password.php");
        exit();
    }

    // Validate the new password and confirm password
    if ($new_password !== $confirm_new_password) {
        $_SESSION['error_message'] = "New password and confirm password do not match.";
        header("Location: change_password.php");
        exit();
    }

    // Update the password in the database
    $update_query = "UPDATE Student SET password = '$new_password' WHERE email = '$_SESSION[email]'";
    if (mysqli_query($connection, $update_query)) {
        // Password updated successfully
        $_SESSION['success_message'] = "Password updated successfully.";
    } else {
        // Failed to update password
        $_SESSION['error_message'] = "Failed to update password.";
        header("Location: change_password.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style type="text/css"> 
    body { 
        background: rgba(100, 245, 245, 0.4); 
       
    } 
    .navbar-brand img {
    height: 40px; /* Adjust image height */
    margin-right: 10px; /* Space between image and text */
}
.navbar {
    background: linear-gradient(90deg, #00440a, #2a5298); /* 90-degree gradient from blue to light blue */
    border-bottom: 2px solid rgba(255, 255, 255, 0.2); /* Semi-transparent white border */
    padding: 10px 10px; /* Padding for the navbar */
}

</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="index.php"><img src="laboratory_reservation_management_system.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="view_profile.php">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit_profile.php">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change_password.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<body>

    <div class="container">
        <h1>Change Password</h1>
        <?php
        // Display success or error message
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); // Clear the success message
        } elseif (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); // Clear the error message
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="password" class="form-control" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_new_password">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirm_new_password" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
