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

// Fetch all student records from the database
$query = "SELECT * FROM Student";
$result = mysqli_query($connection, $query);

// Check if the form is submitted for adding a new student
if (isset($_POST['add'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insert the new student record into the database
    $insert_query = "INSERT INTO Student (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($connection, $insert_query)) {
        // If insertion is successful, redirect to manage_students.php
        header("Location: manage_students.php");
        exit(); // Ensure that no more code is executed after redirection
    } else {
        // If insertion fails, you can handle the error as needed
        echo "Error adding student: " . mysqli_error($connection);
    }
}


// Check if the form is submitted for editing a student
if (isset($_POST['edit'])) {
    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update the student record in the database
    $update_query = "UPDATE Student SET name='$name', email='$email' WHERE student_id=$id";
    if (mysqli_query($connection, $update_query)) {
        // If update is successful, redirect to manage_students.php
        header("Location: manage_students.php");
        exit(); // Ensure that no more code is executed after redirection
    } else {
        // If update fails, you can handle the error as needed
        echo "Error updating student: " . mysqli_error($connection);
    }
}


// Check if the delete button is clicked for a student record
if (isset($_GET['delete'])) {
    // Retrieve the student id to be deleted
    $id = $_GET['delete'];

    // Check if there are any associated records in the Issued table
    $check_query = "SELECT * FROM Issued WHERE student_id = $id";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Associated records found, handle them accordingly
        // For example, you can update their status or display a warning message
        echo "<script>alert('Cannot delete student. There are associated records in the Issued table.'); window.location.href = 'manage_students.php';</script>";
        
    } else {
        // No associated records found, proceed with deletion
        $delete_query = "DELETE FROM Student WHERE student_id = $id";
        if (mysqli_query($connection, $delete_query)) {
            // Deletion successful
            echo "<script>alert('Student deleted successfully');</script>";
            header("Location: manage_students.php"); // Redirect to refresh the page
            exit();
        } else {
            // Deletion failed
            echo "Error deleting record: " . mysqli_error($connection);
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="view_profile.php"><i class="fas fa-user"></i> Profile</a>
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

<div class="container">
    <h1>Manage Students</h1>
    <br>
    <!-- Button to trigger the add student modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">
        <i class="fas fa-user-plus"></i> Add Student
    </button>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="" method="post">
                        <div class="form-group">
                            <label for="addName">Name</label>
                            <input type="text" class="form-control" id="addName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="addEmail">Email</label>
                            <input type="email" class="form-control" id="addEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="addPassword">Password</label>
                            <input type="password" class="form-control" id="addPassword" name="password" required>
                        </div>
                        <button type="submit" name="add" class="btn btn-primary"><i class="fas fa-plus"></i> Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Student Records</h2>
            <table class="table">
                <thead>
                    <tr class="bg-light-gray">
                        <th class="bg-light-gray">ID</th>
                        <th class="bg-light-gray">Name</th>
                        <th class="bg-light-gray">Email</th>
                        <th class="bg-light-gray">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display student records
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>
                                <a href='#' class='btn btn-primary btn-sm edit-btn' data-id='" . $row['student_id'] . "' data-name='" . $row['name'] . "' data-email='" . $row['email'] . "' data-toggle='modal' data-target='#editModal'><i class='fas fa-edit'></i> Edit</a>
                                <a href='manage_students.php?delete=" . $row['student_id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="post">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email">
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script>
    // Populate edit modal with selected student data
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');

        $('#editId').val(id);
        $('#editName').val(name);
        $('#editEmail').val(email);
    });
</script>

</body>
</html>