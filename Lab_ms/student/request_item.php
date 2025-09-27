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

// Function to insert a request
function insertRequest($connection, $student_id, $item_name) {
    $insert_query = "INSERT INTO Request (student_id, item_name) VALUES ($student_id, '$item_name')";
    return mysqli_query($connection, $insert_query);
}

// Function to delete a request
function deleteRequest($connection, $student_id, $item_name) {
    $delete_query = "DELETE FROM Request WHERE student_id = $student_id AND item_name = '$item_name'";
    return mysqli_query($connection, $delete_query);
}

// Handle request action
if (isset($_POST['action']) && $_POST['action'] == 'request') {
    $student_id = $_SESSION['student_id'];
    $item_name = $_POST['item_name'];
    insertRequest($connection, $student_id, $item_name);
    header("Location: request_item.php");
    exit();
}

// Handle cancel request action
if (isset($_POST['action']) && $_POST['action'] == 'cancel_request') {
    $student_id = $_SESSION['student_id'];
    $item_name = $_POST['item_name'];
    deleteRequest($connection, $student_id, $item_name);
    header("Location: request_item.php");
    exit();
}

// Fetch available items for request
$query = "SELECT name
          FROM lab_item
          WHERE item_id IN (
              SELECT DISTINCT item_id
              FROM issued
              WHERE return_date IS NOT NULL
              AND item_id NOT IN (
                  SELECT DISTINCT item_id
                  FROM issued
                  WHERE return_date IS NULL
              )
          )
          UNION
          SELECT name
          FROM lab_item
          WHERE item_id NOT IN (
              SELECT DISTINCT item_id
              FROM issued
          )";

$query_run = mysqli_query($connection, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="student_dashboard.php">Library Management System (LMS)</a>
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
        <h1>Request Items</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($query_run && mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            echo "<tr>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>";
                            // Check if the item is requested by the current user
                            $request_query = "SELECT * FROM Request WHERE student_id = (SELECT student_id FROM Student WHERE email = '$_SESSION[email]') AND item_name = '" . $row['name'] . "'";
                            $request_run = mysqli_query($connection, $request_query);
                            if ($request_run && mysqli_num_rows($request_run) > 0) {
                                // If item is requested, display cancel request button
                                echo "<form action='request_item.php' method='POST'>";
                                echo "<input type='hidden' name='action' value='cancel_request'>";
                                echo "<input type='hidden' name='item_name' value='" . $row['name'] . "'>";
                                echo "<button class='btn btn-danger' type='submit'>Cancel Request</button>";
                                echo "</form>";
                            } else {
                                // If item is not requested, display request button
                                echo "<form action='request_item.php' method='POST'>";
                                echo "<input type='hidden' name='action' value='request'>";
                                echo "<input type='hidden' name='item_name' value='" . $row['name'] . "'>";
                                echo "<button class='btn btn-primary' type='submit'>Request</button>";
                                echo "</form>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No items available for request.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
