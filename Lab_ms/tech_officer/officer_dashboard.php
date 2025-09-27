<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Officer Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

     <!-- Font Awesome CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">


    <style>
        body {
            background-color: #e6f7ff; /* Light blue shade */
        }

        /* Stylish font for the welcome message */
        .welcome-message {
            font-family: 'Roboto', sans-serif;
            font-size: 2em;
            /* Add any other styling properties here */
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


<body>

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

<div class="container mt-4">
    <h1 class="welcome-message">Welcome, <?php echo $_SESSION['name']; ?>!!</h1>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Items</div>
                <div class="card-body">
                    <a href="manage_items.php" class="btn btn-primary"><i class="fas fa-cube"></i> Manage Items</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Item Request Approve</div>
                <div class="card-body">
                    <a href="manage_requests.php" class="btn btn-primary"><i class="fas fa-check-circle"></i> Manage Requests</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Manage Students</div>
                <div class="card-body">
                    <a href="manage_students.php" class="btn btn-primary"><i class="fas fa-users"></i> Manage Students</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Return Item</div>
                <div class="card-body">
                    <a href="return_items.php" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Return Items</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>