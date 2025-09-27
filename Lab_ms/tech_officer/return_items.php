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

// Fetch issued items that are yet to be returned
$query = "SELECT * FROM issued WHERE return_date IS NULL";
$result = mysqli_query($connection, $query);

// Check if the return button is clicked
if (isset($_POST['return'])) {
    // Retrieve the issue id
    $issue_id = $_POST['issue_id'];

    // Update the return date to current timestamp
    $update_query = "UPDATE issued SET return_date = CURRENT_TIMESTAMP WHERE issue_id = $issue_id";
    if (mysqli_query($connection, $update_query)) {
        // Set success message for return
       // $_SESSION['success_message'] = "Item returned successfully";
    } else {
        // Display error message if update fails
        $_SESSION['error_message'] = "Error returning item: " . mysqli_error($connection);
    }

    // Redirect to refresh the page
    header("Location: return_items.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #e6f7ff; /* Light blue shade */
        }

        .bg-light-gray {
            background-color: #f2f2f2; /* Light gray */
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
        <h1>Return Items</h1>
        <div class="row mt-4">
            <div class="col-md-12">
                <h2>Unreturned Items..</h2>
                <table class="table">
                    <thead>
                        <tr class="bg-light-gray">
                            <th class="bg-light-gray">Issue ID</th>
                            <th class="bg-light-gray">Issue Date</th>
                            <th class="bg-light-gray">Due Date</th>
                            <th class="bg-light-gray">Return Date</th>
                            <th class="bg-light-gray">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display issued items
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['issue_id'] . "</td>";
                            echo "<td>" . $row['issue_date'] . "</td>";
                            echo "<td>" . $row['due_date'] . "</td>";
                            echo "<td>" . ($row['return_date'] ?? 'Not returned') . "</td>";
                            echo "<td>
                                    <form action='' method='post'>
                                        <input type='hidden' name='issue_id' value='" . $row['issue_id'] . "'>
                                        <button type='submit' name='return' class='btn btn-primary btn-sm'>Return</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <h2>All Details</h2>
                <table class="table">
                    <thead>
                    <tr class="bg-light-gray">
                        <th class="bg-light-gray">Issue ID</th>
                        <th class="bg-light-gray">Issue Date</th>
                        <th class="bg-light-gray">Due Date</th>
                        <th class="bg-light-gray">Return Date</th>
                        <th class="bg-light-gray">Item ID</th>
                        <th class="bg-light-gray">Officer ID</th>
                        <th class="bg-light-gray">Student ID</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch all details from the issued table
                        $all_details_query = "SELECT * FROM issued";
                        $all_details_result = mysqli_query($connection, $all_details_query);

                        // Display all details
                        while ($row = mysqli_fetch_assoc($all_details_result)) {
                            echo "<tr>";
                            echo "<td>" . $row['issue_id'] . "</td>";
                            echo "<td>" . $row['issue_date'] . "</td>";
                            echo "<td>" . $row['due_date'] . "</td>";
                            echo "<td>" . ($row['return_date'] ?? 'Not returned') . "</td>";
                            echo "<td>" . $row['item_id'] . "</td>";
                            echo "<td>" . $row['officer_id'] . "</td>";
                            echo "<td>" . $row['student_id'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

