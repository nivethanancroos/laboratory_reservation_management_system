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
$query = "SELECT * FROM Student WHERE email = '$_SESSION[email]'";
$query_run = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($query_run);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
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
        <h1>View Profile</h1>
        <p>Welcome <?php echo $_SESSION['name']; ?></p>
        <p>Email: <?php echo $_SESSION['email']; ?></p>
        <div class="row">
            <div class="col-md-6">
                <h3>Profile Information</h3>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td><?php echo $row['name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                    <!-- Add more fields as needed -->
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
