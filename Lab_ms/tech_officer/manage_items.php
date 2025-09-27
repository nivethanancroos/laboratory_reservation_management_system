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

// Fetch all item records from the database
$query = "SELECT * FROM lab_item";
$result = mysqli_query($connection, $query);

// Handle form submissions for adding, editing, and deleting items
if (isset($_POST['add'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Insert the new item record into the database
    $insert_query = "INSERT INTO lab_item (name, price) VALUES ('$name', '$price')";
    if (mysqli_query($connection, $insert_query)) {
        // If insertion is successful, refresh the page to show the updated item list
        header("Location: manage_items.php");
        exit();
    } else {
        // If insertion fails, you can handle the error as needed
        echo "Error adding item: " . mysqli_error($connection);
    }
}

if (isset($_POST['edit'])) {
    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Update the item record in the database
    $update_query = "UPDATE lab_item SET name='$name', price='$price' WHERE item_id=$id";
    if (mysqli_query($connection, $update_query)) {
        // If update is successful, refresh the page to show the updated item list
        header("Location: manage_items.php");
        exit();
    } else {
        // If update fails, you can handle the error as needed
        echo "Error updating item: " . mysqli_error($connection);
    }
}

if (isset($_GET['delete'])) {
    // Retrieve the item ID to be deleted
    $id = $_GET['delete'];

    // Check if there are any associated records in the issued table where return_date is null
    $check_query = "SELECT * FROM issued WHERE item_id = $id AND return_date IS NULL";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Associated records with null return_date found, display alert
        echo "<script>alert('Cannot delete item. There are associated records with null return dates in the Issued table.');</script>";
    } else {
        // No associated records found with null return_date, proceed with deletion

        // Delete the item record from the issued table
        $delete_issued_query = "DELETE FROM issued WHERE item_id = $id";
        if (!mysqli_query($connection, $delete_issued_query)) {
            // If deletion from issued table fails, handle the error as needed
            echo "Error deleting item from issued table: " . mysqli_error($connection);
            exit(); // Exit the script to prevent further execution
        }

        // Delete the item record from the lab_item table
        $delete_lab_item_query = "DELETE FROM lab_item WHERE item_id = $id";
        if (mysqli_query($connection, $delete_lab_item_query)) {
            // If deletion from lab_item table is successful, refresh the page to show the updated item list
            header("Location: manage_items.php");
            exit();
        } else {
            // If deletion from lab_item table fails, handle the error as needed
            echo "Error deleting item from lab_item table: " . mysqli_error($connection);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
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
<div class="container">
    <h1>Manage Items</h1>
    <br>
    <!-- Button to trigger the add item modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">
        <i class="fas fa-plus"></i> Add Item
    </button>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Item</h5>
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
                            <label for="addPrice">Price</label>
                            <input type="number" class="form-control" id="addPrice" name="price" required>
                        </div>
                        <button type="submit" name="add" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Item Records</h2>
            <table class="table">
                <thead>
                    <tr class="bg-light-gray">
                        <th class="bg-light-gray">ID</th>
                        <th class="bg-light-gray">Name</th>
                        <th class="bg-light-gray">Price</th>
                        <th class="bg-light-gray">Actions</th>
                    </tr>

                </thead>
                <tbody>
                <?php
                // Display item records
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['item_id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>
                            <a href='#' class='btn btn-primary btn-sm edit-btn' data-id='" . $row['item_id'] . "' data-name='" . $row['name'] . "' data-price='" . $row['price'] . "' data-toggle='modal' data-target='#editModal'><i class='fas fa-edit'></i> Edit</a>
                            <a href='manage_items.php?delete=" . $row['item_id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
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
                        <label for="editPrice">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price">
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Populate edit modal with selected item data
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');

        $('#editId').val(id);
        $('#editName').val(name);
        $('#editPrice').val(price);
    });
</script>

</body>
</html>
