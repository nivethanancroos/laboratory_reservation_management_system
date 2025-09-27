<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch user data from the database
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lab");
$query = "SELECT * FROM Technical_Officer WHERE email = '$_SESSION[email]'";
$query_run = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($query_run);

// Update profile information if form is submitted
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Add more fields as needed

    $update_query = "UPDATE Technical_Officer SET name='$name', email='$email' WHERE email='$_SESSION[email]'";
    $update_query_run = mysqli_query($connection, $update_query);

    if($update_query_run){
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['success_message'] = "Profile updated successfully."; // Set the success message
        header("Location: ".$_SERVER['PHP_SELF']); // Redirect to the same page to refresh
        exit();
    } else {
        // Add error message
    }
}

// Check if success message is set
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); // Clear the success message
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #e6f7ff; /* Light blue shade */
        }

        /* Style for underline under h1 */
        h1 {
            border-bottom: 2px solid black;
            display: inline-block; /* Ensures the border does not span the full width */
            padding-bottom: 5px; /* Optional: Adjust padding as needed */
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

</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="index.php"><img src="laboratory_reservation_management_system.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="view_profile.php"><i class="fas fa-user"></i> My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_profile.php"><i class="fas fa-edit"></i> Edit Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="change_password.php"><i class="fas fa-key"></i> Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<body>
<div class="container">
    <h1><i class="fas fa-user-edit"></i> Edit Profile</h1>
    <br>
    <br>
    <?php
    // Display success message if set
    if (!empty($success_message)) {
        echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <form action="" method="post">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" required>
                </div>
                <!-- Add more fields as needed -->
                <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
