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

// Fetch all request records from the database sorted by timestamp
$query = "SELECT * FROM request ORDER BY timestamp ASC";
$result = mysqli_query($connection, $query);

// Check if there is a success message stored in the session
if (isset($_SESSION['success_message'])) {
    // Display the success message and then unset it from the session
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

// Check if the request buttons are clicked (issue or reject)
if (isset($_POST['issue']) || isset($_POST['reject'])) {
    // Retrieve the request id
    $request_id = $_POST['request_id'];

    // Check which button is clicked
    // Check if the request buttons are clicked (issue or reject)
// Check if the request buttons are clicked (issue or reject)
if (isset($_POST['issue'])) {
    // Retrieve request details
    $request_id = $_POST['request_id'];
    $student_id = $_POST['student_id'];
    $item_name = $_POST['item_name'];

    // Check if there are any returned items with the same name available for issuing
    $available_item_query = "SELECT MIN(item_id) AS min_item_id FROM 
        (SELECT item_id FROM issued 
         WHERE item_id IN (
             SELECT item_id FROM lab_item WHERE name = '$item_name'
         ) AND return_date IS NOT NULL
         UNION
         SELECT item_id FROM lab_item 
         WHERE name = '$item_name' AND item_id NOT IN (
             SELECT item_id FROM issued
         )
    ) AS priority_items";

    $available_item_result = mysqli_query($connection, $available_item_query);

    if ($available_item_result) {
        // Check if any rows are returned
        if (mysqli_num_rows($available_item_result) > 0) {
            // Fetch the result row
            $item_row = mysqli_fetch_assoc($available_item_result);
            $item_id = $item_row['min_item_id'];

            // Calculate due date (14 days from current timestamp)
            $due_date = date('Y-m-d H:i:s', strtotime('+14 days'));

            // Insert into issued table
            $insert_issued_query = "INSERT INTO issued (issue_date, due_date, item_id, officer_id, student_id) VALUES
                                    (CURRENT_TIMESTAMP, '$due_date', $item_id, 3, $student_id)";
            if (mysqli_query($connection, $insert_issued_query)) {
                // Delete the record from the request table
                $delete_request_query = "DELETE FROM request WHERE request_id = $request_id";
                if (mysqli_query($connection, $delete_request_query)) {
                    // Set success message for issue and deletion
                    $_SESSION['success_message'] = "Request issued successfully and removed from request table.";
                } else {
                    $_SESSION['error_message'] = "Error deleting request record: " . mysqli_error($connection);
                }
            } else {
                // Display error message if insertion fails
                $_SESSION['error_message'] = "Error issuing item: " . mysqli_error($connection);
            }
        } else {
            // No returned items available for issuing
            $_SESSION['error_message'] = "No items available for issuing.";
        }
    } else {
        // Display error message if query fails
        $_SESSION['error_message'] = "Error querying item availability: " . mysqli_error($connection);
    }
}






    else if (isset($_POST['reject'])) {
        // Request is rejected, delete the request record
        $delete_query = "DELETE FROM request WHERE request_id = $request_id";
        if (mysqli_query($connection, $delete_query)) {
            // Set success message for rejection
            $_SESSION['success_message'] = "Request rejected successfully";
        } else {
            // Display error message if deletion fails
            $_SESSION['error_message'] = "Error rejecting request: " . mysqli_error($connection);
        }
    }

    // Redirect to refresh the page
    header("Location: manage_requests.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requests</title>
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
    <h1>Manage Requests</h1>
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Request Records</h2>
            <table class="table">
                <thead>
                    <tr class="bg-light-gray">
                        <th class="bg-light-gray">ID</th>
                        <th class="bg-light-gray">Timestamp</th>
                        <th class="bg-light-gray">Student ID</th>
                        <th class="bg-light-gray">Item Name</th>
                        <th class="bg-light-gray">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display request records if available
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['request_id'] . "</td>";
                            echo "<td>" . $row['timestamp'] . "</td>";
                            echo "<td>" . $row['student_id'] . "</td>";
                            echo "<td>" . $row['item_name'] . "</td>";
                            echo "<td>
                                    <form action='' method='post'>
                                        <input type='hidden' name='request_id' value='" . $row['request_id'] . "'>
                                        <input type='hidden' name='student_id' value='" . $row['student_id'] . "'>
                                        <input type='hidden' name='item_name' value='" . $row['item_name'] . "'>
                                        <button type='submit' name='issue' class='btn btn-success btn-sm'>Issue</button>
                                        <button type='submit' name='reject' class='btn btn-danger btn-sm'>Reject</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        // Display message if no requests available
                        echo "<tr><td colspan='5'>No requests available in the list</td></tr>";
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

    <!-- Add Font Awesome script -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>
